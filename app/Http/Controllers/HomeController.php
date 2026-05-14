<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        try {
            return view('pages.home');
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            abort(500);
        }
    }
}
