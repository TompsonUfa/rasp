<?php

namespace App\Imports;

use App\Models\Group;
use App\Models\Teacher;
use App\Models\Category;
use App\Models\Schedule;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;


class SchedulesImport implements WithEvents, WithMultipleSheets
{
    use Importable, RegistersEventListeners;

    public function sheets(): array
    {
        return [
            "Активный" => new ActiveSheetImport(),
        ];
    }
}
class ActiveSheetImport implements ToCollection, WithStartRow
{
    protected $groupId;
    protected $date;
    protected $teacherId;
    protected $categoryId;

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
    public function collection(Collection $rows)
    {
        $position = 0;

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
                continue;
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
        }
    }
}
