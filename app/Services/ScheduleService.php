<?php

namespace App\Services;

use App\Models\Schedule;
use App\Jobs\ImportExcel;
use http\Env\Request;
use Illuminate\Support\Facades\Bus;


class ScheduleService
{
    public function show($request)
    {
        $filterId = $request->filter;
        $itemId = $request->activeOption;
        $date = $request->date;

        if ($filterId == 1) {
            $filter = "group_id";
        } else {
            $filter = "teacher_id";
        }

        $query = Schedule::where($filter, "=", $itemId)->with(['teacher', 'group', 'category']);
        $query->whereBetween("date", [$date[0], $date[1]]);

        return collect($query->orderBy('date')->get())
            ->groupBy('date');
    }
    public function create($id, $filePath, $filter)
    {
        Bus::dispatch(new ImportExcel($filePath, $id, $filter));
    }
}
