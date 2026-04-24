<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the public homepage.
     */
    public function index(): View
    {
        return view('pages.home');
    }
}
