<?php
/**
 * Created by PhpStorm.
 * User: kinkop
 * Date: 1/7/2018 AD
 * Time: 11:17
 */

namespace ImageGallery\Helpers\Api;


use Illuminate\Support\Collection;
use League\Fractal\Manager;
use League\Fractal\Resource;

trait Response
{
    public function response($data, $transformer = null, $message = '', $headers = [], $meta = [])
    {
        $resource = null;
        if ($transformer) {
            if ($data instanceof Collection) {
                //Create resource from set of collection
                $resource = new Resource\Collection($data, $transformer);
            } else {
                //Create resource from single item
                $resource = new Resource\Item($data, $transformer);
            }

            $manager = new Manager();
            $data = $manager->createData($resource)->toArray();
        } else {
            $data = [
                'data' => $data,
            ];
        }

        $data = array_merge($data, [
            'message' => $message,
            'meta' => $meta
        ]);

        return $this->outputResponse($data, $headers);
    }

    public function responseWithPaginate($data, $transformer, $message = '', $headers = [])
    {
        //Handle later if need to use
    }

    public function responseError($message, $errors = [], $status = 400, $headers = [])
    {
        $data = [
            'message' => $message,
            'status' => 'error',
            'status_code' => $status,
            'errors' => $errors
        ];

        return $this->outputResponse($data, $headers);
    }


    protected function outputResponse($data, $headers = [])
    {
        $output = [
            'status' => 'success',
            'status_code' => 200,
            'response' => [],
            'meta' => [],
            'errors' => [],
            'message' => ''
        ];

        $output = array_merge($output, $data);

        return response()->json($output, $output['status_code']);
    }
}