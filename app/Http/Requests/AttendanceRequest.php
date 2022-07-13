<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class AttendanceRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
            'teacher_id'    => 'required',
            'date'          => 'required|date|before:tomorrow',
            'time_in'       => ['required'],['date_format:H:i:s'],
            'time_out'      => ['required'],['date_format:H:i:s'],
            'description'   => 'required',
        ];
   
    }
}
