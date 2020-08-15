<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_legal_english_name',  'customer_language_name',
        'customer_address','customer_code', 'fax','tel','tax_code','country_code', 'city','location_code','zip_code',
        'post_office_box', 'sale_office_code', 'sale_rep_code','customer_type','email',
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
