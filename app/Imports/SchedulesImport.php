<?php

namespace App\Imports;

use App\Models\Group;
use App\Models\Teacher;
use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SchedulesImport implements ToCollection, WithStartRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */

    protected $groupId;
    protected $date; //дата пары
    protected $teacherId;
    protected $categoryId;

    public function startRow(): int
    {
        return 5;
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
                $teacherName = trim($row[4]); // получить айди, если нету то создаем.
                $categoryName = trim($row[6]); // получить айди, если нету то создаем.
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

                echo $this->date . " " . $time . " " . $lesson . " " . $this->teacherId . " " . $room . " " . $this->categoryId . "  .";
            }
            $position++;
        }
    }
}
