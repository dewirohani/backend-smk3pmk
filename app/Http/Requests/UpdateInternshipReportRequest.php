<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateInternshipReportRequest extends FormRequest
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
            'status_id'     => 'required',
            'description'   => 'required|string|max:4000',
        ];
    }
}
