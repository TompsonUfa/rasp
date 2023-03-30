<?php

namespace App\Services;

use App\Models\schedule;

class ScheduleServices
{
    public function show($request)
    {
        $filterId = $request->filter;
        $itemId = $request->activeItem;
        $dateId = $request->activeDate;

        if ($filterId == 1) {
            $filter = "group_id";
        } else {
            $filter = "teacher_id";
        }

        switch ($dateId) {
            case 1:
                echo "i равно 0";
                break;
            case 2:
                echo "i равно 1";
                break;
            case 3:
                echo "i равно 2";
                break;
            case 4:
                echo "i равно 2";
                break;
        }

        $schedule = schedule::where($filter, "=", $itemId)->get();

        dd($schedule);
    }
}
