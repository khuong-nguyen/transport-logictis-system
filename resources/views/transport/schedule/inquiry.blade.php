@extends('layout.app')
@section('title', 'Customer Inquiry')
@section('content')
    <link href="{{ asset('bootstrap/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">@lang('sidebar.transport_schedule_inquiry')</div>
                <div class="card-body container-fluid">
                    <div class="alert alert-success d-none" id="msg"></div>
                    @csrf
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="booking_no">BKG No</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="booking_no" name="booking_no" type="text" value="{{ old('schedule.booking_no')?old('customer.booking_no'):app('request')->input('booking_no')  }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="driver_name">Drive name</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="driver_name" name="driver_name" type="text" value="{{ old('schedule.driver_name')?old('customer.driver_name'):app('request')->input('driver_name')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="row">
                                <div class="col-md-4 pr-0">
                                    <label class="col-form-label"  for="container_truck">Container truck</label>
                                </div>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" id="container_truck" type="text" name="container_truck" value="{{ old('schedule.container_truck')?old('schedule.container_truck'):app('request')->input('container_truck') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="etd_from">ETD from</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="etd_from" name="etd_from" type="text" value="{{ old('schedule.etd_from')?old('schedule.etd_from'):app('request')->input('etd_from')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="etd_to">ETD to</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="etd_to" name="etd_to" type="text" value="{{ old('schedule.etd_to')?old('schedule.etd_to'):app('request')->input('etd_to')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="eta_from">ETA from</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="etd_from" name="eta_from" type="text" value="{{ old('schedule.eta_from')?old('schedule.eta_from'):app('request')->input('eta_from')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="eta_to">ETA to</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="etd_to" name="eta_to" type="text" value="{{ old('schedule.eta_to')?old('schedule.eta_to'):app('request')->input('eta_to')}}">
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
                                <th>BKG No</th>
                                <th>Con</th>
                                <th>Con No</th>
                                <th>Router</th>
                                <th>ETD</th>
                                <th>ETA</th>
                                <th>Container Truck</th>
                                <th>Driver</th>
                                <th>Driver Name</th>
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
                        url: "/booking/transport/schedule/inquiry",
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
