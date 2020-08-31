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
                                    <li class="nav-item"><a class="nav-link @if(!$driverNo && !$containerTruckNo) active @endif" id="bkg_tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home">Booking Schedule Tab</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane @if(!$driverNo && !$containerTruckNo) active @endif" id="tab1" role="tabpanel" aria-labelledby="bkg_tab">
                                        <div class="main-form" class="row">
                                            <div class="col">
                                                <div class="full-search">
                                                <div class="row">
                                                	<div class="col-md-6">
                                                    	<div class="form-group row">
                                                            <div class="col-md-3 pr-0">
                                                                <label class="col-form-label" for="pick_up_dt_from">BKG Created Date </label>
                                                            </div>
                                                            <div class="input-group col-md-6 input-daterange pr-0">
                                                                <input class="form-control" id="bkg_created_date_from" value="{{ isset($params['bkg_created_date_from']) ? $params['bkg_created_date_from'] : '' }}" name="bkg_created_date_from" type="text" autocomplete="off">
                                                                <div class="input-group-prepend d-block"><div class="input-group-text">To</div></div>
                                                                <input class="form-control" id="bkg_created_date_to" value="{{ isset($params['bkg_created_date_to']) ? $params['bkg_created_date_to'] : '' }}" type="text" name="bkg_created_date_to" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3 col-sm-2">
                                                                <label class="col-form-label required" for="booking_no">Booking No:</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3">
                                                        		<input class="form-control typeahead" type="text" name="booking_no"
                                                                    value="{{ isset($params['booking_no']) ? $params['booking_no'] : '' }}" autocomplete="off" >
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" class="btn btn-primary btn-search-booking">Search</button>
                                                                
                                                            </div>
                                                        </div>
                                                	</div>
                                                	<div class="col-md-4">
                                                	
                                                    		<div class="form-group row">
                                                				<div class="col-md-4 pr-0">
                                                                	<label class="col-form-label" for="view_booking_no">Booking No: </label>
                                                                </div>
                                                                <div class="col-md-5 pr-0">
                                                                	<label class="col-form-label" name= "view_booking_no" id= "view_booking_no"></label>
                                                                </div>
                                                    		</div>
                                                    		
                                                    		<div class="form-group row">
                                                				<div class="col-md-4 pr-0">
                                                                	<label class="col-form-label" for="view_sailling_due_date">Sailling due date: </label>
                                                                </div>
                                                				<div class="col-md-5 pr-0">
                                                                	<label class="col-form-label" name = "view_sailling_due_date" id = "view_sailling_due_date"></label>
                                                                </div>
                                                    		</div>
    
                                  
                                                    		<div class="form-group row">
                                                				<div class="col-md-4 pr-0">
                                                                	<label class="col-form-label" for="view_pick_up_dt">Pickup date: </label>
                                                                </div>
                                                                <div class="col-md-5 pr-0">
                                                                	<label class="col-form-label" name = "view_pick_up_dt" id = "view_pick_up_dt"></label>
                                                                </div>
                                                    		</div>
                                             
                                                		</div>
                                                	</div>
                                                	</div>
                                                </div>
@php
	$listContainers = [];
	$recordNumber = 0;
@endphp
                                                
@if (isset($bookingContainerDetails))
	@//dd($bookingContainerDetails);
    @foreach($bookingContainerDetails as $bookingContainerDetail)

        @foreach($bookingContainerDetail['container_bookings'] as $containerBooking)
            @php
                $containerCode = isset($containerBooking['container']) && !empty($containerBooking['container']) ? $containerBooking['container']['container_code']:'';
                
                $vol = $containerBooking['vol'];
                $containerDetailNum = 0;
                $noContainerDetailNum = 0;
                if (is_array($containerBooking['details']) && !empty($containerBooking['details'])) {
                        foreach ($containerBooking['details'] as $detail) {
                            $detail['container_code'] = $containerCode;
                            if ($detail['schedules']) {
                                $driver = \App\Employee::find($detail['schedules']['driver_id']);
                                $truck = \App\FixedAsset::find($detail['schedules']['container_truck_id']);
                                $detail['container_truck_id'] = $detail['schedules']['container_truck_id'];
                                $detail['id'] = $detail['schedules']['id'];
                                $detail['booking_container_detail_id'] = $detail['schedules']['booking_container_detail_id'];
                                $detail['container_truck_code'] = $truck->fixed_asset_code;
                                $detail['driver_id'] = $detail['schedules']['driver_id'];
                                $detail['driver_code'] = $driver->employee_code;
                                $detail['driver_name'] = $detail['schedules']['driver_name'];
                                $detail['pickup_plan'] = $detail['schedules']['pickup_plan'];
                                $detail['delivery_plan'] = $detail['schedules']['delivery_plan'];
                                $detail['container_no'] = $detail['container_no'];
                                $detail['completed_date'] = $detail['schedules']['completed_date'];
                                $detail['transport_cost'] = $detail['schedules']['transport_cost'];
                                $detail['pickup_address'] = $bookingContainerDetail['booking_type'] == 'EXPORT' ? $bookingContainerDetail['pickup_address'] : '';
                                $detail['delivery_address'] = $bookingContainerDetail['booking_type'] == 'IMPORT' ? $bookingContainerDetail['delivery_address'] : '';
                                $detail['booking_no'] = !empty($bookingContainerDetail['booking_no']) 
            												? $bookingContainerDetail['booking_no'] : (!empty($bookingContainerDetail['virtual_booking_no'])
															? $bookingContainerDetail['virtual_booking_no'] : $bookingContainerDetail['request_order_no']);
                            } else {
                                $detail['booking_container_detail_id'] = $detail['id'];
                                $detail['container_no'] = $detail['container_no'];
                                $detail['container_truck_code'] = '';
                                $detail['container_truck_id'] = '';
                                $detail['driver_code'] = '';
                                $detail['driver_name'] = '';
                                $detail['driver_id'] = '';
                                $detail['id'] = '';
                                $detail['pickup_plan'] = '';
                                $detail['delivery_plan'] = '';
                                $detail['completed_date'] = '';
                                $detail['transport_cost'] = '';
                                $detail['pickup_address'] = $bookingContainerDetail['booking_type'] == 'EXPORT' ? $bookingContainerDetail['pickup_address'] : '';
                                $detail['delivery_address'] = $bookingContainerDetail['booking_type'] == 'IMPORT' ? $bookingContainerDetail['delivery_address'] : '';
                                $detail['booking_no'] = !empty($bookingContainerDetail['booking_no']) 
            												? $bookingContainerDetail['booking_no'] : (!empty($bookingContainerDetail['virtual_booking_no'])
															? $bookingContainerDetail['virtual_booking_no'] : $bookingContainerDetail['request_order_no']);
                            }
    						$containerDetailNum++;
                            $listContainers[] = $detail;
    
                        }
            	}
            	$noContainerDetailNum = $vol - $containerDetailNum;
            	
                for($row = 1; $row <= $noContainerDetailNum; $row++){
                	$detail['booking_container_detail_id'] = null;
            		$detail['container_id'] = null;
            		$detail['booking_id'] = $containerBooking['booking_id'];
            		$detail['booking_no'] = !empty($bookingContainerDetail['booking_no']) 
            												? $bookingContainerDetail['booking_no'] : (!empty($bookingContainerDetail['virtual_booking_no'])
															? $bookingContainerDetail['virtual_booking_no'] : $bookingContainerDetail['request_order_no']);
            		$detail['booking_container_id'] = $containerBooking['id'];
            		$detail['container_code'] = $containerBooking['container']['container_code'];
            		
                    $detail['container_no'] = '';
                    $detail['container_truck_code'] = '';
                    $detail['container_truck_id'] = '';
                    $detail['driver_code'] = '';
                    $detail['driver_name'] = '';
                    $detail['driver_id'] = '';
                    $detail['id'] = '';
                    $detail['pickup_plan'] = '';
                    $detail['delivery_plan'] = '';
                    $detail['completed_date'] = '';
                    $detail['transport_cost'] = '';
                    $detail['pickup_address'] = $bookingContainerDetail['booking_type'] == 'EXPORT' ? $bookingContainerDetail['pickup_address'] : '';
                    $detail['delivery_address'] = $bookingContainerDetail['booking_type'] == 'IMPORT' ? $bookingContainerDetail['delivery_address'] : '';;
                    $listContainers[] = $detail;
                }
        	@endphp
        @endforeach
    
     @endforeach
@endif

                                                <form class="form-transport-container" action="/booking/transport/schedule/registration" method="post">
    												@csrf
    												@method('PUT')
    												
                                                <table class="table table-bordered table-container-list table-responsive">
                                                    <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>BKG No</th>
                                                        <th>Con</th>
                                                        <th>Con No</th>
                                                        <th>Router</th>
                                                        <th>Pickup Plan</th>
                                                        <th>Delivery Plan</th>
                                                        <th>Container Truck</th>
                                                        <th>Driver</th>
                                                        <th>Driver Name</th>
                                                        <th>Completed Time</th>
                                                        <th>Transport Cost</th>
                                                        <th>Pickup Address</th>
                                                        <th>Delivery Address</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                    @foreach($listContainers as $list)
                                                    	
                                                        <tr>
                                                            <input type="hidden" name="schedules[<?=$recordNumber?>][container_id]" value="{{ $list['container_id'] }}">
                                                            <input type="hidden" name="schedules[<?=$recordNumber?>][container_no]" value="{{ $list['container_no'] }}">
                                                            <input type="hidden" name="schedules[<?=$recordNumber?>][booking_container_detail_id]" value="{{ $list['booking_container_detail_id'] }}">
                                                            <input type="hidden" name="schedules[<?=$recordNumber?>][booking_id]" value="{{ $list['booking_id'] }}">
                                                            <input type="hidden" name="schedules[<?=$recordNumber?>][booking_container_id]" value="{{ $list['booking_container_id'] }}">
                                                            <input type="hidden" name="schedules[<?=$recordNumber?>][booking_no]" value="{{ $list['booking_no'] }}">
                                                            <input type="hidden" name="schedules[<?=$recordNumber?>][position]" value="{{ $recordNumber }}">
                                                            <input type="hidden" name="schedules[<?=$recordNumber?>][driver_name]" class="driver_name" value="{{ $list['driver_name'] }}">
                                                            <input type="hidden" class="driver_id" name="schedules[<?=$recordNumber?>][driver_id]" class="driver_id" value="{{ $list['driver_id'] }}">
                                                            <input type="hidden" class="id" name="schedules[<?=$recordNumber?>][id]" value="{{ $list['id'] }}">
                                                            <input type="hidden" class="container_truck_id" name="schedules[<?=$recordNumber?>][container_truck_id]" value="{{ $list['container_truck_id'] }}">
                                                            <td>{{ $recordNumber + 1}}</td>
                                                            <td>{{ $list['booking_no'] }}</td>
                                                            <td>
                                                            	{{ $list['container_code'] }}
                                                            </td>
                                                            <td>
                                                            	<input type="text" style="min-width: 100px" name="schedules[<?=$recordNumber?>][container_no]" value="{{ $list['container_no'] }}" class="form-control container_no" autocomplete="off">
                                                            </td>
                                                            <td style="min-width: 150px" >{{ $bookingContainerDetail['por_1'].$bookingContainerDetail['por_2'].$bookingContainerDetail['pol_1'].$bookingContainerDetail['pol_2'].' ~ '.$bookingContainerDetail['pod_1'].$bookingContainerDetail['pod_2'].$bookingContainerDetail['del_1'].$bookingContainerDetail['del_2'] }}</td>
                                                            <td style="position: relative">
                                                                <input style="min-width: 100px" type="text" value="{{ $list['pickup_plan'] }}"  name="schedules[<?=$recordNumber?>][pickup_plan]" class="form-control pickup_plan" autocomplete = "off">
                                                            </td>
                                                            <td style="position: relative">
                                                                <input style="min-width: 100px" type="text" value="{{ $list['delivery_plan'] }}" name="schedules[<?=$recordNumber?>][delivery_plan]" class="form-control delivery_plan" autocomplete = "off">
                                                            </td>
                                                            <td style="position: relative">
                                                                <div class = "container">
                                                                	<input type="text" style="min-width: 100px" name="schedules[<?=$recordNumber?>][container_truck_code]" value="{{ $list['container_truck_code'] }}" class="form-control container_truck_code" autocomplete="off">
                                                                </div>
                                                        	</td>
                                                            <td style="position: relative">
                                                            	<div class = "container">
                                                            		<input type="text" style="min-width: 100px" name="schedules[<?=$recordNumber?>][driver_code]"  value="{{ $list['driver_code'] }}" class="form-control driver_code" autocomplete="off" readonly>
                                                        		</div>
                                                    		</td>	
                                                            <td class="driver_name_text"  style="min-width: 160px">{{ $list['driver_name'] }}</td>
                                                            <td style="position: relative">
                                                                <input style="min-width: 100px" type="text" value="{{ $list['completed_date'] }}" name="schedules[<?=$recordNumber?>][completed_date]" class="form-control completed_date" autocomplete = "off">
                                                            </td>
                                                            <td style="position: relative">
                                                                <input type="number" min="0" type="text" style="min-width: 100px" value="{{ $list['transport_cost'] }}" name="schedules[<?=$recordNumber?>][transport_cost]" class="form-control transport_cost">
                                                            </td>
                                                            <td style="position: relative">
                                                                <input type="text" style="min-width: 300px" value="{{ $list['pickup_address'] }}" name="schedules[<?=$recordNumber?>][pickup_address]" class="form-control pickup_address" readonly>
                                                            </td>
                                                           <td style="position: relative">
                                                                <input type="text" style="min-width: 300px" value="{{ $list['delivery_address'] }}" name="schedules[<?=$recordNumber?>][delivery_address]" class="form-control delivery_address" readonly>
                                                            </td>
                                                            
                                                            <td>@if($list['id'])<button type="button" onclick="onDelete(this)" data-id="{{ $list['id'] }}" class="btn btn-sm btn-danger action-delete">Del</button>@endif</td>
                                                        </tr>
                                                        @php
                                                            $recordNumber++;
                                                        @endphp
                                                    @endforeach
                                                    </tbody>
                                                 </table>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="float-right">
                                                        @if ($recordNumber+1 > 0)
                                                            <button type="submit"  class="btn btn-primary">Save</button>
                                                        @endif
                                                            <a href="{{ asset('booking/transport/schedule/registration') }}" class="btn btn-secondary">Close</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="search" value="{{ isset($params) ? json_encode($params) : '' }}">           
                                            </form> 
                                            </div>
                                        </div>
                                    </div>
    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content panel-danger">
                <div class="modal-header panel-heading-danger">
                    <h5 class="modal-title" id="exampleModalLabel">DELETE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you want to delete this?
                </div>
                <div class="modal-footer">
                    <button type="button" id="delete" class="btn btn-danger">YES</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                </div>
            </div>
        </div>
    </div>
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
        table .redonly {
            background-color: #d8dbe0
        }
        .table-container-list, .table-container-list th, .table-container-list td {
            border-color: #b2b4b7;
        }
        .table-container-list thead th {
            border-bottom-color: #b2b4b7;
        }
        .modal-header.panel-heading-danger {
            background-color: #e55353;
            border-color: #e55353;
            color: #fff;
        }
        .nav-tabs-boxed .tab-content {
            padding: 2rem 1.25rem;
        }
    </style>
<script type="text/javascript">
	$('#sidebar').removeClass('c-sidebar-lg-show');

	var indexCurrentRow = -1;
	
	$(function () {
		$('#bkg_created_date_from').datetimepicker({
			viewMode: 'days',
	        format: 'dd/mm/yyyy',
	        date: new Date()
	    });

		$('#bkg_created_date_to').datetimepicker({
			viewMode: 'days',
	        format: 'dd/mm/yyyy',
	        date: new Date()
	    });
	});
    
    $('#bkg_created_date_from').on('dp.change', function(e){
        $('#bkg_created_date_to').data("DateTimePicker").minDate(e.date)
    })
    $('#bkg_created_date_to').on('dp.change', function(e){
        $('#bkg_created_date_from').data("DateTimePicker").maxDate(e.date)
    })
    
    function onDelete(e) {
        let ID = $(e).attr('data-id');
        $('#delete').attr('data-id', ID);
        $('#confirmDeleteModal').modal('show');
    }
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
            let tr = $('.table-container-list:visible tbody tr').eq(index);
            let pickup_plan = tr.find('.pickup_plan').val();
            let delivery_plan = tr.find('.delivery_plan').val();
            let container_truck_code = tr.find('.container_truck_id').val();
            let driver_code = tr.find('.driver_id').val();
            if (pickup_plan !== '' && delivery_plan !== '' && (container_truck_code !== '' || driver_code !== '')) {
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
                            let element = $('.form-transport-container:visible').find('input[name="'+name+'"]');
                            if (lip[2] === 'container_truck_code' || lip[2] === 'driver_code') {
                                element.removeClass('is-invalid')
                                element.removeClass('is-valid')
                                element.addClass('is-warning')
                                toastr.warning(item[0]);
                            } else {
                                element.removeClass('is-valid')
                                element.addClass('is-invalid')
                                toastr.error(item[0]);
                            }
                        })
                        // toastr.error(err.responseJSON.message)
                    }
                });
            }
        }
        $('#delete').on('click', e => {
            let ID = e.target.getAttribute('data-id');
            if (typeof ID !== undefined) {
                $('#confirmDeleteModal').modal('hide');
                $.ajax({
                    url: "/booking/transport/schedule/registration/"+ID,
                    dataType: "json",
                    method: 'delete',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        let btnDel = $('.action-delete').filter('[data-id="'+ID+'"]');
                        btnDel.closest('tr').find('td input').each((index, item) => {
                            item.value = '';
                        });
                        btnDel.closest('tr').find('.id').val('');
                        btnDel.remove();
                        toastr.success('Deleted success!');
                    },
                    error: err => {
                        toastr.error(err.responseJSON.message)
                    }
                });
            }
        })

        $('.pickup_plan').change(function(e) {

            callIsUsedProperty($(this).closest('tr').index());
        });
        $('.delivery_plan').change(function(e) {
            callIsUsedProperty($(this).closest('tr').index());
        });
        $('.pickup_plan').each((index, pickup_plan) => {
            let delivery_plan = $(pickup_plan).closest('tr').find('.delivery_plan');
            let completed_date = $(pickup_plan).closest('tr').find('.completed_date');
            $(pickup_plan).datetimepicker({
                format: 'dd/mm/yyyy hh:mm',
                startDate: moment().toDate(),
                useCurrent: false,
                // todayBtn: true,
                autoclose: true
            }).on('changeDate', function (selected) {
                var minDate = new Date(selected.date.valueOf());
                $(delivery_plan).datetimepicker('setStartDate', $(pickup_plan).data("datetimepicker").getDate());
                callIsUsedProperty(index);
            });
            $(delivery_plan).datetimepicker({
                format: 'dd/mm/yyyy hh:mm',
                // todayBtn: true,
                startDate: moment().toDate(),
                autoclose: true,
                useCurrent: false,
                todayHighlight: true,
            }).on('changeDate', function (selected) {
                var maxDate = new Date(selected.date.valueOf());
                $(pickup_plan).datetimepicker('setEndDate', $(delivery_plan).data("datetimepicker").getDate());
                callIsUsedProperty(index);
            });

            $(completed_date).datetimepicker({
                format: 'dd/mm/yyyy hh:mm',
                // todayBtn: true,
                startDate: moment().toDate(),
                autoclose: true,
                useCurrent: false,
                todayHighlight: true,
            }).on('changeDate', function (selected) {
                var maxDate = new Date(selected.date.valueOf());
                $(pickup_plan).datetimepicker('setEndDate', $(completed_date).data("datetimepicker").getDate());
                callIsUsedProperty(index);
            });
        });

        $('.driver_code').on('focus', function() {
        		let tr = $(this).closest('tr');
        		indexCurrentRow = tr.index();
            });
        $('.container_truck_code').on('focus', function() {
    		let tr = $(this).closest('tr');
    		indexCurrentRow = tr.index();
        });

        
        $('.btn-search-booking').on('click', e => {

            let bookingNo = $('input[name="booking_no"]:visible').val();
            let bkg_created_date_from = $('input[name="bkg_created_date_from"]:visible').val();
            let bkg_created_date_to = $('input[name="bkg_created_date_to"]:visible').val();

            let query = "bkg_created_date_from" + "=" + bkg_created_date_from;
            query = query + "&" + "bkg_created_date_to" + "=" + bkg_created_date_to;
            query = query + "&" + "booking_no" + "=" + bookingNo;
            
            document.location.search = query
        });
    });
</script>

<script type="text/javascript">
    var path = "{{ route('autocompleteBookingNo') }}";
    $('input.typeahead').typeahead({
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });

    var container_truck_code_path = "{{ route('autocompleteTruckNo') }}";
    $('input.container_truck_code').typeahead({
        source:  function (query, process) {
        return $.get(container_truck_code_path, { query: query }, function (data) {
                return process(data);
            });
        },
        afterSelect: function (item) {
        	$.ajax({
                url: '/fixed_asset/search',
                dataType: "json",
                method: 'GET',
                data: {
                    'code': item.name,
                    'type': 'TRUCK'
                },
                success: function (result) {
                    if (result.data !== null) {
                    	let tr = $('.table-container-list:visible tbody tr').eq(indexCurrentRow);
                        tr.find('.container_truck_id').val(result.data.id)
                        tr.find('.container_truck_code').removeClass('is-warning')
                        tr.find('.container_truck_code').removeClass('is-invalid')
                        tr.find('.container_truck_code').addClass('is-valid')
                        tr.find('.driver_id').val(result.data.driver_id);
                        tr.find('.driver_code').val(result.data.driver_code);
                        tr.find('.driver_name_text').html(result.data.driver_name);
                        tr.find('.driver_name').val(result.data.driver_name);
                        callIsUsedProperty(indexCurrentRow);
                    }
                }
            });
        }
    });

    var driver_code_path = "{{ route('autocompleteDriverNo') }}";
    $('input.driver_code').typeahead({
        source:  function (query, process) {
        return $.get(driver_code_path, { query: query }, function (data) {
                return process(data);
            });
        },
        afterSelect: function (item) {
        	$.ajax({
                url: '/employee/search',
                dataType: "json",
                method: 'GET',
                data: {
                    'code': item.name,
                    'type': 'DRIVER'
                },
                success: function (result) {
                    if (result.data !== null) {
                    	let tr = $('.table-container-list:visible tbody tr').eq(indexCurrentRow);
                    	
                        tr.find('.driver_id').val(result.data.id);
                        tr.find('.driver_name').val(result.data.employee_name);
                        tr.find('.driver_name_text').html(result.data.employee_name);
                        tr.find('.driver_code').removeClass('is-warning');
                        tr.find('.driver_code').removeClass('is-invalid');
                        tr.find('.driver_code').addClass('is-valid');
                        callIsUsedProperty(indexCurrentRow);
                    }
                }
            });
        }
    });

    
</script>

@endpush
