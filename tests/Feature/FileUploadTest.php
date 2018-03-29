<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\UploadFileTrait;

class FileUploadTest extends TestCase
{
    use UploadFileTrait;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_fluxo_file_tmp()
    {
        $response = $this->uploadFakerTmp();

        $response->assertJson([
                "success" => true,
                "message" => "Arquivo salvo com sucesso"
            ]
        );

        Storage::assertExists('public/temp/' . $response->original['data']);

        $newResponse = $this->deleteJson(route('remove.tmp', $response->original['data']));

        $newResponse->assertExactJson([
            "success" => true,
            "message" => "Arquivo removido com sucesso",
            "data" => $response->original['data']
        ]);
    }


}
