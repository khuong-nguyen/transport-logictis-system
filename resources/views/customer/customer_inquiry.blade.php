@extends('layout.app')
@section('title', 'Customer Inquiry')
@section('content')
    <link href="{{ asset('bootstrap/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">@lang('sidebar.customer_inquiry')</div>
                <div class="card-body container-fluid">
                    <div class="alert alert-success d-none" id="msg"></div>
                    @csrf
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="customer_code">Customer Code</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="customer_code" name="customer_code" type="text" value="{{ old('customer.customer_code')?old('customer.customer_code'):app('request')->input('customer_code')  }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="location_code">Location Code</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="location_code" name="location_code" type="text" value="{{ old('customer.location_code')?old('customer.location_code'):app('request')->input('location_code')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <div class="col-md-4 pr-0">
                                    <label class="col-form-label"  for="customer_legal_english_name">Legal Name</label>
                                </div>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" id="customer_legal_english_name" type="text" name="customer_legal_english_name" value="{{ old('customer.customer_legal_english_name')?old('customer.customer_legal_english_name'):app('request')->input('customer_legal_english_name') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <div class="col-md-4 pr-0">
                                    <label class="col-form-label"  for="customer_language_name">Language Name</label>
                                </div>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" id="customer_language_name" type="text" name="customer_language_name" value="{{ old('customer.customer_language_name')?old('customer.customer_language_name'):app('request')->input('customer_language_name') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="tax">Tax Code</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="tax" name="tax" type="text" value="{{ old('customer.tax')?old('customer.tax'):app('request')->input('tax_code')}}">
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
                                <th>Customer Code.</th>
                                <th>Location Code</th>
                                <th>Legal Name </th>
                                <th>Language Name</th>
                                <th>Tax Code</th>
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
   		 
        let containerId =[];
        $(function () {
            @if(session()->has('status'))
            toastr.success("{{ session()->get('status') }}");
            @endif
            fill_datatable();
            function fill_datatable()
            {
                var search = {
                    columns:{
                        customer_code: $('#customer_code').val(),
                        location_code: $('#location_code').val(),
                        customer_legal_english_name: $('#customer_legal_english_name').val(),
                        customer_language_name: $('#customer_language_name').val(),
                        tax_code: $('#tax').val(),
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
                        url: "/customer/inquiry",
                        data: {search: search}
                    },
                    columns: [
                        {
                            data:'id',
                            name:'id'
                        },
                        {
                            data:'customer_code',
                            name:'customer_code'
                        },
                        {
                            data:'location_code',
                            name:'location_code'
                        },
                        {
                            data:'customer_legal_english_name',
                            name:'customer_legal_english_name'
                        },
                        {
                            data:'customer_language_name',
                            name:'customer_language_name'
                        },
                        {
                            data:'tax_code',
                            name:'tax'
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
