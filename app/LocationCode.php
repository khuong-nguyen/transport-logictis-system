<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationCode extends Model
{
    protected $table = 'location_code';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seq','node_code','node_name','address',
        'created_by',
        'updated_by',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

}