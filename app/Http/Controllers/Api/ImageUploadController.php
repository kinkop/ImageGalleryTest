<?php

namespace ImageGallery\Http\Controllers\Api;

use Illuminate\Http\Request;
use ImageGallery\Helpers\Transformer;
use ImageGallery\Http\Controllers\Controller;
use ImageGallery\Repositories\ImageUpload\ImageUploadRepositoryInterface;
use ImageGallery\Repositories\Login\LoginRepositoryInterface;
use ImageGallery\User;

class ImageUploadController extends ApiController
{
    protected $imageUploadRepo;
    protected $loginRepo;

    function __construct(ImageUploadRepositoryInterface $imageUploadRepo,
                         LoginRepositoryInterface $loginRepo)
    {
        $this->imageUploadRepo = $imageUploadRepo;
        $this->loginRepo = $loginRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->loginRepo->getUser();
        $collection = $this->imageUploadRepo->getByUser($user->id);

        return $this->response(
            $collection, Transformer::getTransformer('image_upload'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
