<?php

namespace App\Translations;

use App\Models\Text;
use App\Models\Translation;

class TranslationsService
{


    public static function getTranslations(string $language)
    {
        return Text::with(['translation' => fn($q) => $q->where('language', $language)])
            ->orderBy('string', 'asc')->get();

    }

    public static function addStrings(array $strings)
    {
        $imported_strings = [];

        foreach($strings as $string){
            $check = Text::where('string', $string)->first();
            if(!$check){
                $s = new Text();
                $s->string = $string;
                $s->save();

                $imported_strings[] = $string;
            }
        }

        return $imported_strings;
    }

    public static function addStringWithTranslation($text, $translated_text, $language)
    {
        $string = Text::where('string', $text)->first();
        if(!$string){
            $string = new Text();
            $string->string = $text;
            $string->save();
        }

        $translation = Translation::where('text_id', $string->id)->where('language', $language)->first();
        if($translation and $translation['translation']){
            return $translation; // If the translation already exists nothing should be done
        }
        if(!$translation){
            $translation = new Translation();
            $translation->text_id = $string->id;
            $translation->language = $language;
        }
        $translation->translation = $translated_text;
        $translation->save();

        return $translation;
    }

    public static function updateTranslation($string, $translation, $language)
    {
        $translation_model = Translation::where('text_id', $string->id)->where('language', $language)->first();
        if (!$translation_model) {
            $translation_model = new Translation();
            $translation_model->text_id = $string->id;
            $translation_model->language = $language;
        }
        $translation_model->translation = $translation ?: '';
        $translation_model->save();
    }

}
