<?php

namespace App\Http\Controllers;

use App\Models\Text;
use App\Translations\Import\Import;
use App\Translations\TranslationsRepository;
use Illuminate\Http\Request;

class TextController extends Controller
{
    public function importStrings(Request $request)
    {

        $file = $request->file('file');

        $strings = Import::import($file);

        TranslationsRepository::addStrings($strings);

        return response(TranslationsRepository::getTranslations($request->selected_language ?: config('translate.default_language')));
    }


}
