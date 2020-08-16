<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FixedAssetRequest extends FormRequest
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
            'fixed_asset.fixed_asset_code' => 'required|max:50',
            'fixed_asset.fixed_asset_name' => 'required|max:200',
            'fixed_asset.fixed_asset_type' => 'required|max:30'
        ];
    }
}