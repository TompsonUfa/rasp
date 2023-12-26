<?php

namespace App\Services;

use App\Models\Teacher;

class TeacherService
{
    public function getListWithSearch($search)
    {
        if (empty($search)){
            $teachers = Teacher::get();
        } else {
            $teachers = Teacher::where('title', 'LIKE', '%' . $search . '%')->get();
        }
        return $teachers;
    }

    public function deleteTeacher($id)
    {
        $Teacher = Teacher::find($id);

        $Teacher->delete();
    }

    public function editTeacher($id, $value)
    {
        $Teacher = Teacher::find($id);
        $Teacher->title =  $value;

        $Teacher->save();
    }
}
