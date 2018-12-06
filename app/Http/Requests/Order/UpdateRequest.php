<?php

namespace App\Http\Requests\Order;

use App\Models\Order\Order;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        Order::getStatusesCodes();
        return [
            'partner_id'    => 'required|exists:partners,id',
            'client_email'  => 'required|email',
            'delivery_dt'   => 'required|date|date_format:Y-m-d H:i:s',
            'product_id'       => 'required|exists:products,id',
            'status'        => 'required|in:0,10,20'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'partner_id'       => 'Партнер',
            'client_email'     => 'Емейл',
            'delivery_date'    => 'Дата доставки',
            'product_id'       => 'Товар',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        // use trans instead on Lang
        return [
            'required' => 'Поле :attribute обязательно для заполенения',
            'email'    => 'Поле :attribute имеет неправильный формат',
        ];
    }
}
