<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_name','employee_address','employee_code', 'department_code',
        'fax','tel','tax_code','country_code','city','zip_code','email',
        'birthday', 'sex', 'card_no', 'basic_salary',
        'created_by',
        'updated_by',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    
    public function scheduleTransportContainer(){
        return $this->hasMany(ScheduleTransportContainer::class, 'driver_id', 'id');
    }

}