<?php

namespace App\Translations\TranslationsSrvices;

interface TranslationServiceInterface
{
    public function translate(string $string, string $target_language, string $source_language): string;
}
