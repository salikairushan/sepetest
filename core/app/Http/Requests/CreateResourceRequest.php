<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateResourceRequest extends Request
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
    public function rules()
    {
        return [
            'room_no' => 'required',
            'room_type' => 'required|numeric',
            'student_count' => 'required|numeric',
            'location' => 'required',
            'active' => 'required'
        ];
    }
}
