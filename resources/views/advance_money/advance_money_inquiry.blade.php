@extends('layout.app')
@section('title', 'Advance Money Inquiry')
@section('content')
    <link href="{{ asset('bootstrap/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">@lang('advance_money.advance_money_inquiry')</div>
                <div class="card-body container-fluid">
                    <div class="alert alert-success d-none" id="msg"></div>
                    @csrf
                    <div class="row form-group">
                        <label class="col-form-label col-md-2"  for="advance_money_date">Advance Money Date</label>
                        <input class="form-control col-md-1" id="advance_money_date" type="text" name="advance_money_date" value="{{ old('advance_money.advance_money_date')?old('advance_money.advance_money_date'):app('request')->input('advance_money_date') }}" autocomplete="off">
                    	<label class="col-md-2 col-form-label" for="employee_code">Advance Money Code</label>
                        <input class="form-control col-md-1" id="advance_money_code" name="advance_money_code" type="text" value="{{ old('advance_money.advance_money_code')?old('advance_money.advance_money_code'):app('request')->input('advance_money_code')  }}" autocomplete="off">
                    	<label class="col-form-label col-md-1"  for="advance_money_date">BKG No</label>
                        <input class="form-control col-md-1" id="booking_no" type="text" name="booking_no" value="{{ old('advance_money.booking_no')?old('advance_money.booking_no'):app('request')->input('booking_no') }}" autocomplete="off">
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 col-form-label"  for="advance_money_employee_code">Recieved Employee Code</label>
                        <input class="form-control col-md-1" id="advance_money_employee_code" type="text" name="advance_money_employee_code" value="{{ old('advance_money.advance_money_employee_code')?old('advance_money.advance_money_employee_code'):app('request')->input('advance_money_employee_code') }}" autocomplete="off">
                        <label class="col-form-label col-md-2"  for="advance_money_employee_name">Recieved Employee Name</label>
                        <input class="form-control col-md-3" id="advance_money_employee_name" type="text" name="advance_money_employee_name" value="{{ old('advance_money.advance_money_employee_name')?old('advance_money.advance_money_employee_name'):app('request')->input('advance_money_employee_name') }}" autocomplete="off">
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 col-form-label"  for="give_money_employee_code">Given Employee Code</label>
                        <input class="form-control col-md-1" id="give_money_employee_code" type="text" name="give_money_employee_code" value="{{ old('advance_money.give_money_employee_code')?old('advance_money.give_money_employee_code'):app('request')->input('give_money_employee_code') }}" autocomplete="off">
                        <label class="col-form-label col-md-2"  for="give_money_employee_name">Given Employee Name</label>
                        <input class="form-control col-md-3" id="give_money_employee_name" type="text" name="give_money_employee_name" value="{{ old('advance_money.give_money_employee_name')?old('advance_money.give_money_employee_name'):app('request')->input('give_money_employee_name') }}" autocomplete="off">
                    </div>
                    <div class="form-group text-center">
                        <div class="btn-group">
                            <button class="btn btn-primary" id="resetForm" type="button"> Reset</button>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-primary" id="searchForm" type="button"> Search</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="inquiryDatatable" class="table table-striped table-bordered  w-100">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Advance Money Code.</th>
                                <th>Advance Money Date</th>
                                <th>Boooking No</th>
                                <th>Advance Money</th>
                                <th>Reciever Employee Name</th>
                                <th>Given Employee Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
    
   		 $('#sidebar').removeClass('c-sidebar-lg-show');
   		 
        $(function () {
            @if(session()->has('status'))
            toastr.success("{{ session()->get('status') }}");
            @endif
            fill_datatable();
            function fill_datatable()
            {
                var search = {
                    columns:{
                    	advance_money_code: $('#advance_money_code').val(),
                    	advance_money_date: $('#advance_money_date').val(),
                        booking_no: $('#booking_no').val(),
                        advance_money_employee_name: $('#advance_money_employee_name').val(),
                        give_money_employee_name: $('#give_money_employee_name').val(),
                    },
                };
                var dataTable = $('#inquiryDatatable').DataTable({
                    processing: true,
                    serverSide: true,
                    "searching": false,
                    "sPaginationType":"full_numbers",
                    "iDisplayLength": 10,
                    dom: '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
                    ajax:{
                        url: "/advance_money/inquiry",
                        data: {search: search}
                    },
                    columns: [
                        {
                            data:'id',
                            name:'id'
                        },
                        {
                            data:'advance_money_code',
                            name:'advance_money_code'
                        },
                        {
                            data:'advance_money_date',
                            name:'advance_money_date'
                        },
                        {
                            data:'booking_no',
                            name:'booking_no'
                        },
                        {
                            data:'advance_money',
                            name:'advance_money'
                        },
                        {
                            data:'advance_money_employee_name',
                            name:'advance_money_employee_name'
                        },
                        {
                            data:'give_money_employee_name',
                            name:'give_money_employee_name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: true,
                            searchable: true
                        },
                    ]
                });
                $('div.dataTables_length select').removeClass('form-control-sm');
                $('div.dataTables_length select').removeClass('form-control');
            }
            $('#searchForm').click(function(){
                $('#inquiryDatatable').DataTable().destroy();
                fill_datatable();
            });
            $('#resetForm').click(function(){
                $('input').each(function() {
                    $(this).val('');
                });
                $('#inquiryDatatable').DataTable().destroy();
                fill_datatable();
            });
            $('#inquiryDatatable').on('click', '.delete[data-remote]', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('innput[name="_token"]').val()
                    }
                });
                var url = $(this).data('remote');
                var proceed = confirm("Are you sure you want to delete it?");
                if (proceed){
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {_method: 'DELETE', submit: true,_token:"{{ csrf_token() }}"},
                        success: function(msg){
                            toastr.success('Deleted success!');
                        },
                        error: err => {
                            toastr.error(err.responseJSON.message)
                        }
                    }).always(function (data) {
                        $('#inquiryDatatable').DataTable().draw(false);
                    });
                }
            });
        });
    </script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/dataTables.bootstrap4.min.js') }}"></script>
@endsection
