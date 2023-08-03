<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            return redirect()->route('admin');
        } else {
            return view('login');
        }
    }
    public function login(LoginRequest $request)
    {
        $user = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($user)) {
            $request->session()->regenerate();
            return route('admin');
        }
        return response()->json(["errors" => ['Данные не верны']], 422);
    }
}
