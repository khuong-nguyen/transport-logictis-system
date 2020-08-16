<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FixedAsset extends Model
{
    protected $table = 'fixed_asset';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fixed_asset_name','manuafacture','fixed_asset_code', 'desc','fixed_asset_type',
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