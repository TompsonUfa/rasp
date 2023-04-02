<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SchedulesServices;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin');
    }
    public function create(Request $request, SchedulesServices $service)
    {
        $excel = $service->create($request);
    }
}
