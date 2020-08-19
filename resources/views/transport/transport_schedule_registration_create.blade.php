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
                                                        value="{{ isset($bookingNo) ? $bookingNo : '' }}" >
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
                                                        value="{{ isset($bookingContainerDetails['shipper']) && $bookingContainerDetails['shipper'] ? $bookingContainerDetails['shipper']['customer_legal_english_name'] : '' }}" >
                                                    </div>
                                                    <div class="col-md-1 col-sm-2">
                                                        <label class="col-form-label required" for="booking_no">Consignee: </label>
                                                    </div>
                                                    <div class="col-md-2 col-sm-3">
                                                        <input class="form-control" id="consignee" type="text" name="consignee" readonly
                                                        value="{{ isset($bookingContainerDetails['consignee']) && $bookingContainerDetails['consignee'] ? $bookingContainerDetails['consignee']['customer_legal_english_name'] : '' }}" >
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
                                                                                            $driver = \App\Employee::find($detail['schedules']['driver_id']);
                                                                                            $detail['container_truck_id'] = $detail['schedules']['container_truck_id'];
                                                                                            $detail['container_truck_code'] = $detail['schedules']['container_truck_code'];
                                                                                            $detail['driver_id'] = $detail['schedules']['driver_id'];
                                                                                            $detail['driver_code'] = $driver->employee_code;
                                                                                            $detail['driver_name'] = $detail['schedules']['driver_name'];
                                                                                        } else {
                                                                                            $detail['container_truck_code'] = '';
                                                                                            $detail['container_truck_id'] = '';
                                                                                            $detail['driver_code'] = '';
                                                                                            $detail['driver_name'] = '';
                                                                                            $detail['driver_id'] = '';
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
                                                                        <input type="hidden" name="schedules[<?=$i?>][container_id]" value="{{ $list['container_id'] }}">
                                                                        <input type="hidden" name="schedules[<?=$i?>][booking_id]" value="{{ $list['booking_id'] }}">
                                                                        <input type="hidden" name="schedules[<?=$i?>][booking_container_id]" value="{{ $list['booking_container_id'] }}">
                                                                        <input type="hidden" name="schedules[<?=$i?>][booking_no]" value="{{ $list['booking_no'] }}">
                                                                        <input type="hidden" name="schedules[<?=$i?>][position]" value="{{ $i }}">
                                                                        <input type="hidden" name="schedules[<?=$i?>][driver_name]" class="driver_name" value="{{ $list['driver_name'] }}">
                                                                        <input type="hidden" name="schedules[<?=$i?>][driver_id]" class="driver_id" value="{{ $list['driver_id'] }}">
                                                                        <input type="hidden" class="id" name="schedules[<?=$i?>][id]" value="{{ isset($list['id'])?$list['id']:'' }}">
                                                                        <input type="hidden" class="id" name="schedules[<?=$i?>][container_truck_id]" value="{{ $list['container_truck_id'] }}">
                                                                        <td>{{ $i }}</td>
                                                                        <td>{{ $bookingContainerDetails['booking_no'] }}</td>
                                                                        <td>{{ $list['container_code'] }}</td>
                                                                        <td>{{ $list['container_no'] }}</td>
                                                                        <td>{{ '{'.$bookingContainerDetails['por_1'].'}'.'{'.$bookingContainerDetails['por_2'].'}'.'{'.$bookingContainerDetails['pol_1'].'}'.'{'.$bookingContainerDetails['pol_2'].'} ~ '.'{'.$bookingContainerDetails['pod_1'].'}'.'{'.$bookingContainerDetails['pod_2'].'}'.'{'.$bookingContainerDetails['del_1'].'}'.'{'.$bookingContainerDetails['del_2'].'}' }}</td>
                                                                        <td style="position: relative">
                                                                            <input style="min-width: 150px" type="text" name="schedules[<?=$i?>][etd]" class="form-control etd">
                                                                        </td>
                                                                        <td style="position: relative">
                                                                            <input style="min-width: 150px" type="text" name="schedules[<?=$i?>][eta]" class="form-control eta">
                                                                        </td>
                                                                        <td><input type="text" name="schedules[<?=$i?>][container_truck_code]" value="{{ $list['container_truck_code'] }}" class="form-control container_truck_code"></td>
                                                                        <td><input type="text" step="any" name="schedules[<?=$i?>][driver_code]"  value="{{ $list['driver_code'] }}" class="form-control driver_code"></td>
                                                                        <td class="driver_name_text">{{ $list['driver_name'] }}</td>
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
    <style>
        .form-control.is-warning {
            padding-right: calc(1.5em + 0.75rem);
            background-position: right calc(0.375em + 0.1875rem) center;
            border-color: #d4c240;
            background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABmJLR0QA/wD/AP+gvaeTAAACLUlEQVQ4jY2S30tTYRjHv+97ztlp1KY2GaahQsLCi7wQIugqQm1QFIQUBkVYiPfd1x8g3koglBB0P9K2sLpohHUhWqmLLa216TTnfrnt7Jz3RxfpcYkrn7v34fv9PA/f9yHYV+9H+52lY/nzRNMuE0KvSyk0ImWQCT5ZJo7g1cFAoVpPACA43tehCOpXHVo/5+zsUXd9qaml1e050awAQDq1JtZX48XtbEZXHdosM6znjPCpS/dCMRUAKGikqa3d9DafdB73NkHVHHr1FFddA233dbqYZWJrI3VuYzXRtfbz+ygAdQdALN+Zbqem/+XD2MgEAGD4wR0AgKo54G1pRb3H60wlfpT+eAEQSnOVirE/jpplVgxQSvM2QKFq0jTKhwZUKmVQqiRtAJfsYz6bFocF5Lc2BRd8xgYIbr1Lp1KFf9v2Kr2eKnCLhW0A0Vgol/mlc87+a2aMIZfZ1CWVr4CdOwCAN0+vhHxd3T3NbadIbTuQWInK2MJc6MLtgN/eAAC4xR4uL30pSrEXxdjIhP2VACCFwEpkoWiW2aPdng3ouf9yxjLN+cS3KK81PR6NcGaZc31DUx92e2q1QJbFjdji/FJdY6PL3eCxDwgA8pktLEc+l7hp3Kr20OrHxeEXSSH5wGz4bXE7l7X7hWwGs+HXRcbYzZ6h6Xi158DApsf914iiPOvo7DoCSMQWPxlcyIHewcnAfm3NxEOPe09ruv6EANLg1l3/YPDrQbrf9xX5oO8d+8UAAAAASUVORK5CYII=");
            background-repeat: no-repeat;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
    </style>
<script type="text/javascript">
    $(function () {
        function getAllValues(element) {
            var inputValues = element.find('input').map(function() {
                var type = $(this).prop("type");

                // checked radios/checkboxes
                if ((type === "checkbox" || type === "radio") && this.checked) {
                    return {name: $(this).prop("name"), value: $(this).val()};
                }
                // all other fields, except buttons
                else if (type !== "button" && type !== "submit") {
                    return {name: $(this).prop("name"), value: $(this).val()};
                }
            });
            return inputValues;
        }
        function callIsUsedProperty(index) {
            let tr = $('.table-container-list tbody tr').eq(index);
            let etd = tr.find('.etd').val();
            let eta = tr.find('.eta').val();
            let container_truck_code = tr.find('.container_truck_code').val();
            let driver_code = tr.find('.driver_code').val();
            if (etd !== '' && eta !== '' && (container_truck_code !== '' || driver_code !== '')) {
                let form = getAllValues(tr)
                form.push({name: '_token', value:$('meta[name="csrf-token"]').attr('content')})
                $.ajax({
                    url: '/booking/transport/schedule/useds',
                    dataType: "json",
                    method: 'post',
                    data: form,
                    success: function (result) {
                        $.each(result.data, (index, item) => {
                            let tr = $('.table-container-list tbody tr:nth-child('+parseInt(item.position)+')');
                            var input = $("<button type=\"button\" onclick=\"onDelete(this)\" data-id=\""+item.id+"\" class=\"btn btn-sm btn-danger action-delete\">Del</button>")
                            tr.find('td:last-child').html(input);
                        });
                        toastr.success(result.message)
                    },
                    error: err => {
                        $.each(err.responseJSON.errors, (index, item) => {
                            let lip = index.split('.');
                            let name = lip[0]+'['+lip[1]+']'+'['+lip[2]+']';
                            let element = $('#form-transport-container').find('input[name="'+name+'"]');
                            if (lip[2] === 'container_truck_code' || lip[2] === 'driver_code') {
                                element.addClass('is-warning')
                                toastr.warning(item[0]);
                            } else {
                                element.addClass('is-invalid')
                                toastr.error(item[0]);
                            }
                        })
                        // toastr.error(err.responseJSON.message)
                    }
                });
            }
        }

        $('#booking_no').on('keyup', e => {
            if (e.target.value !== '') {
                $('.btn-search-booking').prop('disabled', false)
            } else {
                $('.btn-search-booking').prop('disabled', true)
            }
        });
        $('.etd').each((index, etd) => {
            let eta = $(etd).closest('tr').find('.eta');
            $(etd).datetimepicker({
                format: 'dd/mm/yyyy hh:ii',
                startDate: moment().toDate(),
                useCurrent: false,
                // todayBtn: true,
                autoclose: true
            }).on('changeDate', function (selected) {
                callIsUsedProperty(index);
                var minDate = new Date(selected.date.valueOf());
                $(eta).datetimepicker('setStartDate', $(etd).data("datetimepicker").getDate());
            });
            $(eta).datetimepicker({
                format: 'dd/mm/yyyy hh:ii',
                // todayBtn: true,
                startDate: moment().toDate(),
                autoclose: true,
                useCurrent: false,
                todayHighlight: true,
            }).on('changeDate', function (selected) {
                var maxDate = new Date(selected.date.valueOf());
                callIsUsedProperty(index);
                $(etd).datetimepicker('setEndDate', $(eta).data("datetimepicker").getDate());
            });
        });

        $('.container_truck_code').on('change', function() {
            let tr = $(this).closest('tr');
            let val = $(this).val()
            if (val !== '') {
                $.ajax({
                    url: '/fixed_asset/search',
                    dataType: "json",
                    method: 'GET',
                    data: {
                        'code': val,
                        'type': 'TRUCK'
                    },
                    success: function (result) {
                        if (result.data !== null) {
                            tr.find('.container_truck_id').val(result.data.id)
                            tr.find('.container_truck_code').addClass('is-valid')
                            tr.find('.container_truck_code').removeClass('is-invalid')
                            callIsUsedProperty(tr.index());
                        }
                    },
                    error: err => {
                        tr.find('.container_truck_code').removeClass('is-valid')
                        tr.find('.container_truck_code').addClass('is-invalid')
                        toastr.error(err.responseJSON.message)
                    }
                });
            }
        });

        $('.driver_code').on('change', function() {
            let tr = $(this).closest('tr');
            let val = $(this).val()
            if (val !== '') {
                $.ajax({
                    url: '/employee/search',
                    dataType: "json",
                    method: 'GET',
                    data: {
                        'code': val,
                        'type': 'DRIVER'
                    },
                    success: function (result) {
                        if (result.data !== null) {
                            tr.find('.driver_id').val(result.data.id)
                            tr.find('.driver_name').val(result.data.employee_name)
                            tr.find('.driver_name_text').html(result.data.employee_name)
                            callIsUsedProperty(tr.index());
                        }
                    },
                    error: err => {
                        toastr.error(err.responseJSON.message)
                    }
                });
            }

        });

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
