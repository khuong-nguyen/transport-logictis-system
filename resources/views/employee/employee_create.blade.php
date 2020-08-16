@extends('layout.app')
@section('title', 'Employee Registration')
@section('content')
    <style type="text/css">
        .required:after{
            content:"*";
            color:red;
        }
        .error-messages {
            color: red;
            font-size: 12px;
        }
        .nav-tabs .nav-item .active{
            background:#0E0EFF !important;
            color:#fff !important;
            font-weight: bold;
            border-color: #0E0EFF;
        }
        .nav-tabs-boxed .nav-tabs .nav-link {
            color: #768192
        }
    </style>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">@lang('employee.employee_registration')</div>
                <div class="card-body container-fluid">
                    @if (session('status'))
                        <div class="alert alert-success">@lang(session('status'))</div>
                    @endif
                    <form action="/employee/registration{{ isset($employee) ? '/'.$employee->id :''}}" method="post">
                        @csrf
                        @if(isset($employee))  @method('PUT') @endif
                        <div class="row">
                            <div class="col ">
                                <div class="nav-tabs-boxed form-group">
                                    <ul class="nav nav-tabs" role="tablist" >
                                        <li class="nav-item"><a class="nav-link active" id="employee_tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="profile">Employee Creation</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="cust_tab">
                                            <div class="form-row row">
                                                <div class="col-md-12">
                                                    <div class="card-body border">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label required" for="employee_name">Employee Name</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control @if($errors->has('employee.employee_name')) is-invalid @endif" id="employee_name" value="{{old('employee.employee_name') ?? $employee->employee_name ?? ''}}" type="text" name="employee[employee_name]" required>
                                                                        @error('employee.employee_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="tax_code">Tax Code</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="tax_code" value="{{old('employee.tax_code') ?? $employee->tax_code ?? ''}}" type="text" name="employee[tax_code]">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="employee_address">Address</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="employee_address" value="{{old('employee.employee_address') ?? $employee->employee_address ?? ''}}" type="text" name="employee[employee_address]">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="city">City/Stage</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        {{ Form::select('employee[city]', $cityCodeOptions,(empty($employee->city) ? $cityCodeOptionDefault : $selectedCityCodeOption), ['class'=>'form-control']) }}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="country_code">Country</label>
                                                                    </div>
                                                                    <div class="col-md-3 pr-0">
                                                                        {{ Form::select('employee[country_code]', $countryCodeOptions,(empty($employee->country_code) ? $countryCodeOptionDefault : $selectedCountryCodeOption), ['class'=>'form-control']) }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3 pr-0">
                                                                        <label class="col-form-label" for="zip_code">Zip Code</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="zip_code" value="{{old('employee.zip_code') ?? $employee->zip_code ?? ''}}" type="text" name="employee[zip_code]">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="email">Email</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="email" value="{{old('employee.email') ?? $employee->email ?? ''}}" type="email" name="employee[email]">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="tel">Tel</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="tel" value="{{old('employee.tel') ?? $employee->tel ?? ''}}" type="text" name="employee[tel]">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                        	<div class="col-md-6">
                                                        		<div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="department_code">Department</label>
                                                                    </div>
                                                                    <div class="col-md-3 pr-0">
                                                                        {{ Form::select('employee[department_code]', $departmentCodeOptions,(empty($employee->department_code) ? $departmentCodeOptionDefault : $selectedDepartmentCodeOption), ['class'=>'form-control']) }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="form-row float-right">
                                            <div class="form-group  float-right">
                                                <div class="btn-group">
                                                    <button class="btn btn-primary" type="submit"> Save</button>
                                                </div>
                                                <div class="btn-group">
                                                    <a class="btn btn-primary" href="/" role="button">Close</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection