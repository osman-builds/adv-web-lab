<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $message = "Laravel is ready for Tuesday's lab!";
        return view('test', ['msg' => $message]);
    }
}