<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class InternshipPlaceRequest extends FormRequest
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
            'name'          => 'required|min:3|max:50',
            'address'       => 'required|min:3|max:50',
            'districts'     => 'required|min:3|max:50',
            'city'          => 'required|min:3|max:50',
            'mentor'        => 'required|min:3|max:30',
            'teacher_id'    => 'required',
            'phone'         => 'required|numeric|digits_between:5,15',
            'quota'         => 'required|integer|max:20',
            'time_in'       => ['required'],['date_format:H:i:s'],
            'time_out'      => ['required'],['date_format:H:i:s'],
        ];
       
    }
}
