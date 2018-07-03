<?php

namespace Tests\Unit\Services;

use Illuminate\Http\UploadedFile;
use ImageGallery\Services\ImageUpload;
use Tests\TestCase;
use Storage;

class ImageUploadTest extends TestCase
{
    public function testUpload()
    {
        $stub = __DIR__.'/../../test.png';
        $name = str_random(8).'.png';
        $path = sys_get_temp_dir().'/'.$name;

        copy($stub, $path);

        $file = new UploadedFile($path, $name, 'image/png', null, true);

        $service = new ImageUpload();
        $path = $service->upload($file, 'test');

        $this->assertRegExp('/test\//', $path);
    }
}
