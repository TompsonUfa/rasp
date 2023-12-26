<?php

namespace App\Services;

use App\Models\Group;

class GroupService
{
    public function getListWithSearch($search)
    {
        if (empty($search)){
            $groups = Group::get();
        } else {
            $groups = Group::where('title', 'LIKE', '%' . $search . '%')->get();
        }
        return $groups;
    }

    public function deleteGroup($id)
    {
        $group = Group::find($id);

        $group->delete();
    }

    public function editGroup($id, $value)
    {
        $group = Group::find($id);
        $group->title =  $value;

        $group->save();
    }
}
