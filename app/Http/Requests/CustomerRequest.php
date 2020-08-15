<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'customer.country_code' => 'required|max:30',
            'customer.customer_legal_english_name' => 'required|max:200',
            'customer.city' => 'required|max:30',
            'customer.sale_office_code' => 'required|max:50',
            'customer.sale_rep_code' => 'required|max:50',
        ];
    }
}