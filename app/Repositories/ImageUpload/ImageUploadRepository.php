<?php
/**
 * Created by PhpStorm.
 * User: kinkop
 * Date: 2/7/2018 AD
 * Time: 07:55
 */

namespace ImageGallery\Repositories\ImageUpload;


use ImageGallery\ImageUpload;
use ImageGallery\Repositories\BaseRepository;

class ImageUploadRepository extends BaseRepository implements ImageUploadRepositoryInterface
{

    public function create($attributes = [])
    {
        return ImageUpload::create($attributes);
    }

    public function update($id, $attributes = [])
    {
        $imageUpload = ImageUpload::find($id);

        if (!$imageUpload) {
            return false;
        }

        $imageUpload->update($attributes);

        return $imageUpload;
    }

    public function firstOrCreate($attributes = [])
    {
        // TODO: Implement firstOrCreate() method.
    }

    public function updateOrCreate($conditions = [], $attributes = [])
    {
        // TODO: Implement updateOrCreate() method.
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function findOrFail($id)
    {
        // TODO: Implement findOrFail() method.
    }

    public function where($conditions = [])
    {
        // TODO: Implement where() method.
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function delete($id)
    {
        $imageUpload = ImageUpload::find($id);

        if (!$imageUpload) {
            return false;
        }

        $imageUpload->delete();

        return true;
    }

    public function getByUser($userId)
    {
        return ImageUpload::where('user_id', $userId)
            ->get();
    }
}