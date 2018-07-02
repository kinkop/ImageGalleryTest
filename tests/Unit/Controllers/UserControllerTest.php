<?php

namespace Tests\Unit\Controllers;

use ImageGallery\Helpers\HttpStatus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Console\Kernel;

class UserControllerTest extends TestCase
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


    public function testStoreUserValidate()
    {
        $response = $this->post('/api/user', []);
        $response
            ->assertStatus(HttpStatus::UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => []
            ]);
    }

    public function testStoreUserSuccess()
    {
        $attributes = [
            'name' => 'Pakin Mankong',
            'email' => $this->email,
            'password' => $this->password
        ];

        $response = $this->post('/api/user', $attributes);
        $response
            ->assertStatus(HttpStatus::OK)
            ->assertJson([
                'status' => 'success'
            ]);
    }
}
