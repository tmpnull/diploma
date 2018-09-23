<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the timetable.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('timetable');
    }
}
