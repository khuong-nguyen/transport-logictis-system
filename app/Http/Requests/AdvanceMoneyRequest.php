<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvanceMoneyRequest extends FormRequest
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
            'advance_money.advance_money_employee_code' => 'required|max:30',
            'advance_money.advance_money_employee_name' => 'required|max:200',
            'advance_money.give_money_employee_code' => 'required|max:30',
            'advance_money.give_money_employee_name' => 'required|max:200',
        ];
    }
}