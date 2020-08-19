<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleTransportContainer extends Model
{
    protected $table ='scheduled_transport_container';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'booking_id', 'booking_no', 'container_id', 'booking_container_id', 'booking_container_detail_id', 'container_no', 'etd', 'act_td', 'eta', 'act_ta', 'container_truck_id',
        'container_truck_code', 'driver_id', 'driver_name', 'hour_number_alarm', 'schedule_status', 'reason_delay', 'start_location', 'start_address', 'end_location', 'end_address', 'vgm', 'created_by', 'updated_by'

    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    protected $attributes = [
        'booking_id' => null,
        'booking_no' => null,
        'container_id' => null,
        'booking_container_id' => null,
        'container_no' => null,
        'seal_no_1' => null,
        'seal_no_2' => null,
        'package' => null,
        'weight' => null,
        'vgm' => null,
        'measure' => null,
        'st' => null,
        'rf' => null
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    ];


    public function container() {
        $this->hasOne(Container::class);
    }

    public function bookingContainerDetail() {
        $this->hasOne(BookingContainerDetail::class);
    }

    public function containerBooking() {
        $this->hasOne(ContainerBooking::class);
    }

    public function booking() {
        $this->hasOne(Booking::class);
    }

    public function driver() {
        $this->hasOne(Employee::class, 'id', 'driver_id')->where('department_code', 'DRIVER');
    }

    public function containerTruck() {
        $this->hasOne(FixedAsset::class)->where('fixed_asset_type', 'TRUCK');
    }
}
