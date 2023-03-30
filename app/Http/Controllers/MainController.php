<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ScheduleServices;

class MainController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function show(Request $request, ScheduleServices $service)
    {
        $schedule = $service->show($request);
    }
}
