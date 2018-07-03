<?php

namespace Tests\Unit\Controllers;

use Illuminate\Http\UploadedFile;
use ImageGallery\Helpers\HttpStatus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Console\Kernel;

class ImageUploadControllerTest extends TestCase
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

    public function testIndex()
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

        $response = $this->get('/api/image-upload',
            [
                'Authorization' => 'Bearer ' . array_get($json, 'data.access_token'),
                'Accept' => 'application/json'
            ]);


        $response->assertStatus(HttpStatus::OK)
            ->assertJson([
                'data' => []
            ]);
    }

    public function testStoreValidate()
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

        $response = $this->post('/api/image-upload', [
            'file' => ''
        ],
            [
                'Authorization' => 'Bearer ' . array_get($json, 'data.access_token'),
                'Accept' => 'application/json'
            ]);

        $response->assertStatus(HttpStatus::UNPROCESSABLE_ENTITY);
    }

    public function testStore()
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

        $stub = __DIR__.'/../../test.png';
        $name = str_random(8).'.png';
        $path = sys_get_temp_dir().'/'.$name;

        copy($stub, $path);

        $file = new UploadedFile($path, $name, 'image/png', null, true);

        $response = $this->post('/api/image-upload', [
                'file' => $file
            ],
            [
                'Authorization' => 'Bearer ' . array_get($json, 'data.access_token'),
                'Accept' => 'application/json'
            ]);

        $response->assertStatus(HttpStatus::OK)
            ->assertJson([
                'data'=> []
            ]);
    }

    public function testDelete()
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

        $stub = __DIR__.'/../../test.png';
        $name = str_random(8).'.png';
        $path = sys_get_temp_dir().'/'.$name;

        copy($stub, $path);

        $file = new UploadedFile($path, $name, 'image/png', null, true);

        $response = $this->post('/api/image-upload', [
            'file' => $file
        ],
            [
                'Authorization' => 'Bearer ' . array_get($json, 'data.access_token'),
                'Accept' => 'application/json'
            ]);


        $data = json_decode($response->getContent(), TRUE);

        $response = $this->delete('/api/image-upload/' . $data['data']['id'],
            [],
            [
                'Authorization' => 'Bearer ' . array_get($json, 'data.access_token'),
                'Accept' => 'application/json'
            ]);

        $response->assertStatus(HttpStatus::OK);

    }

}
