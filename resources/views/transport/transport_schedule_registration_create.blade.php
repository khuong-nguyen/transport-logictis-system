@extends('layout.app')
@section('title', 'Transport Schedule Registration')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">@lang('sidebar.transport_schedule_registration')</div>
                <div class="card-body">

                    <div class="row">
                        <div class="col ">
                            <div class="nav-tabs-boxed form-group">
                                <ul class="nav nav-tabs" role="tablist" >
                                    <li class="nav-item"><a class="nav-link @if(!$driverNo && !$containerTruckNo) active @endif" id="bkg_tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home">For Booking Tab</a></li>
                                    <li class="nav-item"><a class="nav-link @if($driverNo) active @endif" id="driver_tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="profile">For Driver Tab</a></li>
                                    <li class="nav-item"><a class="nav-link @if($containerTruckNo) active @endif" id="container_truck_tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="profile">For Container Truck Tab</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane @if(!$driverNo && !$containerTruckNo) active @endif" id="tab1" role="tabpanel" aria-labelledby="bkg_tab">
                                        <div id="main-form" class="row">
                                            <div class="col">
                                                <div class="form-group row">
                                                    <div class="col-md-1 col-sm-2">
                                                        <label class="col-form-label required" for="booking_no">Booking No:</label>
                                                    </div>
                                                    <div class="col-md-2 col-sm-3">
                                                        <input class="form-control @if(isset($searchError)) is-invalid @endif" id="booking_no" type="text" name="booking_no" @if (isset($booking)) disabled @endif
                                                        value="{{ isset($search) ? $search : '' }}" >
                                                        @if(isset($searchError))<div class="invalid-feedback">{{ $searchError }}</div>@endif
                                                    </div>
                                                    <div class="col-md-2">
                                                        @if (!isset($booking))<button type="button" class="btn btn-primary btn-search-booking" disabled>Search</button>@endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-1 col-sm-2">
                                                        <label class="col-form-label required" for="booking_no">Shipper: </label>
                                                    </div>
                                                    <div class="col-md-2 col-sm-3">
                                                        <input class="form-control" id="shipper" type="text" name="shipper" readonly
                                                        value="{{ isset($search) ? $search : '' }}" >
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class="col-form-label required" for="booking_no">Consignee: </label>
                                                    </div>
                                                    <div class="col-md-2 col-sm-3">
                                                        <input class="form-control" id="consignee" type="text" name="consignee" readonly
                                                        value="{{ isset($search) ? $search : '' }}" >
                                                    </div>
                                                </div>
                                                @if (isset($bookingContainerDetails['container_bookings']))
                                                    @if (!isset($booking))
                                                        <form id="form-transport-container" action="/booking/transport/registration{{ isset($bookingContainerDetails['id']) ? '/'.$bookingContainerDetails['id'] :''}}" method="post">
                                                            @csrf
                                                            @if(isset($bookingContainerDetails))  @method('PUT') @endif
                                                            @endif
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <table class="table table-dark">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>TP/SZ</th>
                                                                            <th>Vol</th>
                                                                            <th>EQ Sub(Incl. R/D</th>
                                                                            <th>S.O.C</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @php
                                                                            $listContainers = [];
                                                                            $addFull = false;
                                                                        @endphp
                                                                        @foreach($bookingContainerDetails['container_bookings'] as $containerBooking)
                                                                            @php
                                                                                $containerCode = isset($containerBooking['container']) && !empty($containerBooking['container']) ? $containerBooking['container']['container_code']:'';
                                                                                $vol = $containerBooking['vol'];
                                                                                if (is_array($containerBooking['details'])) {
                                                                                    foreach ($containerBooking['details'] as $detail) {
                                                                                        $addFull = true;
                                                                                        $detail['weight'] = floatval($detail['weight']);
                                                                                        $detail['vgm'] = floatval($detail['vgm']);
                                                                                        $detail['measure'] = floatval($detail['measure']);
                                                                                        $detail['container_code'] = $containerCode;
                                                                                        if ($detail['schedules']) {
                                                                                            $detail['container_truck_id'] = $detail['schedules']['container_truck_id'];
                                                                                            $detail['container_truck_code'] = $detail['schedules']['container_truck_code'];
                                                                                            $detail['driver_id'] = $detail['schedules']['driver_id'];
                                                                                            $detail['driver_code'] = \App\Employee::find($detail['schedules']['driver_id'])->employee_code;
                                                                                            $detail['driver_name'] = $detail['schedules']['driver_name'];
                                                                                        } else {
                                                                                            $detail['container_truck_code'] = '';
                                                                                        $detail['driver_code'] = '';
                                                                                        $detail['driver_name'] = '';
                                                                                        }

                                                                                        $listContainers[] = $detail;
                                                                                        $vol--;
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            <tr>
                                                                                <td>{{ $containerCode }}</td>
                                                                                <td>{{ $containerBooking['vol'] }}</td>
                                                                                <td>{{ $containerBooking['eq_sub'] }}</td>
                                                                                <td>{{ $containerBooking['soc'] }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label for="">Route {{ '{'.$bookingContainerDetails['por_1'].'}'.'{'.$bookingContainerDetails['por_2'].'}'.'{'.$bookingContainerDetails['pol_1'].'}'.'{'.$bookingContainerDetails['pol_2'].'} ~ '.'{'.$bookingContainerDetails['pod_1'].'}'.'{'.$bookingContainerDetails['pod_2'].'}'.'{'.$bookingContainerDetails['del_1'].'}'.'{'.$bookingContainerDetails['del_2'].'}' }}</label>
                                                                </div>
                                                            </div>
                                                            <table class="table table-bordered table-container-list">
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
                                                                <tbody>
                                                                @php
                                                                    $i = 1;
                                                                    $booking_status = isset($booking)?$booking->booking_status:$bookingContainerDetails['booking_status'];
                                                                    $readonly = $booking_status !== $statusApproved?'':'readonly';
                                                                @endphp
                                                                @foreach($listContainers as $list)
                                                                    <tr>
                                                                        <input type="hidden" name="containerbookingdetail[<?=$i?>][container_id]" value="{{ $list['container_id'] }}">
                                                                        <input type="hidden" name="containerbookingdetail[<?=$i?>][booking_id]" value="{{ $list['booking_id'] }}">
                                                                        <input type="hidden" name="containerbookingdetail[<?=$i?>][booking_container_id]" value="{{ $list['booking_container_id'] }}">
                                                                        <input type="hidden" name="containerbookingdetail[<?=$i?>][booking_no]" value="{{ $list['booking_no'] }}">
                                                                        <input type="hidden" name="containerbookingdetail[<?=$i?>][position]" value="{{ $i }}">
                                                                        <input type="hidden" class="id" name="containerbookingdetail[<?=$i?>][id]" value="{{ isset($list['id'])?$list['id']:'' }}">
                                                                        <td>{{ $i }}</td>
                                                                        <td>{{ $bookingContainerDetails['booking_no'] }}</td>
                                                                        <td>{{ $list['container_code'] }}</td>
                                                                        <td>{{ $list['container_no'] }}</td>
                                                                        <td>{{ '{'.$bookingContainerDetails['por_1'].'}'.'{'.$bookingContainerDetails['por_2'].'}'.'{'.$bookingContainerDetails['pol_1'].'}'.'{'.$bookingContainerDetails['pol_2'].'} ~ '.'{'.$bookingContainerDetails['pod_1'].'}'.'{'.$bookingContainerDetails['pod_2'].'}'.'{'.$bookingContainerDetails['del_1'].'}'.'{'.$bookingContainerDetails['del_2'].'}' }}</td>
                                                                        <td style="position: relative">
                                                                            <input style="min-width: 150px" type="text" name="containerbookingdetail[<?=$i?>][etd]" class="form-control etd">
                                                                        </td>
                                                                        <td style="position: relative">
                                                                            <input style="min-width: 150px" type="text" name="containerbookingdetail[<?=$i?>][eta]" class="form-control eta">
                                                                        </td>
                                                                        <td><input type="text" name="containerbookingdetail[<?=$i?>][container_truck_code]" value="{{ $list['container_truck_code'] }}" class="form-control container_truck_code"></td>
                                                                        <td><input type="text" step="any" name="containerbookingdetail[<?=$i?>][driver_code]"  value="{{ $list['driver_code'] }}" class="form-control driver_code"></td>
                                                                        <td>{{ $list['driver_name'] }}</td>
                                                                        <td>@if(isset($list['id']))<button type="button" onclick="onDelete(this)" data-id="{{ $list['id'] }}" class="btn btn-sm btn-danger action-delete">Del</button>@endif</td>
                                                                    </tr>
                                                                    @php
                                                                        $i++;
                                                                    @endphp
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="float-right">
                                                                        @if (isset($booking))
                                                                            <input type="hidden" id="is-booking" value="true">
                                                                            @if($booking_status !== $statusApproved)
                                                                                <button type="button" class="btn btn-primary" id="confirm-booking">Confirm</button>
                                                                            @endif
                                                                        @endif
                                                                        @if($booking_status !== $statusApproved)
                                                                            <button type="button" id="save-container" class="btn btn-primary">Save</button>
                                                                        @endif
                                                                        <a href="{{ !isset($booking)?asset('booking/transport/registration'):asset('booking/registration/'.$booking->id) }}" class="btn btn-secondary">Close</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if (!isset($booking))
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane @if($driverNo) active @endif" id="tab2" role="tabpanel" aria-labelledby="driver_tab">

                                    </div>
                                    <div class="tab-pane @if($containerTruckNo) active @endif" id="tab3" role="tabpanel" aria-labelledby="container_truck_tab">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <input style="min-width: 150px" type="text" name="" class="form-control etdttt" id="etdttt">
@endsection
@push('scripts')
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function () {

        $('#booking_no').on('keyup', e => {
            if (e.target.value !== '') {
                $('.btn-search-booking').prop('disabled', false)
            } else {
                $('.btn-search-booking').prop('disabled', true)
            }
        });
        $('.etd2').datetimepicker({
            viewMode: 'days',
            format: 'YYYY-MM-DD',
            date: new Date()
        });
        $('.etd').each((index, etd) => {
            var index = index+1;
            let eta = $(etd).closest('tr').find('.eta');
            console.log($(etd).closest('tr').find('.eta').val());
            $(etd).datetimepicker({
                format: 'dd/mm/yyyy hh:ii',
                startDate: moment().toDate(),
                useCurrent: false,
                // todayBtn: true,
                autoclose: true
            }).on('changeDate', function (selected) {
                var minDate = new Date(selected.date.valueOf());
                $(eta).datetimepicker('setStartDate', $(etd).data("datetimepicker").getDate());
            });
        console.log(index);
            $(eta).datetimepicker({
                format: 'dd/mm/yyyy hh:ii',
                // todayBtn: true,
                startDate: moment().toDate(),
                autoclose: true,
                useCurrent: false,
                todayHighlight: true,
            }).on('changeDate', function (selected) {
                var maxDate = new Date(selected.date.valueOf());
                $(etd).datetimepicker('setEndDate', $(eta).data("datetimepicker").getDate());
            });
        })

        $('.btn-search-booking').on('click', e => {
            let bookingNo = $('#booking_no').val();

            if (bookingNo !== '') {
                document.location.search = 'bookingNo='+bookingNo
                $.ajax({
                    url: "/api/booking/code",
                    dataType: "json",
                    method: 'get',
                    data: {
                        search: bookingNo
                    },
                    success: function (result) {
                        $('#shipper_id').val(result.id);
                        $.each(result, function (key, value) {
                            $('#'+key).val(value);
                        })
                    },
                    error: err => {
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr.error(err.responseJSON.message)
                    }
                });
            }
        });
    });
</script>
@endpush
