<?php

namespace App\Services;

use App\Models\schedule;
use Carbon\Carbon;

class SchedulesServices
{
    public function show($request)
    {
        $filterId = $request->filter;
        $itemId = $request->activeOption;
        $dateId = $request->activeDate;

        if ($filterId == 1) {
            $filter = "group_id";
        } else {
            $filter = "teacher_id";
        }

        $today = today();

        $query = schedule::where($filter, "=", $itemId)->with(['teacher', 'category']);

        switch ($dateId) {
            case 1:
                $query->where("date", "=", $today);
                break;
            case 2:
                $query->where("date", "=", Carbon::tomorrow());
                break;
            case 3:
                $weekStartDate = $today->startOfWeek()->format('Y-m-d');
                $weekEndDate = $today->endOfWeek()->format('Y-m-d');
                $query->whereBetween('date', [$weekStartDate, $weekEndDate]);
                break;
            case 4:
                $today->addDays(7);
                $weekStartDate = $today->startOfWeek()->format('Y-m-d');
                $weekEndDate = $today->endOfWeek()->format('Y-m-d');
                $query->whereBetween('date', [$weekStartDate, $weekEndDate]);
                break;
        }

        $schedules = collect($query->orderBy('date')->get())
            ->groupBy('date');


        return $schedules;
    }
}
