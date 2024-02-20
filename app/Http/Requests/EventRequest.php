<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'title' => 'required|max:255',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required_if:is_all_day,on|date_format:Y-m-d|after_or_equal:start_date',
            'start_time' => 'required_unless:is_all_day,on|date_format:H:i',
            'end_time' => 'required_unless:is_all_day,on|date_format:H:i|after_or_equal:start_time',
            'is_all_day' => 'nullable'
        ];
    }
}
