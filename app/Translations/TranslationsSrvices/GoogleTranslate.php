<?php

namespace App\Translations\TranslationsSrvices;

use Google\Cloud\Translate\V2\TranslateClient;

class GoogleTranslate implements TranslationServiceInterface
{

    public function translate(string $string, string $target_language, string $source_language): string
    {
        $translate = new TranslateClient([
            'key' => env('GOOGLE_TRANSLATE_KEY'),
        ]);

        //TODO: Do some validations on the return values
        return $translate->translate($string, [
            'target' => $target_language,
            'source' => $source_language ?? config('translate.default_language'),

        ])['text'];
    }
}
