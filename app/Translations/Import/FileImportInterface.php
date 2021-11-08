<?php

namespace App\Translations\Import;

interface FileImportInterface
{
    public function get_formatted_text(string $file_contents);
}
