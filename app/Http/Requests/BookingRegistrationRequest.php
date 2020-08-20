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
        if ($this->has('confirm-booking') || $this->has('save-container')) {
            return [];
        }

        $validate = [
            'booking.booking_no' => 'required|unique:booking,booking_no,'.$id.'|max:100',
            'booking.b_l_no' => 'required|max:30',
            'booking.tvvd' => 'required|max:50',
            'booking.por_1' => 'required|max:50',
            'booking.cmdt_1' => 'required|max:30',
            'booking.r_d_term_1' => 'required|max:30',
            'booking.pol_1' => 'required|max:30',
            'booking.pod_1' => 'required|max:30',
            'booking.del_1' => 'required|max:30',
            'booking.weight' => 'required|max:10',
            'booking.unit' => 'required|max:10',
            'booking.lofc_1' => 'required|max:10',
            'booking.sailling_due_date' => 'required|date|date_format:Y-m-d',
            'booking.pick_up_dt' => 'nullable|date|date_format:Y-m-d',
            'booking.shipper_id' => 'required',
            'booking.consignee_id' => 'required'
        ];
        
        if ($this->request->get('container'))
        {
            foreach ($this->request->get('container') as $key => $container)
            {
                $validate['container.'.$key.'.eq_sub'] = 'required|numeric|min:1';
            }
        }
        return $validate;
    }
}
