<?php

namespace App\Http\Controllers\Frontend\Reservation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'first_name'    => 'required|string|min:1',
            'last_name'    => 'required|string|min:1',
            'phone'    => 'required',
            'email'  => 'required|email',
            'children'    => 'nullable|integer|min:0|max:10',
            'adults'    => 'required|integer|min:1|max:20',
        ];
    }
}
