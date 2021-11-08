<?php

namespace App\Http\Controllers;

use App\Models\Text;
use App\Models\Translation;
use App\Translations\TranslationsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TranslationController extends Controller
{

    public function index(Request $request)
    {
        return response(TranslationsRepository::getTranslations($request->selected_language ?: config('translate.default_language')));
    }

    public function saveTranslations(Request $request)
    {
        /*
         * TODO: Validate data
         * */

        if($request->translations) {
            foreach ($request->translations as $t) {
                $string = Text::findOrFail($t['id']);
                if ($string) {
                    TranslationsRepository::updateTranslation($string->id, $t['translation']['translation'], $request->selected_language);
                }
            }
        }

        /*
         * TODO: improved info after save; probably add info about how many translations have been added/saved/deleted ???!!!
         * */
        return response(['info' => 'Translations saved successfully']);

    }

    public function importFromLaravel(Request $request)
    {
        $languages = config('translate.languages');
        $laravel_lang_path = base_path("vendor/laravel-lang/lang/json/");
        foreach ($languages as $lang) {
            if (File::isFile($laravel_lang_path . "{$lang['abbr']}.json")) {
                $translations = json_decode(File::get($laravel_lang_path . "{$lang['abbr']}.json"), true);
                foreach ($translations as $key => $value) {
//                    dd($key, $value);
                    TranslationsRepository::addStringWithTranslation($key, $value, $lang['abbr']);
                }
            }
        }

        return response(TranslationsRepository::getTranslations($request->selected_language ?: config('translate.default_language')));
    }
}
