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
        'booking_id', 'booking_no', 'container_id', 'booking_container_id', 'containter_no', 'seal_no_1', 'seal_no_2', 'package', 'weight', 'vgm', 'measure',
        'st', 'rf', 'scheduled', 'created_by', 'updated_by'
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
}
