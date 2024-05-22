<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Password;

class DashboardController extends Controller
{
    public function index() {
        $passwords = auth()->user()->passwords;
        return view('dashboard', compact('passwords'));
    }
}
