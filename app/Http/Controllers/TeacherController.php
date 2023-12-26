<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeacherService;

class TeacherController extends Controller
{
    public function show(Request $request, TeacherService $service)
    {
        $search = $request->get('search');

        $teachers = $service->getListWithSearch($search);

        return $teachers;
    }
    public function delete(Request $request, TeacherService $service)
    {
        $itemId = $request->get('itemId');

        return $service->deleteTeacher($itemId);
    }

    public function edit(Request $request, TeacherService $service)
    {
        $itemId = $request->get('itemId');
        $newValue = $request->get('value');

        return $service->editTeacher($itemId, $newValue);
    }
}
