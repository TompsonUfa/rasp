<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SchedulesServices;
use Illuminate\Support\Facades\Session;

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

    public function status($filename)
    {
        $filename = session('import' . $filename);
        return response([
            'started' => filled(cache("start_date_$filename")),
            'finished' => filled(cache("end_date_$filename")),
            'current_row' => (int) cache("current_row_$filename"),
            'total_rows' => (int) cache("total_rows_$filename"),
        ]);
    }
}
