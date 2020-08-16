<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingContainerDetail extends Model
{
    protected $table ='booking_container_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'booking_id', 'booking_no', 'container_id', 'booking_container_id', 'container_no', 'seal_no_1', 'seal_no_2', 'package', 'weight', 'vgm', 'measure',
        'st', 'rf', 'scheduled', 'created_by', 'updated_by'
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

    public function containerBooking() {
        $this->hasOne(ContainerBooking::class);
    }

    public function booking() {
        $this->hasOne(Booking::class);
    }
}
