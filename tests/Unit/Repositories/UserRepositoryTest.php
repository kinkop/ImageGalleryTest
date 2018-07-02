<?php

namespace Tests\Unit\Repositories;

use ImageGallery\Repositories\User\UserRepositoryInterface;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Console\Kernel;

class UserRepositoryTest extends TestCase
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

    public function testCreate()
    {
        $repo = app()->make(UserRepositoryInterface::class);
        $attributes = [
            'name' => 'Pakin Mankong',
            'email' => $this->email,
            'password' => \Hash::make($this->password)
        ];

        $user = $repo->create($attributes);

        $this->assertEquals($attributes['email'], $user->email);

    }

    public function testUpdateUserNotFound()
    {
        $repo = app()->make(UserRepositoryInterface::class);
        $attributes = [
            'name' => 'Pakin Mankong 2',
            'email' => $this->email,
            'password' => \Hash::make($this->password)
        ];

        $user = $repo->update(99999, $attributes);

        $this->assertFalse($user);
    }

    public function testUpdate()
    {
        $repo = app()->make(UserRepositoryInterface::class);
        $attributes = [
            'name' => 'Pakin Mankong 2',
            'email' => $this->email,
            'password' => \Hash::make($this->password)
        ];

        $user = $repo->create($attributes);
        $user = $repo->update($user->id, $attributes);

        $this->assertEquals($attributes['name'], $user->name);
    }
}
