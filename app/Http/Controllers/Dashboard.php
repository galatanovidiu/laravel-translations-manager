<?php

namespace App\Http\Controllers;

use App\Translations\Import;
use App\Translations\TranslationsService;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index()
    {

        $selected_language = $_COOKIE['selected_language'] ?? 'en';

        return inertia('Dashboard', [
            'languages' => config('translate.languages'),
            'initial_selected_language' => $selected_language,
            'initial_translations' => TranslationsService::getTranslations($selected_language),
        ]);
    }

}
