<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvanceMoney extends Model
{
    protected $table = 'advance_money';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'advance_money_employee_code',  'advance_money_employee_name',
        'give_money_employee_code',  'give_money_employee_name',
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
