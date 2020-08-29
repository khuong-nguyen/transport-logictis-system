<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefundMoney extends Model
{
    protected $table = 'refund_money';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'advance_money_code','advance_money_id','balance_money','booking_no','booking_id',
        'invoice_attach_file','collect_money_employee_code','collect_money_employee_id',
        'collect_money_employee_name','refund_money','refund_money_code','refund_money_date',
        'refund_money_employee_code','refund_money_employee_id','refund_money_employee_name',
        'refund_money_reason','refund_money_type',
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
