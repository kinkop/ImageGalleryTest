<?php

namespace ImageGallery\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageUploadStoreMultipleRequest extends FormRequest
{
    public static $_rules = [
        'file.*' => ['required', 'mimes:jpeg,png']
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
