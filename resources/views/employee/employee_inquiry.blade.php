@extends('layout.app')
@section('title', 'Employee Inquiry')
@section('content')
    <link href="{{ asset('bootstrap/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">@lang('sidebar.employee_inquiry')</div>
                <div class="card-body container-fluid">
                    <div class="alert alert-success d-none" id="msg"></div>
                    @csrf
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="employee_code">Employee Code</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="employee_code" name="employee_code" type="text" value="{{ old('employee.employee_code')?old('employee.employee_code'):app('request')->input('employee_code')  }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <div class="col-md-4 pr-0">
                                    <label class="col-form-label"  for="employee_name">Employee Name</label>
                                </div>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" id="employee_name" type="text" name="employee_name" value="{{ old('employee.employee_name')?old('employee.employee_name'):app('request')->input('employee_name') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <div class="col-md-4 pr-0">
                                    <label class="col-form-label"  for="employee_language_name">Birthday</label>
                                </div>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" id="birthday" type="text" name="birthday" value="{{ old('birthday')?old('birthday'):app('request')->input('birthday') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="tax">Employee Address</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="employee_address" name="employee_address" type="text" value="{{ old('employee.employee_address')?old('employee.employee_address'):app('request')->input('employee_address')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="tax">Card No</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="card_no" name="card_no" type="text" value="{{ old('employee.card_no')?old('employee.card_no'):app('request')->input('card_no')}}">
                                </div>
                            </div>
                        </div>
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
                                <th>Employee Code.</th>
                                <th>Employee Name</th>
                                <th>Birthday</th>
                                <th>Employee Address</th>
                                <th>Card No</th>
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
                        employee_code: $('#employee_code').val(),
                        employee_name: $('#employee_name').val(),
                        birthday: $('#birthday').val(),
                        employee_address: $('#employee_address').val(),
                        card_no: $('#card_no').val(),
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
                        url: "/employee/inquiry",
                        data: {search: search}
                    },
                    columns: [
                        {
                            data:'id',
                            name:'id'
                        },
                        {
                            data:'employee_code',
                            name:'employee_code'
                        },
                        {
                            data:'employee_name',
                            name:'employee_name'
                        },
                        {
                            data:'birthday',
                            name:'birthday'
                        },
                        {
                            data:'employee_address',
                            name:'employee_address'
                        },
                        {
                            data:'card_no',
                            name:'card_no'
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
