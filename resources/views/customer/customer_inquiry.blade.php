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
                                    <input class="form-control" id="customer_code" name="customer_code" type="text" value="{{ old('customer.customer_code')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="location_code">Location Code</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="location_code" name="location_code" type="text" value="{{ old('customer.location_code')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <div class="col-md-4 pr-0">
                                    <label class="col-form-label"  for="customer_legal_english_name">Legal Name</label>
                                </div>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" id="customer_legal_english_name" type="text" name="customer_legal_english_name">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <div class="col-md-4 pr-0">
                                    <label class="col-form-label"  for="customer_language_name">Language Name</label>
                                </div>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" id="customer_language_name" type="text" name="customer_language_name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="tax">Tax Code</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="tax" name="tax" type="text" value="{{ old('customer.tax')}}">
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
        let containerId =[];
        $(function () {
            fill_datatable();
            function fill_datatable(search = '')
            {
                var dataTable = $('#inquiryDatatable').DataTable({
                    processing: true,
                    serverSide: true,
                    "searching": false,
                    "sPaginationType":"full_numbers",
                    "iDisplayLength": 10,
                    dom: '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
                    ajax:{
                        url: "/customer/inquiry",
                        data:{search: search}
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
                            data:'tax',
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
            }
            $('#searchForm').click(function(){
                var search = {
                    columns:{
                        customer_code: $('#customer_code').val(),
                        location_code: $('#location_code').val(),
                        customer_legal_english_name: $('#customer_legal_english_name').val(),
                        customer_language_name: $('#customer_language_name').val(),
                        tax: $('#tax').val(),
                    },
                };
                $('#inquiryDatatable').DataTable().destroy();
                fill_datatable(search);
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
                        type: 'DELETE',
                        dataType: 'json',
                        data: {method: 'DELETE', submit: true,_token:"{{ csrf_token() }}"},
                        success: function(msg){
                            if (msg == 1){
                                $('#msg').text("{{trans('message.delete_success')}}")
                            }else
                            {
                                $('#msg').text("{{trans('message.delete_failed')}}")
                                $('#msg').addClass('alert-danger');
                                $('#msg').removeClass('alert-success');
                            }
                            $('#msg').removeClass('d-none');
                        }
                    }).always(function (data) {
                        $('#inquiryDatatable').DataTable().draw(false);
                    });
                }
            });
            $('div.dataTables_length select').removeClass('form-control-sm custom-select-sm');
        });
    </script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/dataTables.bootstrap4.min.js') }}"></script>
@endsection