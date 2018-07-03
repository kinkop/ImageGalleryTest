<?php

namespace Tests\Unit\Repositories;

use ImageGallery\Repositories\ImageUpload\ImageUploadRepositoryInterface;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Console\Kernel;

class ImageUploadRepositoryTest extends TestCase
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
        $repo = app()->make(ImageUploadRepositoryInterface::class);

        $instance = $repo->create([
            'user_id' => 2,
            'mime_type' => 'image/jpeg',
            'size' => 1000,
            'filename' => '2/test.jpg'
        ]);

        $this->assertInstanceOf('ImageGallery\ImageUpload', $instance);

    }

    public function testGetByUser()
    {
        $repo = app()->make(ImageUploadRepositoryInterface::class);

        $repo->create([
            'user_id' => 2,
            'mime_type' => 'image/jpeg',
            'size' => 1000,
            'filename' => '2/test.jpg'
        ]);

        $collection = $repo->getByUser(3);
        $this->assertInstanceOf('Illuminate\Support\Collection', $collection);
    }

    public function testDeleteBelongUser()
    {
        $repo = app()->make(ImageUploadRepositoryInterface::class);

        $repo->create([
            'user_id' => 2,
            'mime_type' => 'image/jpeg',
            'size' => 1000,
            'filename' => '2/test.jpg'
        ]);

        $result = $repo->deleteBelongUser(2, 1);

        $this->assertEquals(1, $result);
    }
}
