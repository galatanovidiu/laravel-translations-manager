<?php

namespace Tests\Unit;

use App\Translations\ImportFromCSV;
use App\Translations\ImportFromJSON;
use App\Translations\ImportTextsForTranslation;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class IsImportWorkingTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_import_from_csv()
    {

        $test_array = ['a', 'b', 'c'];

        $test_csv_file_content = file_get_contents(dirname(__FILE__) . ('/../stubs/strings.csv'));

        $imported_text = (new ImportTextsForTranslation($test_csv_file_content, new ImportFromCSV()))->import();

        $this->assertEquals($imported_text, $test_array);
    }


    public function test_import_from_json()
    {
        $test_array = ['d', 'e', 'f'];

        $test_json_file_content = file_get_contents(dirname(__FILE__) . ('/../stubs/strings.json'));

        $imported_text = (new ImportTextsForTranslation($test_json_file_content, new ImportFromJSON()))->import();

        $this->assertEquals($imported_text, $test_array);
    }

    public function test_is_only_importing_strings_that_does_not_exists()
    {
        $test_array = ['h', 'i'];

        $test_json_file_content = file_get_contents(dirname(__FILE__) . ('/../stubs/strings_duplicates.json'));

        $imported_text = (new ImportTextsForTranslation($test_json_file_content, new ImportFromJSON()))->import();

        $this->assertEquals($imported_text, $test_array);
    }


}
