<?php

namespace ImageGallery\Http\Controllers\Api;

use Illuminate\Http\Request;
use ImageGallery\Helpers\HttpStatus;
use ImageGallery\Helpers\Transformer;
use ImageGallery\Http\Controllers\Controller;
use ImageGallery\Http\Requests\ImageUploadStoreRequest;
use ImageGallery\Repositories\ImageUpload\ImageUploadRepositoryInterface;
use ImageGallery\Repositories\Login\LoginRepositoryInterface;
use ImageGallery\Services\ImageUpload;
use Validator;

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

        //Generate composition
        $mimeTypes = $collection->groupBy('mime_type');

        $mimeTypes = $mimeTypes->map(function ($item, $key) {
            return [
                'name' => $key,
                'files' => $item->count(),
                'size' => $item->sum('size')
            ];
        });

        return $this->response(
            $collection,
            Transformer::getTransformer('image_upload'),
            '',
            [],
            [
                'summary' => [
                    'overview' => [
                        'size' => $collection->sum('size'),
                        'files' => $collection->count()
                    ],
                    'composition' => $mimeTypes->toArray()
                ]
            ]);
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
        //Validate
        $validator = Validator::make($request->all(), ImageUploadStoreRequest::$_rules);
        if ($validator->fails()) {
            return $this->responseError(
                'Validation fails.',
                $validator->errors(), HttpStatus::UNPROCESSABLE_ENTITY);
        }

        //Upload file
        $user = $this->loginRepo->getUser();

        $path = null;
        $imageUpload = null;
        $uploadImageService = new ImageUpload();
        try {
            $path = $uploadImageService->upload($request->file('file'), $user->id);

            $attributes = [
                'user_id' => $user->id,
                'mime_type' => $request->file('file')->getClientMimeType(),
                'size' => $request->file('file')->getSize(),
                'filename' => $path
            ];
            $imageUpload = $this->imageUploadRepo->create($attributes);
        } catch (\Exception $e) {
            return $this->responseError(
                $e->getMessage(),
                [],
                $e->getCode());
        }

        return $this->response(
            $imageUpload,
            Transformer::getTransformer('image_upload'),
            '',
            [],
            [
                'test' => 1
            ]);
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
        $user = $this->loginRepo->getUser();

        try {
            $this->imageUploadRepo->deleteBelongUser($user->id, $id);
        } catch (\Exception $e) {
            return $this->responseError(
                $e->getMessage(),
                [],
                $e->getCode());
        }

        return $this->response(null,
            null,
            'Deleted file successful.');
    }
}
