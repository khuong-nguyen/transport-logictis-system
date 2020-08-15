<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Booking extends Model
{

    protected $table ='booking';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'booking_no', 'tvvd', 'por_1', 'por_2', 'pol_1', 'pol_2', 'pod_1', 'pod_2', 'del_1', 'del_2',
        'r_d_term_1', 'r_d_term_2', 'b_l_no', 'cmdt_1', 'cmdt_2', 'unit', 'lofc_1', 'lofc_2', 'pick_up_cy', 'full_return_cy',
        'bkg_contact_name', 'bkg_contact_email', 'bkg_contact_tel',
        'ext_remark',
        'int_remark',
        'booking_status','si', 'brd', 'fh',
        'weight',
        'shipper_id','forwarder_id','consignee_id','created_by','updated_by','approved_by','virtual_booking_id',
        'sailling_due_date','pick_up_dt'
    ];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    protected $attributes = [
        'si' => false,
        'brd'=>false,
        'fh' => false,
        'booking_status' => false
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'booking_status' => 'boolean',
        'si' => 'boolean'
    ];

    public  function forwarders()
    {
       return $this->hasMany('App\ForwarderBooking','booking_id');
    }

    public  function consignee()
    {
        return $this->belongsTo('App\BookingConsignee');
    }

    public  function shipper()
    {
        return $this->belongsTo('App\ShipperBooking');
    }

    public  function containers()
    {
        return $this->hasMany('App\ContainerBooking','booking_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($booking) {
            $booking->shipper()->delete();
            $booking->forwarders()->delete();
            $booking->consignee()->delete();
        });
    }
    /**
     * Get booking container
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function containerBookings() {
        return $this->hasMany(ContainerBooking::class);
    }
}
