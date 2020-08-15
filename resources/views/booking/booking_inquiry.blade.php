@extends('layout.app')
@section('title', 'Booking Registration')
@section('content')
    <link href="{{ asset('bootstrap/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">@lang('sidebar.booking_registration')</div>
                <div class="card-body container-fluid">
                    @if (session('status'))
                        <div class="alert alert-success">@lang(session('status'))</div>
                    @endif
                    @csrf
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="booking_no">BKG No</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="booking_no" name="booking_no" type="text" value="{{ old('booking.booking_no')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <div class="col-md-4 pr-0">
                                    <label class="col-form-label required"  for="b_l_no">B/L No</label>
                                </div>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" id="b_l_no" type="text" name="b_l_no">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="shipper_customer_code">SHBR</label>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" name="shipper_customer_code" id="shipper_customer_code" type="text" value="{{ old('booking.booking_no')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label required" for="consignee_customer_code">CNEE</label>
                                <div class="col-md-8 p-0">
                                    <input class="form-control" name="consignee_customer_code" id="consignee_customer_code" type="text" value="{{ old('booking.booking_no')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label required" for="forwarder_customer_code">FWDR</label>
                                <div class="col-md-8 p-0">
                                    <input class="form-control" name="forwarder_customer_code" id="forwarder_customer_code" type="text" value="{{ old('booking.booking_no')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="tvvd">T/VVD</label>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" id="tvvd" name="tvvd" type="text" value="{{ old('booking.booking_no')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label required"  for="pol">POL</label>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" id="pol" type="text" name="pol">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label required" for="pod">POD</label>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" name="pod" id="pod" type="text" value="{{ old('booking.booking_no')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <label class="col-md-6 pr-0 col-form-label required" for="booking_status">BKG Status</label>
                                <div class="col-md-6 pr-0">
                                    <select class="form-control" id="booking_status" name="booking_status">
                                        <option value="">Please select</option>
                                        <option value="1">Open</option>
                                        <option value="0">Close</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-5">
                                <div class="row ">
                                    <div class="col-md-4 pr-0">
                                        <label class="col-form-label" for="sailling_due_date_from">Sailling Due Date</label>
                                    </div>
                                    <div class="input-group col-md-8 input-daterange pr-0">
{{--                                        <div class="input-group-prepend d-block"><div class="input-group-text">From</div></div>--}}
                                        <input class="form-control" id="sailling_due_date_from" name="sailling_due_date[from]" type="text">
                                        <div class="input-group-prepend d-block"><div class="input-group-text">To</div></div>
                                        <input class="form-control" id="sailling_due_date_to" name="sailling_due_date[to]" type="text">
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="row form-group">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-4 pr-0">
                                        <label class="col-form-label" for="pick_up_dt_from">M'Ty Pick up DT </label>
                                    </div>
                                    <div class="input-group col-md-8 input-daterange pr-0">
{{--                                        <div class="input-group-prepend d-block"><div class="input-group-text">From</div></div>--}}
                                        <input class="form-control" id="pick_up_dt_from" name="pick_up_dt[from]" type="text">
                                        <div class="input-group-prepend d-block"><div class="input-group-text">To</div></div>
                                        <input class="form-control" id="pick_up_dt_to" type="text" name="pick_up_dt[to]">
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
                        <table id="inquiryDatatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>BKG No.</th>
                                <th>Sailling Due Date</th>
                                <th>M'Ty Pick up DT </th>
                                <th>POL</th>
                                <th>POD</th>
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
                    // "infoCallback": function( settings, start, end, max, total, pre ) {
                    //     var api = this.api();
                    //     var pageInfo = api.page.info();
                    //     pgno = pageInfo.page+1;
                    //     return 'Showing '+start+' to '+end+' of '+total+' entries';
                    // },
                    ajax:{
                        url: "/booking/inquiry",
                        data:{search: search}
                    },
                    columns: [
                        {
                            data:'id',
                            name:'id'
                        },
                        {
                            data:'booking_no',
                            name:'booking_no'
                        },
                        {
                            data:'sailling_due_date',
                            name:'sailling_due_date'
                        },
                        {
                            data:'pick_up_dt',
                            name:'pick_up_dt'
                        },
                        {
                            data:'pol_1',
                            name:'pol_1'
                        },
                        {
                            data:'pod_1',
                            name:'pod_1'
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
                var  sailling_due_date= {from:$('#sailling_due_date_from').val(),to:$('#sailling_due_date_to').val()} ;
                var  pick_up_dt= {from:$('#pick_up_dt_from').val(),to:$('#pick_up_dt_to').val()} ;
                if (sailling_due_date.from > sailling_due_date.to || pick_up_dt.from > pick_up_dt.to ||
                    sailling_due_date.to < sailling_due_date.from || pick_up_dt.to < pick_up_dt.from
                ){
                    alert('Input value was wrong!');
                }
                var search = {
                    columns:{
                        booking_no: $('#booking_no').val(),
                        b_l_no: $('#b_l_no').val(),
                        tvvd: $('#tvvd').val(),
                        booking_status: $('#booking_status').val(),
                    },
                    shipper_customer_code: $('#shipper_customer_code').val(),
                    consignee_customer_code :$('#consignee_customer_code').val(),
                    forwarder_customer_code: $('#forwarder_customer_code').val(),
                    pol: $('#pol').val(),
                    pod: $('#pod').val(),
                    sailling_due_date: sailling_due_date,
                    pick_up_dt: pick_up_dt
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
                confirm("Are you sure you want to delete it?");
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: 'DELETE', submit: true,_token:"{{ csrf_token() }}"}
                }).always(function (data) {
                    $('#inquiryDatatable').DataTable().draw(false);
                });
            });

            $('.input-daterange input').each(function() {
                $(this).datetimepicker({
                    viewMode: 'days',
                    format: 'YYYY-MM-DD',
                });
            });

            $('#sailling_due_date_from').on('dp.change', function(e){
                $('#sailling_due_date_to').data("DateTimePicker").minDate(e.date)
            })
            $('#sailling_due_date_to').on('dp.change', function(e){
                $('#sailling_due_date_from').data("DateTimePicker").maxDate(e.date)
            })

            $('#pick_up_dt_from').on('dp.change', function(e){
                $('#pick_up_dt_to').data("DateTimePicker").minDate(e.date)
            })
            $('#pick_up_dt_to').on('dp.change', function(e){
                $('#pick_up_dt_from').data("DateTimePicker").maxDate(e.date)
            })

        });

    </script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/dataTables.bootstrap4.min.js') }}"></script>
@endsection
