<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class InternshipReportRequest extends FormRequest
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
            'student_id'    => 'required',
            'file'          => 'required|file|mimes:pdf|max:8192',
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'file.max' => "Maximum file size to upload is 8MB (8192 KB).",
    //     ];
    // }
}
