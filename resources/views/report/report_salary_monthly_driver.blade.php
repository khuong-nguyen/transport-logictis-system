@extends('layout.app')
@section('title', 'Transport Schedule Registration')
@section('content')
<div class="card">
	<div class="card-header">@lang('report.report_salary_monthly_for_driver')</div>
	<div class="card-body">
		<div class="main-form" class="row">
			<div class="full-search">
				<div class="form-group row">
                    <div class="col-md-3 pr-0">
                        <label class="col-form-label" for="salary_month_from">Salary Month </label>
                    </div>
                    <div class="input-group col-md-6 input-daterange pr-0">
                    	<div class='input-group date'>
                            <input class="form-control" id="salary_month_from" value="{{ isset($params['salary_month_from']) ? $params['salary_month_from'] : '' }}" name="salary_month_from" type="text" autocomplete="off">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar">
                                </span>
                            </span>
                            
                            <input class="form-control" id="salary_month_to" value="{{ isset($params['salary_month_to']) ? $params['salary_month_to'] : '' }}" type="text" name="salary_month_to" autocomplete="off">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                	<div class="col-md-3 pr-0">
                        <label class="col-form-label" for="driver_code">Driver Code </label>
                    </div>
                    <div class="col-md-4 pr-0">
                        <input class="form-control" id="driver_code" value="{{ isset($params['driver_code']) ? $params['driver_code'] : '' }}" type="text" name="driver_code" autocomplete="off">
                    </div>
                    <div class="col-md-3 pr-0">
                        <label class="col-form-label" for="driver_code">Driver Name </label>
                    </div>
                    <div class="col-md-6 pr-0">
                        <input class="form-control" id="driver_name" value="{{ isset($params['driver_name']) ? $params['driver_name'] : '' }}" type="text" name="driver_name" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                	<div class="col-md-2">
                        <button type="button" class="btn btn-primary btn-search-salary-monthly-driver">Search</button>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection