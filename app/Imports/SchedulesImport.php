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
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;


class SchedulesImport implements WithMultipleSheets, WithEvents
{
    public $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $totalRows = $event->getReader()->getTotalRows();
                if (filled($totalRows)) {
                    cache()->forever("total_rows_{$this->id}", array_values($totalRows)[0]);
                    cache()->forever("start_date_{$this->id}", now()->unix());
                }
            },
            AfterImport::class => function (AfterImport $event) {
                cache(["end_date_{$this->id}" => now()], now()->addMinute());
                cache()->forget("total_rows_{$this->id}");
                cache()->forget("start_date_{$this->id}");
                cache()->forget("current_row_{$this->id}");
            },
        ];
    }

    public function sheets(): array
    {
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

        return [

            $firstOptionWeek => new ActiveSheetImport($this->id),
            $secondOptionWeek => new ActiveSheetImport($this->id),
            $thirdOptionWeek => new ActiveSheetImport($this->id),
            $fourthOptionWeek => new ActiveSheetImport($this->id),

            $firstOptionNextWeek => new ActiveSheetImport($this->id),
            $secondOptionNextWeek => new ActiveSheetImport($this->id),
            $thirdOptionNextWeek => new ActiveSheetImport($this->id),
            $fourthOptionNextWeek => new ActiveSheetImport($this->id),

            "Активный" => new ActiveSheetImport($this->id),
        ];
    }
}

class ActiveSheetImport implements ToCollection, WithStartRow, SkipsUnknownSheets
{
    public $id;
    public $groupId;
    public $date;
    public $teacherId;
    public $categoryId;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function onUnknownSheet($sheetName)
    {
        info("Sheet {$sheetName} was skipped");
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

    public function collection(Collection $rows,)
    {
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
                $i = $row_index + 5;
                cache()->forever("current_row_{$this->id}", $i);
                continue;
            } else {
                $i++;
                cache()->forever("current_row_{$this->id}", $i);
            }

            if (trim($row[0]) == "дни") {
                $position = 0;
                $this->date = null;
                continue;
            }

            if (isset($row[1]) && empty($this->date)) {
                $this->date = trim($row[1]);
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

            sleep(1);
        }
    }
}
