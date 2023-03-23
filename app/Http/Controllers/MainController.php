<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Schedule;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class MainController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return view('index', ['groups' => $groups]);
    }
}
