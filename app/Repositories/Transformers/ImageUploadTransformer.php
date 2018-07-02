<?php
/**
 * Created by PhpStorm.
 * User: kinkop
 * Date: 2/7/2018 AD
 * Time: 08:09
 */

namespace ImageGallery\Repositories\Transformers;

use ImageGallery\ImageUpload;
use League\Fractal\TransformerAbstract;

class ImageUploadTransformer extends TransformerAbstract
{

    public function transform(ImageUpload $imageUpload)
    {
        return [
            'id' => $imageUpload->id
        ];
    }

}