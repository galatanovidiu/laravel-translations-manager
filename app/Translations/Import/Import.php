<?php

namespace App\Translations\Import;

use Illuminate\Http\UploadedFile;

class Import
{
    public static function import(UploadedFile $file)
    {
        $extension = $file->clientExtension();
        $content = $file->getContent();
        $adapter = config('translate.import_adapters')[$extension] ?? null;

        if($content and $adapter){
            return (new $adapter)->get_formatted_text($content);
        }

        return null;
    }


}
