<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class TransportScheduleRequest extends FormRequest
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
            'schedules.*.etd' => 'required|date_format:d/m/Y H:i',
            'schedules.*.eta' => 'required|date_format:d/m/Y H:i|after:schedules.*.etd',
            'schedules.*.driver_id' => 'nullable',
            'schedules.*.container_truck_id' => 'nullable'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'schedules.*.etd' => 'ETD',
            'schedules.*.eta' => 'ETA'
        ];
    }
}
