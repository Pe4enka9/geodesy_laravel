<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MainController extends Controller
{
    // Главная
    public function index(): View
    {
        return view('dashboard');
    }
}
