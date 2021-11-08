<?php

namespace App\Translations\Import;

class ImportFromJSON implements FileImportInterface
{

    public function get_formatted_text(string $file_contents) : array
    {
        return json_decode($file_contents, true);
    }
}
