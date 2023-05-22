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
        $service->create($request);
    }

    public function status(Request $request, $uuid)
    {
        //получаем  имя файла, и вытаскиваем запись его айдишник;
        $data = $request->session()->get('import');
        if (isset($data)) {
            foreach ($data as $id => $session) {
                if ($session->id == $uuid) { //если есть совп, записываем результат, удаляем значение сессии и кэш
                    $response = response([
                        'started' => filled(cache("start_date_$session->id")),
                        'finished' => filled(cache("end_date_$session->id")),
                        'current_row' => (int) cache("current_row_$session->id"),
                        'total_rows' => (int) cache("total_rows_$session->id"),
                    ]);
                    if (filled(cache("end_date_$session->id"))) {
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
