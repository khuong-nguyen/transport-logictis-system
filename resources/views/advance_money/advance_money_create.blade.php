@extends('layout.app')
@section('title', 'Advance Money Registration')
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
                <div class="card-header">@lang('advance_money.advance_money_registration')</div>
                <div class="card-body container-fluid">
                    @if (session('status'))
                        <div class="alert alert-success">@lang(session('status'))</div>
                    @endif
                    <form action="/advance_money/registration{{ isset($advance_money) ? '/'.$advance_money->id.'?'.$params :''}}" method="post">
                        @csrf
                        @if(isset($advance_money))  @method('PUT') @endif
                        <div class="row">
                            <div class="col ">
                                <div class="nav-tabs-boxed form-group">
                                    <ul class="nav nav-tabs" role="tablist" >
                                        <li class="nav-item"><a class="nav-link active" id="cust_tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="profile">Advance Money Creation</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="cust_tab">
                                            <div class="form-row row">
                                                <div class="col-md-12">
                                                    <div class="card-body border">
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group row">
                                                                    <div class="col-md-5">
                                                                        <label class="col-form-label required" for="advance_money_employee_code">Advance money person code</label>
                                                                        <input type="hidden" value="{{old('advance_money.advance_money_employee_id')??$advance_money->advance_money_employee_id?? ''}}" name="advance_money[advance_money_employee_id]"  id="advance_money_employee_id">
                                                                    </div>
                                                                    <div class="col-md-4" style ="display:inline">
                                                                        <input class="form-control @if($errors->has('advance_money.advance_money_employee_code')) is-invalid @endif" id="advance_money_employee_code" value="{{old('advance_money.advance_money_employee_code') ?? $advance_money->advance_money_employee_code ?? ''}}" type="text" name="advance_money[advance_money_employee_code]" required>
                                                                         @error('advance_money.advance_money_employee_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <button type="button" class="btn btn-primary" id="advance_money_employee_search" @if(isset($advance_money_employee)) disabled @endif>Search</button>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-5">
                                                                        <label class="col-form-label" for="give_money_employee_code">Give money person code</label>
                                                                        <input type="hidden" value="{{old('advance_money.give_money_employee_id')??$advance_money->give_money_employee_id?? ''}}" name="advance_money[give_money_employee_id]"  id="give_money_employee_id">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="give_money_employee_code" value="{{old('advance_money.give_money_employee_code') ?? $advance_money->give_money_employee_code ?? ''}}" type="text" name="advance_money[give_money_employee_code]">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <button type="button" class="btn btn-primary" id="give_money_employee_search" @if(isset($give_money_employee)) disabled @endif>Search</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <div class="form-group row">
                                                                    <div class="col-md-5">
                                                                        <label class="col-form-label" for="advance_money_employee_name">Advance money person name</label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input class="form-control" id="advance_money_employee_name" value="{{old('advance_money.advance_money_employee_name') ?? $advance_money->advance_money_employee_name ?? ''}}" type="text" name="advance_money[advance_money_employee_name]">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-5">
                                                                        <label class="col-form-label" for="give_money_employee_name">Give money person name</label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input class="form-control" id="give_money_employee_name" value="{{old('advance_money.give_money_employee_name') ?? $advance_money->give_money_employee_name ?? ''}}" type="text" name="advance_money[give_money_employee_name]">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-5">
                                                                        <label class="col-form-label" for="advance_money_type">Advance money type</label>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        {{ Form::select('advance_money[advance_money_type]', $advanceMoneyTypeOptions,(empty($advance_money->advance_money_type) ? $advanceMoneyTypeOptionDefault : $selectedAdvanceMoneyTypeOption), ['class'=>'form-control']) }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-5">
                                                                        <label class="col-form-label" for="booking_no">Booking No</label>
                                                                        <input type="hidden" value="{{old('advance_money.booking_id')??$advance_money->booking_id?? ''}}" name="advance_money[booking_id]"  id="booking_id">
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <input class="form-control" id="booking_no" value="{{old('advance_money.booking_no') ?? $advance_money->booking_no ?? ''}}" type="text" name="advance_money[booking_no]">
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button type="button" class="btn btn-primary btn-search-booking" id="booking_no_search" @if(isset($booking)) disabled @endif>Search</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-5">
                                                                        <label class="col-form-label" for="advance_money">Advance money</label>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <input type="number" min="0" value="{{old('advance_money.advance_money') ?? $advance_money->advance_money?? ''}}" type="text" class="form-control" id="advance_money" name="advance_money[advance_money]">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
              		                                  <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-5">
                                                                        <label class="col-form-label" for="advance_money_date">Advance money  Date</label>
                                                                    </div>
                                                                    <div class="col-md-5 input-group date">
                                                                        <input class="form-control @if($errors->has('advance_money.advance_money_date')) is-invalid @endif " id="advance_money_date" required type="text" name="advance_money[advance_money_date]">
                                                                        @error('advance_money.advance_money_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-5">
                                                                        <label class="col-form-label" for="advance_money_reason">Reason</label>
                                                                    </div>
                                                                    <div class="col-md-10">
                                                                		<textarea class="form-control" id="ext_remark" name="advance_money[advance_money_reason]" rows="9" placeholder="Content..">{{old('advance_money.advance_money_reason') ?? $advance_money->advance_money_reason ?? ''}}</textarea>
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
    <script type="text/javascript">
    $(function () {

        $('#advance_money_date').datetimepicker({
            viewMode: 'days',
            format: 'YYYY-MM-DD',
            date: new Date()
        });
    });

    $('#booking_no_search').click(function (){
        $.ajax({
            url: "/api/booking/code",
            dataType: "json",
            method: 'get',
            data: {
            	search: $('#booking_no').val(),
            },
            success: function (result) {
                $('#booking_id').val(result.data.id);
                $('#booking_no').val(result.data.booking_no);
            },
            error: err => {
                alert(err.responseJSON.message);
            }
        });
    });

    $('#advance_money_employee_search').click(function (){
        $.ajax({
            url: "/api/employee/employee-code",
            dataType: "json",
            method: 'get',
            data: {
            	employeeCode: $('#advance_money_employee_code').val(),
            },
            success: function (result) {
                $('#advance_money_employee_id').val(result.data.id);
                $('#advance_money_employee_code').val(result.data.employee_code);
                $('#advance_money_employee_name').val(result.data.employee_name);
            },
            error: err => {
                alert(err.responseJSON.message);
            }
        });
    });

    $('#give_money_employee_search').click(function (){
        $.ajax({
            url: "/api/employee/employee-code",
            dataType: "json",
            method: 'get',
            data: {
            	employeeCode: $('#give_money_employee_code').val(),
            },
            success: function (result) {
                $('#give_money_employee_id').val(result.data.id);
                $('#give_money_employee_code').val(result.data.employee_code);
                $('#give_money_employee_name').val(result.data.employee_name);
            },
            error: err => {
                alert(err.responseJSON.message);
            }
        });
    });
    
    </script>
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
@endsection
