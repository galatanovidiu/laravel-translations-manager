<?php

namespace App\Translations\Import;

class ImportFromCSV implements FileImportInterface
{

    public function get_formatted_text(string $file_contents): array
    {
        $lines = explode("\n", trim($file_contents));
        $array = array_map(fn($line) => str_getcsv($line), $lines);
        return array_column($array, array_key_first(current($array)));
    }
}
