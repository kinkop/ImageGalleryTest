<?php

namespace Tests\Unit\Contrllers;

use ImageGallery\Helpers\HttpStatus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Console\Kernel;

class LoginControllerTest extends TestCase
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

    public function testLoginValidationNotPassed()
    {
        $response = $this->call('POST',
            '/api/login',
            []);
        $response
            ->assertStatus(HttpStatus::UNPROCESSABLE_ENTITY);
    }

    public function testLoginNotValidCredential()
    {
        $response = $this->call('POST',
            '/api/login',
            [
                'email' => 'dsdsds@gmail.com',
                'password' => 1234
            ]);

        $response
            ->assertStatus(HttpStatus::UNAUTHORIZED);
    }

    public function testLoginValidCredential()
    {
        $user = \ImageGallery\User::create([
            'name' => 'Pakin Mankong',
            'email' => $this->email,
            'password' => \Hash::make($this->password)
        ]);

        $response = $this->call('POST',
            '/api/login',
            [
                'email' => $this->email,
                'password' => $this->password
            ]);

        $response
            ->assertStatus(HttpStatus::OK)
            ->assertJson([
                'status' => 'success'
            ]);
    }

    public function testLogout()
    {
        $user = \ImageGallery\User::create([
            'name' => 'Pakin Mankong',
            'email' => $this->email,
            'password' => \Hash::make($this->password)
        ]);

        $response = $this->call('POST',
            '/api/login',
            [
                'email' => $this->email,
                'password' => $this->password
            ]);


        $json = json_decode($response->getContent(), true);

        $response = $this->post('/api/logout', [],
            [
            'Authorization' => 'Bearer ' . array_get($json, 'data.access_token'),
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(HttpStatus::OK);
        $response->assertJson([
            'status' => 'success'
        ]);
    }
}
