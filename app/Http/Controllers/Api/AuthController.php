<?php
/**
 * Created by PhpStorm.
 * User: kinkop
 * Date: 1/7/2018 AD
 * Time: 10:14
 */

namespace ImageGallery\Http\Controllers\Api;

use Illuminate\Http\Request;
use Auth;
use ImageGallery\Helpers\HttpStatus;
use ImageGallery\Helpers\Transformer;
use ImageGallery\Http\Requests\LoginRequest;
use ImageGallery\Repositories\Login\LoginRepositoryInterface;
use Validator;

class AuthController extends ApiController
{
    protected $transformer = 'login';
    protected $loginRepo;

    function __construct(LoginRepositoryInterface $loginRepo)
    {
        $this->loginRepo = $loginRepo;
    }

    /**
     * Login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credential = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        //Validate
        $validator = Validator::make($request->all(), LoginRequest::$_rules);
        if ($validator->fails()) {
            return $this->responseError(
                'Validation fails.',
                $validator->errors(), HttpStatus::UNPROCESSABLE_ENTITY);
        }

        //Check login
        $passed =  $this->loginRepo->login($credential);

        if (!$passed) {
            return $this->responseError(
                'Invalid email or password.',
                [],
                HttpStatus::UNAUTHORIZED);
        }

        //Get logged in user
        $user = $this->loginRepo->getUser();

        return $this->response(
            $user,
            Transformer::getTransformer($this->transformer),
            'Login successful!');
    }

    public function logout()
    {
        $this->loginRepo->logout();

        return $this->response(
            [],
           null,
            'Logout successful!');
    }
}