<?php

namespace Tests\Feature;

use App\Models\ZipCode;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $zip_codes = ZipCode::all()->pluck('zip_code')->toArray();
        foreach($zip_codes as $code)
        {
            $response = $this->get("api/zip-codes/$code");
            $tmp = json_decode(file_get_contents("https://jobs.backbonesystems.io/api/zip-codes/$code"), true);
            $tmp['settlements']= array_values(collect($tmp['settlements'])->sortBy('key')->toArray());
            fwrite(STDERR, $code."\n");
            $response->assertExactJson($tmp);
        }
    }
}
