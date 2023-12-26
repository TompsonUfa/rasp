<?php

namespace App\Imports;

use App\Models\Group;
use App\Models\Teacher;
use App\Models\Category;
use App\Models\Schedule;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;

class SchedulesImport implements WithMultipleSheets, WithEvents, SkipsUnknownSheets
{
    protected $id;
    protected $sheets = [];
    protected $totalRows;
    protected $filter;

    public function __construct($id, $filter)
    {
        $this->id = $id;
        $this->filter = $filter;
        if ($filter) {
            // текущая неделя
            $today = today();
            $weekStartDate = $today->startOfWeek()->format('d.m');
            $weekEndDate = $today->endOfWeek()->format('d.m.Y');
            $firstOptionWeek = $weekStartDate . "-" . $weekEndDate;
            $secondOptionWeek = $weekStartDate . " -" . $weekEndDate;
            $thirdOptionWeek = $weekStartDate . "- " . $weekEndDate;
            $fourthOptionWeek = $weekStartDate . " - " . $weekEndDate;

            // след. неделя
            $today = today();
            $today->addDays(7);
            $weekStartDate = $today->startOfWeek()->format('d.m');
            $weekEndDate = $today->endOfWeek()->format('d.m.Y');
            $firstOptionNextWeek = $weekStartDate . "-" . $weekEndDate;
            $secondOptionNextWeek = $weekStartDate . " -" . $weekEndDate;
            $thirdOptionNextWeek = $weekStartDate . "- " . $weekEndDate;
            $fourthOptionNextWeek = $weekStartDate . " - " . $weekEndDate;

            array_push(
                $this->sheets,
                $firstOptionWeek,
                $secondOptionWeek,
                $thirdOptionWeek,
                $fourthOptionWeek,
                $firstOptionNextWeek,
                $secondOptionNextWeek,
                $thirdOptionNextWeek,
                $fourthOptionNextWeek,
                "Активный",
            );
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $reader = $event->reader;
                $countList = $this->filter ? $this->sheets : $reader->getSheetNames();
                foreach ($countList as $sheet) {
                    if ($reader->sheetNameExists($sheet)) {
                        $this->totalRows += $reader->getSheetByName($sheet)->getHighestRow();
                    }
                }
                cache()->put("total_rows_{$this->id}", $this->totalRows, 60 * 60 * 24);
                cache()->put("start_date_{$this->id}", now()->unix(), 60 * 60 * 24);
            },
            AfterImport::class => function (AfterImport $event) {
                cache()->put("end_date_{$this->id}", now()->unix(), 60 * 60 * 24);
            },
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        info("Sheet {$sheetName} was skipped");
    }

    public function sheets(): array
    {
        $numberOfSheets = 50;
        $sheetImports = [];
        if ($this->filter) {
            foreach ($this->sheets as $sheet) {
                $sheetImports[$sheet] = new ActiveSheetImport($this->id);
            }
        } else {
            for ($i = 0; $i < $numberOfSheets; $i++) {
                $sheetImports[$i] = new ActiveSheetImport($this->id);
            }
        }
        return $sheetImports;
    }
}

class ActiveSheetImport implements ToCollection, WithStartRow, WithChunkReading
{

    public $groupId;
    public $date;
    public $teacherId;
    public $categoryId;
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function startRow(): int
    {
        return 5;
    }

    public function delete($id)
    {
        Schedule::find($id)->delete();
    }

    public function edit($id, $groupId, $teacherId, $time, $date, $lesson, $room, $categoryId, $position)
    {
        Schedule::where('id', $id)
            ->update([
                'group_id' => $groupId,
                'teacher_id' => $teacherId,
                'time' => $time,
                'date' => $date,
                'lesson' => $lesson,
                'room' => $room,
                'category_id' => $categoryId,
                'position' => $position
            ]);
    }

    public function add($groupId, $teacherId, $time, $date, $lesson, $room, $categoryId, $position)
    {
        Schedule::create([
            'group_id' => $groupId,
            'teacher_id' => $teacherId,
            'time' => $time,
            'date' => $date,
            'lesson' => $lesson,
            'room' => $room,
            'category_id' => $categoryId,
            'position' => $position,
        ]);
    }

    public function check($groupId, $teacherId, $time, $date, $lesson, $room, $categoryId, $position)
    {
        $schedule = Schedule::where('group_id', $groupId)
            ->where('date', $date)
            ->where('position', $position)
            ->first();

        if (empty($schedule)) {
            $this->add($groupId, $teacherId, $time, $date, $lesson, $room, $categoryId, $position); // если записи в базе нет, то добавляем
        } else {
            $scheduleId = $schedule->id;

            $schedule = Schedule::where('id', $scheduleId)
                ->where('teacher_id', $teacherId)
                ->where('time', $time)
                ->where('date', $date)
                ->where('lesson', $lesson)
                ->where('room', $room)
                ->where('category_id', $categoryId)
                ->where('position', $position)
                ->first();

            if (empty($schedule)) {
                $this->edit($scheduleId, $groupId, $teacherId, $time, $date, $lesson, $room, $categoryId, $position); // если запись есть, но данные различаются, то изменяем.
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function collection(Collection $rows)
    {
        try {
            $position = 0;
            $i = 0;
            foreach ($rows as $row_index => $row) {
                if ($row_index == 0) {
                    $nameGroup = trim($row[2]);
                    $group = Group::where('title', '=', $nameGroup)->first();
                    if (empty($group)) {
                        $group = Group::create([
                            'title' => $nameGroup,
                        ]);
                    }
                    $this->groupId = $group->id;
                    if (((int)cache("current_row_{$this->id}")) == 0) {
                        $i = $row_index + 5;
                    } else {
                        $i = (int)cache("current_row_{$this->id}");
                        $i++;
                    };
                    cache()->put("current_row_{$this->id}", $i, 60 * 60 * 24);
                    continue;
                } else {
                    $i++;
                    cache()->put("current_row_{$this->id}", $i, 60 * 60 * 24);
                }

                if (trim($row[0]) == "дни") {
                    $position = 0;
                    $this->date = null;
                    continue;
                }

                if (isset($row[1]) && empty($this->date)) {
                    $this->date = str_replace(' ', '', $row[1]);
                }

                if (isset($row[2])) {
                    $time = trim($row[2]);
                }

                if (isset($row[3]) && isset($row[4]) && isset($row[5]) && isset($row[6])) {
                    $lesson = trim($row[3]);
                    $teacherName = trim($row[4]);
                    $categoryName = trim($row[6]);
                    $room = trim($row[5]);

                    $teacher = Teacher::where('title', '=', $teacherName)->first();
                    if (empty($teacher)) {
                        $teacher = Teacher::create([
                            'title' => $teacherName,
                        ]);
                    }
                    $this->teacherId = $teacher->id;

                    $category = Category::where('title', '=', $categoryName)->first();
                    if (empty($category)) {
                        $category = Category::create([
                            'title' => $categoryName,
                        ]);
                    }
                    $this->categoryId = $category->id;

                    $this->check($this->groupId, $this->teacherId, $time, $this->date, $lesson, $room, $this->categoryId, $position); // проверка записи в базе
                } else {
                    $schedule = Schedule::where('group_id', $this->groupId)
                        ->where('date', $this->date)
                        ->where('position', $position)
                        ->first();
                    if (isset($schedule)) {
                        $this->delete($schedule->id);
                    }
                }

                $position++;
            }
        } catch (\Exception $e) {
            cache()->put("errors_{$this->id}", $e->getMessage());
            throw new \Exception('Ошибка при обработке коллекции: ' . $e->getMessage());
        }
    }
}
