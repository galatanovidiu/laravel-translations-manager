<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index()
    {

        $selected_language = $_COOKIE['selected_language'] ?? 'en';

        return inertia('Dashboard', [
            'languages' => config('translate.languages'),
            'selected_language' => $selected_language,
        ]);
    }

}
