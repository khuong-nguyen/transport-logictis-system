@extends('layout.app')
@section('title', 'Transport Schedule Registration')
@section('content')
<div class="card">
	<div class="card-header">@lang('report.report_salary_monthly_for_driver')</div>
	<div class="card-body">
		<div class="main-form" class="row">
			<div class="full-search">
				<div class="form-group row">
                    <div class="col-md-2 pr-0">
                        <label class="col-form-label" for="salary_month_from">Salary Month </label>
                    </div>
                    <div class="input-group col-md-4 input-daterange pr-0">
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
                	<div class="col-md-2 pr-0">
                        <label class="col-form-label" for="driver_code">Driver Code </label>
                    </div>
                    <div class="md-2">
                        <input class="form-control" id="driver_code" value="{{ isset($params['driver_code']) ? $params['driver_code'] : '' }}" type="text" name="driver_code" autocomplete="off">
                    </div>
                    <div class="col-md-2">
                        <label class="col-form-label" for="driver_code">Driver Name </label>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" id="driver_name" value="{{ isset($params['driver_name']) ? $params['driver_name'] : '' }}" type="text" name="driver_name" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                	<div class="col-md-2">
                        <button type="button" class="btn btn-primary btn-search-salary-monthly-driver">Search</button>
                    </div>
                </div>
                <div class="form-group row">
                	<table class="table table-container-list table-bordered table-striped table-inverse table-hover table-responsive" style="overflow-y:scroll">
                        <thead>
                        <tr style = "background-color:#020267; color:white;">
                            <th>No.</th>
                            <th>Driver Code</th>
                            <th>Driver Name</th>
                            <th>Month</th>
                            <th>Basic Salary</th>
                            <th>Transport Total</th>
                            <th>Transport Salary</th>
                            <th>Salary Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        	@php
                                $i = 0;
                            @endphp
                        	@foreach ($salary_monthly_driver as $salary_monthly)
                        		@php
                                $i = $i + 1;
                            @endphp
                        		<tr>
                            		<td>{{ $i}}</td>
                            		<td>{{ $salary_monthly["driver_code"] }}</td>
                            		<td>{{ $salary_monthly["driver_name"] }}</td>
                            		<td>{{ $salary_monthly["month"] }}</td>
                            		<td style="text-align: right">{{ $salary_monthly["basic_salary"] }}</td>
                            		<td>{{ $salary_monthly["transport_total"] }}</td>
                            		<td style="text-align: right">{{ $salary_monthly["transport_salary"] }}</td>
                            		<td style="text-align: right">{{ $salary_monthly["salary_total"] }}</td>
                            	</tr>
                        	@endforeach
                        </tbody>
                    </table>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" />
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    
<script type="text/javascript">
	$('#sidebar').removeClass('c-sidebar-lg-show');
	
	$(function () {
		$('#salary_month_from').datetimepicker({
	        format: 'mm/yyyy',
	        date: new Date(),
	        minView:2,
	        autoclose: true
	    });

		$('#salary_month_to').datetimepicker({
	        format: 'mm/yyyy',
	        minView:2,
	        date: new Date(),
	        autoclose: true
	    });
	});
    $('#salary_month_from').on('changeDate', function(e){
   	 $('#salary_month_to').datetimepicker('setStartDate', $('#salary_month_from').data("datetimepicker").getDate());
   	 $('#salary_month_to').val('');
   });
   $('#salary_month_to').on('changeDate', function(e){
   	$('#salary_month_from').datetimepicker('setEndDate', $('#salary_month_to').data("datetimepicker").getDate());
   });

   $('.btn-search-salary-monthly-driver').on('click', e => {

       let driver_code = $('input[name="driver_code"]:visible').val();
       let driver_name = $('input[name="driver_name"]:visible').val();
       
       let salary_month_from = $('input[name="salary_month_from"]:visible').val();
       let salary_month_to = $('input[name="salary_month_to"]:visible').val();

       let query = "salary_month_from" + "=" + salary_month_from;
       query = query + "&" + "salary_month_to" + "=" + salary_month_to;
       query = query + "&" + "driver_code" + "=" + driver_code;
       query = query + "&" + "driver_name" + "=" + driver_name;
       
       document.location.search = query
   });
   
</script>
@endpush