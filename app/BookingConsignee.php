<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingConsignee extends Model
{
    protected $table = 'consignee_booking';
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_legal_english_name',  'customer_language_name',
        'customer_address','customer_code', 'fax','tel','tax_code','country_code', 'city','location_code','zip_code',
        'post_office_box', 'sale_office_code', 'sale_rep_code','customer_type','email','customer_store_address1','customer_store_address2','customer_store_address3',
        'created_by',
        'updated_by','booking_id'
    ];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

}
