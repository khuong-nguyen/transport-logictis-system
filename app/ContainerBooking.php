<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContainerBooking extends Model
{
    protected $table = 'booking_container';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['booking_id' ,'container_id','vol','eq_sub','soc','created_by','updated_by'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the comments for the blog post.
     */
    public function container()
    {
        return $this->belongsTo('App\Container');
    }

    /**
     * Get booking container details
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details() {
        return $this->hasMany(BookingContainerDetail::class, 'booking_container_id', 'id');
    }

    public function oneContainer() {
        return $this->hasOne(Container::class, 'id', 'container_id');
    }
}