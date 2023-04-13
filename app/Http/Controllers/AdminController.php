<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SchedulesServices;
use Mockery\Undefined;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin');
    }

    public function create(Request $request, SchedulesServices $service)
    {
        $service->create($request);
    }

    public function status()
    {
        $id = session('import');
        return response([
            'started' => filled(cache("start_date_$id")),
            'finished' => filled(cache("end_date_$id")),
            'current_row' => (int) cache("current_row_$id"),
            'total_rows' => (int) cache("total_rows_$id"),
        ]);
    }
}
