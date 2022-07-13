<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class InternshipCertificateRequest extends FormRequest
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
            'student_id'  => 'required',
            'teacher_id'  => 'required',
            'file'        => 'file|mimes:jpeg,png,jpg,svg|max:4096',
        ];
    }
    // public function messages()
    // {
    //     return [
    //         'file.max' => "Maximum file size to upload is 4MB (4096 KB).",
    //     ];
    // }
}
