<?php
/**
 * Created by PhpStorm.
 * User: kinkop
 * Date: 1/7/2018 AD
 * Time: 11:24
 */

namespace ImageGallery\Repositories\Transformers;

use ImageGallery\Repositories\Login\LoginRepositoryInterface;
use ImageGallery\User;
use League\Fractal\TransformerAbstract;

class LoginTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        $loginRepo = app()->make(LoginRepositoryInterface::class);
        $accessToken = $loginRepo->createUserToken($user);
        return [
            'id' => $user->id,
            'name' => $user->name,
            'access_token' => $accessToken->accessToken
        ];
    }

}