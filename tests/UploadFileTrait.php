<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 09/03/2018
 * Time: 17:53
 */

namespace Tests;

use Illuminate\Http\UploadedFile;

trait UploadFileTrait
{
    /**
     * @param bool $returnOnlyName
     * @return \Illuminate\Foundation\Testing\TestResponse;
     */
    public function uploadFakerTmp($returnOnlyName = false)
    {
        $response = $this->post(route('upload.tmp'), [
            'file' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        if($returnOnlyName){
            return $response->original['data'];
        }
        return $response;
    }
}