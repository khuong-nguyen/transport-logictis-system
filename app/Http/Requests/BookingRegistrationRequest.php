<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRegistrationRequest extends FormRequest
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
        $id = $this->route('id');

        $validate = [
            'booking.booking_no' => 'required|unique:booking,booking_no,'.$id.'|max:100',
            'booking.tvvd' => 'required|max:50',
            'booking.por_1' => 'required|max:50',
            'booking.pol_1' => 'required|max:30',
            'booking.pod_1' => 'required|max:30',
            'booking.del_1' => 'required|max:30',
            'booking.unit' => 'required|max:10',
            'booking.sailling_due_date' => 'required|date|date_format:Y-m-d',
            'booking.pick_up_dt' => 'nullable|date|date_format:Y-m-d'
        ];

        if ($this->request->get('container'))
        {
            foreach ($this->request->get('container') as $key => $container)
            {
                $validate['container.'.$key.'.vol'] = 'required|numeric|min:1';
            }
        }
        return $validate;
    }
}
