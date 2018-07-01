<?php
/**
 * Created by PhpStorm.
 * User: kinkop
 * Date: 1/7/2018 AD
 * Time: 19:09
 */

namespace ImageGallery\Repositories\Login;


use ImageGallery\Repositories\RepositoryInterface;
use ImageGallery\User;

interface LoginRepositoryInterface extends RepositoryInterface
{

    public function login($credential);
    public function getUser();
    public function createUserToken(User $user);
    public function logout();
}