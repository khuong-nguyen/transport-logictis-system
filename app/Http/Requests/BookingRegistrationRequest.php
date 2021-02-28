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

        //dd($this->request->get('booking'));

        $validate = [
            //'booking.booking_no' => 'required|unique:booking,booking_no,'.$id.'|max:100',
            'booking.tvvd' => 'required|max:50',
            'booking.por_1' => 'required|max:50',
            'booking.pol_1' => 'required|max:30',
            'booking.pod_1' => 'required|max:30',
            'booking.del_1' => 'required|max:30',
            'booking.unit' => 'required|max:10',
            'booking.sailling_due_date' => 'required|date_format:d/m/Y H:i|after:booking.pick_up_dt',
            'booking.pick_up_dt' => 'required|date_format:d/m/Y H:i'
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
