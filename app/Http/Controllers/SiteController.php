<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Weather\Weather;

class SiteController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }
}
