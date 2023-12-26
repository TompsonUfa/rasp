<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ScheduleService;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin');
    }

    public function create(Request $request, ScheduleService $service)
    {
        $id = $request->get('uuid');
        $file = $request->file('file');
        $filePath = $file->store('temp');
        $filter = $request->boolean('filter');

        $object = (object)["id" => $id];
        $data = $request->session()->get('import');
        if (isset($data)) {
            $request->session()->push('import', $object);
        } else {
            $request->session()->put('import', [$object]);
        }

        $request->session()->save();

        $service->create($id, $filePath, $filter);

    }

    public function status(Request $request, $uuid)
    {
        $data = $request->session()->get('import');
        if (isset($data)) {
            foreach ($data as $id => $session) {
                if ($session->id == $uuid) {

                    $response = response([
                        'started' => filled(cache("start_date_$session->id")),
                        'finished' => filled(cache("end_date_$session->id")),
                        'current_row' => (int)cache("current_row_$session->id"),
                        'total_rows' => (int)cache("total_rows_$session->id"),
                        'errors' => cache("errors_$session->id"),
                    ]);

                    if (filled(cache("errors_$session->id")) || filled(cache("end_date_$session->id"))) {
                        unset($data[$id]);
                        $request->session()->put('import', $data);
                        $request->session()->save();
                    }

                    return $response;
                }
            }
        }
    }
}
