<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleTransportContainer extends Model
{
    use SoftDeletes;
    
    protected $table ='scheduled_transport_container';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'booking_id', 'booking_no', 'container_id', 'booking_container_id', 'booking_container_detail_id', 'container_no', 'pickup_plan', 'act_td', 'delivery_plan','completed_date','assigned_date','inprocess_date','refuse_date','cancel_date', 'act_ta', 'container_truck_id',
        'container_truck_code', 'driver_id', 'driver_name', 'hour_number_alarm', 'schedule_status', 'reason_delay', 'start_location', 'pickup_address', 'end_location', 'delivery_address', 'vgm','transport_cost', 'created_by', 'updated_by'

    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    protected $attributes = [
//        'booking_id' => null,
//        'booking_no' => null,
//        'container_id' => null,
//        'booking_container_id' => null,
//        'container_no' => null,
//        'seal_no_1' => null,
//        'seal_no_2' => null,
//        'package' => null,
//        'weight' => null,
//        'vgm' => null,
//        'measure' => null,
//        'st' => null,
//        'rf' => null
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    ];

    public const SCHEDULE_STATUS = [
        'ASSINGED'     => 'ASSINGED',
        'INPROCESS'    => 'INPROCESS',
        'REFUSE'    => 'REFUSE',
        'COMPLETED'    => 'COMPLETED',
        'DELAY' => 'DELAY',
        'ONTIME' => 'ONTIME',
        'CANCEL' => 'CANCEL'
    ];

    public function oneContainer() {
        $this->hasOne(Container::class);
    }

    public function container()
    {
        return $this->belongsTo('App\Container');
    }

    public function bookingContainerDetail() {
        $this->hasOne(BookingContainerDetail::class);
    }

    public function containerBooking() {
        $this->hasOne(ContainerBooking::class);
    }

    public function booking() {
        return $this->belongsTo('App\Booking');
    }

    public function oneBooking() {
        $this->hasOne(Booking::class);
    }

    public function driver() {
        $this->hasOne(Employee::class, 'id', 'driver_id')->where('department_code', 'DRIVER');
    }

    public function containerTruck() {
        $this->hasOne(FixedAsset::class)->where('fixed_asset_type', 'TRUCK');
    }

    public function getDeliveryPlanAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y H:i');
    }

    public function getPickupPlanAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y H:i');
    }
    
    public function getCompletedDateAttribute($date)
    {
        if(!empty($date)){
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y H:i');
        }
        return $date;
    }
}
