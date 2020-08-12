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
        return [
            'booking.booking_no' => 'required|unique:booking|max:100',
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
        ];
    }
}
