<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LogbookStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            $validator->errors(), 400
        ));
    }
    public function rules()
    {
        return [
            'date'                      => 'required|date',
            'file'                => 'file|mimes:jpeg,png,jpg,svg|max:4096',
            'activity'                  => 'required|string|max:3000',
        ];
    }
}
