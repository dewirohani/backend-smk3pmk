<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LogbookRequest extends FormRequest
{

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
            'student_id'                => 'required',
            'date'           => 'required','date',
            'activity'                  => 'required|string|max:3000',
            'file'                      => 'file|mimes:jpeg,png,jpg,svg|max:4096',
        ];
    }
}
