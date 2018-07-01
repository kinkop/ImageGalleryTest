<?php
/**
 * Created by PhpStorm.
 * User: kinkop
 * Date: 1/7/2018 AD
 * Time: 19:50
 */

namespace Tests\Unit\Repositories;


use Illuminate\Foundation\Testing\RefreshDatabase;
use ImageGallery\Repositories\Login\LoginRepositoryInterface;
use Tests\TestCase;
use Mockery;
use Auth;
use Illuminate\Contracts\Console\Kernel;

class LoginRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $email;
    protected $password;

    protected function setUp()
    {
        parent::setUp();

        $this->email = config('testing.user.email');
        $this->password = config('testing.user.password');
    }

    /**
     * Refresh the in-memory database.
     *
     * @return void
     */
    protected function refreshInMemoryDatabase()
    {
        $this->artisan('migrate');
        $this->artisan('passport:install');

        $this->app[Kernel::class]->setArtisan(null);
    }


    public function mock($class)
    {
        $this->mock = Mockery::mock($class);

        $this->app->instance($class, $this->mock);

        return $this->mock;
    }


    public function testLogin()
    {
        $user = \ImageGallery\User::create([
            'name' => 'Pakin Mankong',
            'email' => $this->email,
            'password' => \Hash::make($this->password)
        ]);

        $loginRepo = app()->make(LoginRepositoryInterface::class);
        $this->assertTrue($loginRepo->login([
            'email' => $user->email,
            'password' => $this->password
        ]));
    }

    public function testGetUser()
    {
        $user = \ImageGallery\User::create([
            'name' => 'Pakin Mankong',
            'email' => $this->email,
            'password' => \Hash::make($this->password)
        ]);

        $loginRepo = app()->make(LoginRepositoryInterface::class);
        $loginRepo->login([
            'email' => $user->email,
            'password' => $this->password
        ]);
        $loggedInUser = $loginRepo->getUser();

        $this->assertEquals($user->id, $loggedInUser->id);
    }

    public function testGetUserToken()
    {
        $user = \ImageGallery\User::create([
            'name' => 'Pakin Mankong',
            'email' => $this->email,
            'password' => \Hash::make($this->password)
        ]);

        $loginRepo = app()->make(LoginRepositoryInterface::class);
        $loginRepo->login([
            'email' => $user->email,
            'password' => $this->password
        ]);

        $loggedInUser = $loginRepo->getUser();

        $token = $loginRepo->createUserToken($loggedInUser);
        $this->assertInstanceOf('Laravel\Passport\PersonalAccessTokenResult', $token);

    }

}