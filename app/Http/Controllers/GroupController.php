<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GroupService;

class GroupController extends Controller
{
    public function show(Request $request, GroupService $service)
    {
        $search = $request->get('search');

        return $service->getListWithSearch($search);
    }
    public function delete(Request $request, GroupService $service)
    {
        $itemId = $request->get('itemId');

        return $service->deleteGroup($itemId);
    }

    public function edit(Request $request, GroupService $service)
    {
        $itemId = $request->get('itemId');
        $newValue = $request->get('value');

        return $service->editGroup($itemId, $newValue);
    }
}
