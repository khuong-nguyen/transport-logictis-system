<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvanceMoney extends Model
{
    use SoftDeletes;
    
    protected $table = 'advance_money';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'advance_money_employee_code',  'advance_money_employee_name',
        'give_money_employee_code',  'give_money_employee_name','advance_money_code',
        'advance_money_type','advance_money_employee_id','give_money_employee_id',
        'advance_money','advance_money_reason','booking_no','booking_id',
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
