<?php
/**
 * Created by PhpStorm.
 * User: kinkop
 * Date: 2/7/2018 AD
 * Time: 07:55
 */

namespace ImageGallery\Repositories\ImageUpload;


use ImageGallery\Repositories\RepositoryInterface;

interface ImageUploadRepositoryInterface extends RepositoryInterface
{

    public function getByUser($userId);
    public function deleteBelongUser($userId, $id);

}