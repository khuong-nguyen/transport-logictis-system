<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VirtualBookingContainer extends Model
{
    protected $table = 'virtual_booking_container';
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['virtual_booking_id' ,'container_id','vol','eq_sub','soc','created_by','updated_by','container_code'];

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

    public function oneContainer() {
        return $this->hasOne(Container::class, 'id', 'container_id');
    }
}
