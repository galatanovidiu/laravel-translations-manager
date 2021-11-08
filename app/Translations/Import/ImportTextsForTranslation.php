<?php

namespace App\Translations\Import;

use App\Translations\TranslationsRepository;

class ImportTextsForTranslation
{
    private string $file_content;
    private FileImportInterface $importer;

    public function __construct($file_content, FileImportInterface $importer)
    {
        $this->file_content = $file_content;
        $this->importer = $importer;
    }

    public function import(): array
    {
        $strings = $this->importer->get_formatted_text($this->file_content);
        return TranslationsRepository::addStrings($strings);
    }
}
