<?php
/**
 * Created by PhpStorm.
 * User: kinkop
 * Date: 2/7/2018 AD
 * Time: 06:52
 */

namespace ImageGallery\Repositories\User;


use ImageGallery\Repositories\BaseRepository;
use ImageGallery\User;
use Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function create($attributes = [])
    {
        $attributes['password'] = Hash::make($attributes['password']);
        return User::create($attributes);
    }

    public function update($id, $attributes = [])
    {
        $user = User::find($id);

        if (!$user) {
            return false;
        }

        $user->update($attributes);

        return $user;
    }

    // @codeCoverageIgnoreStart
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
        // TODO: Implement delete() method.
    }
    // @codeCoverageIgnoreEnd
}