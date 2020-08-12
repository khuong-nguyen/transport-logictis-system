<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Container extends Model
{

    protected $table ='container';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'container_code','container_size','created_by','updated_by'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'container_size' => 'int',
    ];

}
