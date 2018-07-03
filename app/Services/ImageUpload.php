<?php
/**
 * Created by PhpStorm.
 * User: kinkop
 * Date: 3/7/2018 AD
 * Time: 12:14
 */

namespace ImageGallery\Services;



use Illuminate\Http\UploadedFile;

class ImageUpload
{

    public function upload(UploadedFile $file, $folder)
    {
        return $file->store($folder, 'image_upload');
    }

}