<?php
/**
 * Created by PhpStorm.
 * User: kinkop
 * Date: 1/7/2018 AD
 * Time: 19:09
 */

namespace ImageGallery\Repositories\Login;


use ImageGallery\Repositories\BaseRepository;
use Auth;
use ImageGallery\User;

class LoginRepository extends BaseRepository implements LoginRepositoryInterface
{
    public function login($credential)
    {
        return Auth::attempt($credential);
    }

    public function getUser()
    {
        return Auth::user();
    }

    public function createUserToken(User $user)
    {
        return $user->createToken('User login via API');
    }

    public function logout()
    {
        return Auth::user()->token()->delete();
    }

    // @codeCoverageIgnoreStart
    public function create($attributes = [])
    {
        // TODO: Implement create() method.
    }

    public function update($id, $attributes = [])
    {
        // TODO: Implement update() method.
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
        // TODO: Implement delete() method.
    }
    // @codeCoverageIgnoreEnd
}