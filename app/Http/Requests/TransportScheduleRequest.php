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
            'schedules.*.pickup_plan' => 'nullable|date_format:d/m/Y H:i',
            'schedules.*.delivery_plan' => 'nullable|date_format:d/m/Y H:i|after:schedules.*.pickup_plan',
            'schedules.*.driver_id' => 'nullable',
            'schedules.*.container_truck_id' => 'nullable',
            'schedules.*.completed_date' => 'nullable',
            'schedules.*.transport_cost' => 'nullable',
            'schedules.*.delivery_address' => 'nullable',
            'schedules.*.pickup_address' => 'nullable',
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
            'schedules.*.pickup_plan' => 'Pickup Plan',
            'schedules.*.delivery_plan' => 'Delivery Plan'
        ];
    }
}
