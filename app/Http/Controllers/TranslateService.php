<?php

namespace App\Http\Controllers;

use App\Mongo\MongoTranslationsCache;
use App\Translations\TranslationsRepository;
use App\Translations\TranslationsSrvices\GoogleTranslate;
use Illuminate\Http\Request;

class TranslateService extends Controller
{

    //
    public function translate(Request $request)
    {

        // TODO: use $request->service to determine which translation service will be used

        $translation = (new GoogleTranslate)->translate($request->string, $request->target_language, $request->source_language ?: config('translate.default_language'));

        TranslationsRepository::updateTranslation($request->string_id, $translation, $request->target_language);

        return response([
            'data' => [
                'string' => $request->string,
                'translation' => $translation,
                'language' => $request->target_language
            ],
            'info' => 'Translation done using google translate service'
        ]);

    }
}
