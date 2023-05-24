<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeachersServices;

class TeachersController extends Controller
{
    public function show(Request $request, TeachersServices $service)
    {
        $search = $request->get('search');

        $teachers = $service->getListWithSearch($search);
        
        return $teachers;
    }
    public function delete(Request $request, TeachersServices $service)
    {
        $itemId = $request->get('itemId');
        
        return $service->deleteTeacher($itemId);
    }

    public function edit(Request $request, TeachersServices $service)
    {
        $itemId = $request->get('itemId');
        $newValue = $request->get('value');
        
        return $service->editTeacher($itemId, $newValue);
    }
}
