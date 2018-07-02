<?php

namespace ImageGallery\Http\Controllers\Api;

use Illuminate\Http\Request;
use ImageGallery\Helpers\HttpStatus;
use ImageGallery\Helpers\Transformer;
use ImageGallery\Http\Requests\UserStoreRequest;
use ImageGallery\Repositories\Login\LoginRepositoryInterface;
use ImageGallery\Repositories\User\UserRepositoryInterface;
use Validator;
use Hash;

class UserController extends ApiController
{
    protected $userRepo;
    protected $loginRepo;

    function __construct(UserRepositoryInterface $userRepo,
                         LoginRepositoryInterface $loginRepo)
    {
        $this->userRepo = $userRepo;
        $this->loginRepo = $loginRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // @codeCoverageIgnoreStart
    public function index()
    {
        //
    }
    // @codeCoverageIgnoreEnd

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // @codeCoverageIgnoreStart
    public function create()
    {
        //
    }
    // @codeCoverageIgnoreEnd

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate
        $validator = Validator::make($request->all(), UserStoreRequest::$_rules);
        if ($validator->fails()) {
            return $this->responseError(
                'Validation fails.',
                $validator->errors(), HttpStatus::UNPROCESSABLE_ENTITY);
        }

        //Store a user
        $attributes = $request->only([
            'name',
            'email',
            'password'
        ]);

        $user = null;
        try {
            $user = $this->userRepo->create($attributes);
        } catch (\Exception $e) {
            return $this->responseError(
                $e->getMessage(),
                $e->getCode());
        }

        //Get logged in user
        $credential = array_only(
            $attributes, [
                'email',
                'password'
            ]);

        $this->loginRepo->login($credential);

        $user = $this->loginRepo->getUser();

        return $this->response(
            $user,
            Transformer::getTransformer('login'),
            'Created user successful!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // @codeCoverageIgnoreStart
    public function show($id)
    {
        //
    }
    // @codeCoverageIgnoreEnd

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // @codeCoverageIgnoreStart
    public function edit($id)
    {
        //
    }
    // @codeCoverageIgnoreEnd

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // @codeCoverageIgnoreStart
    public function update(Request $request, $id)
    {
        //
    }
    // @codeCoverageIgnoreEnd

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // @codeCoverageIgnoreStart
    public function destroy($id)
    {
        //
    }
    // @codeCoverageIgnoreEnd
}
