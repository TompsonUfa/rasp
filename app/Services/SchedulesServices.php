<?php

namespace App\Services;

use App\Models\Schedule;
use App\Jobs\ImportExcel;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Bus;


class SchedulesServices
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

        $schedules = collect($query->orderBy('date')->get())
            ->groupBy('date');


        return $schedules;
    }
    public function create($request)
    {
        $id = $request->get('uuid');
        $file = $request->file('file');
        $filePath = $file->store('temp');
        $filter = $request->get('filter') === "true" ? true : false;
        $object = (object)["id" => $id];

        $data = $request->session()->get('import');
        if (isset($data)) {
            $request->session()->push('import', $object);
        } else {
            $request->session()->put('import', [$object]);
        }

        $request->session()->save();

        Bus::dispatch(new ImportExcel($filePath, $id, $filter));
    }
}
