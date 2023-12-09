<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function resident()
    {
        return view('resident.index');
    }

    public function admin()
    {
        return view('admin.index');
    }
}
