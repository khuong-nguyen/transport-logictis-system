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
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="booking_no">BKG No</label>
                                <div class="col-md-8 pr-0 ">
                                    <input class="form-control" id="booking_no" type="text" value="{{ old('booking.booking_no')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <div class="col-md-4 pr-0">
                                    <label class="col-form-label required"  for="virtual_booking_no">B/L No</label>
                                </div>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" id="virtual_booking_no" type="text" name="virtual_booking_no">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="booking_no">SHBR</label>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" name="booking[booking_no]" id="booking_no" type="text" value="{{ old('booking.booking_no')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label required" for="booking_no">SHBR</label>
                                <div class="col-md-8 p-0">
                                    <input class="form-control" name="booking[booking_no]" id="booking_no" type="text" value="{{ old('booking.booking_no')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label required" for="booking_no">SHBR</label>
                                <div class="col-md-8 p-0">
                                    <input class="form-control" name="booking[booking_no]" id="booking_no" type="text" value="{{ old('booking.booking_no')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label" for="booking_no">T/VVD</label>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" id="booking_no" type="text" value="{{ old('booking.booking_no')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label required"  for="virtual_booking_no">POL</label>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" id="virtual_booking_no" type="text" name="virtual_booking_no">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <label class="col-md-4 pr-0 col-form-label required" for="booking_no">POD</label>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" name="booking[booking_no]" id="booking_no" type="text" value="{{ old('booking.booking_no')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <label class="col-md-6 pr-0 col-form-label required" for="booking_no">BKG Status</label>
                                <div class="col-md-6 pr-0">
                                    <input class="form-control" name="booking[booking_no]" id="booking_no" type="text" value="{{ old('booking.booking_no')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-4 pr-0">
                                        <label class="col-form-label" for="booking_no">Sailling Due Date</label>
                                    </div>
                                    <div class="col-md-8 pr-0">
                                        <input class="form-control" id="booking_no" type="text" value="{{ old('booking.booking_no')}}">
                                    </div>
                                </div>
                            </div>
                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-md-4 pr-0">
                                    <label class="col-form-label required"  for="virtual_booking_no">To</label>
                                </div>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" id="virtual_booking_no" type="text" name="virtual_booking_no">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-4 pr-0">
                                        <label class="col-form-label" for="booking_no">M'Ty Pick up DT </label>
                                    </div>
                                    <div class="col-md-8 pr-0">
                                        <input class="form-control" id="booking_no" type="text" value="{{ old('booking.booking_no')}}">
                                    </div>
                                </div>
                            </div>
                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-md-4 pr-0">
                                    <label class="col-form-label required"  for="virtual_booking_no">To</label>
                                </div>
                                <div class="col-md-8 pr-0">
                                    <input class="form-control" id="virtual_booking_no" type="text" name="virtual_booking_no">
                                </div>
                            </div>
                        </div>
                        </div>
                    <div class="form-group text-center">
                        <div class="btn-group">
                            <button class="btn btn-primary" type="submit"> Reset</button>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-primary" type="submit"> Search</button>
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
                                <th>Extn.</th>
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
            var pgno = 1;
            function fill_datatable(filter_gender = '', filter_country = '')
            {
                var dataTable = $('#inquiryDatatable').DataTable({
                    processing: true,
                    serverSide: true,
                    "searching": false,
                    "sPaginationType":"full_numbers",
                    "iDisplayLength": 4,
                    // "infoCallback": function( settings, start, end, max, total, pre ) {
                    //     var api = this.api();
                    //     var pageInfo = api.page.info();
                    //     pgno = pageInfo.page+1;
                    //     return 'Showing '+start+' to '+end+' of '+total+' entries';
                    // },
                    ajax:{
                        url: "/booking/inquiry",
                        // data:{page: pgno}
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
                            data:null,
                            name:null
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
            $('#filter').click(function(){
                var filter_gender = $('#filter_gender').val();
                var filter_country = $('#filter_country').val();

                if(filter_gender != '' &&  filter_gender != '')
                {
                    $('#inquiryDatatable').DataTable().destroy();
                    fill_datatable(filter_gender, filter_country);
                }
                else
                {
                    alert('Select Both filter option');
                }
            });

            $('#reset').click(function(){
                $('#filter_gender').val('');
                $('#filter_country').val('');
                $('#inquiryDatatable').DataTable().destroy();
                fill_datatable();
            });
        });

    </script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/dataTables.bootstrap4.min.js') }}"></script>
@endsection
