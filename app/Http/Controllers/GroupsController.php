<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GroupsServices;

class GroupsController extends Controller
{
    public function show(Request $request, GroupsServices $service)
    {
        $search = $request->get('search');

        $group = $service->getListWithSearch($search);
        
        return $group;
    }
    public function delete(Request $request, GroupsServices $service)
    {
        $itemId = $request->get('itemId');
        
        return $service->deleteGroup($itemId);
    }

    public function edit(Request $request, GroupsServices $service)
    {
        $itemId = $request->get('itemId');
        $newValue = $request->get('value');
        
        return $service->editGroup($itemId, $newValue);
    }
}
