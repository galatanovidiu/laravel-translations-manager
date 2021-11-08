<?php

namespace App\Http\Controllers;

use App\Models\Text;
use App\Translations\Import\Import;
use App\Translations\TranslationsService;
use Illuminate\Http\Request;

class TextController extends Controller
{
    public function importStrings(Request $request)
    {

        $file = $request->file('file');

        $strings = Import::import($file);

        TranslationsService::addStrings($strings);

        return response(TranslationsService::getTranslations($request->selected_language ?: config('translate.default_language')));
    }


}
