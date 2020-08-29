<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RefundMoneyRequest extends FormRequest
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
            'refund_money.refund_money_employee_code' => 'required|max:30',
            'refund_money.refund_money_employee_name' => 'required|max:200',
            'refund_money.collect_money_employee_code' => 'required|max:30',
            'refund_money.collect_money_employee_name' => 'required|max:200'
        ];
    }
}