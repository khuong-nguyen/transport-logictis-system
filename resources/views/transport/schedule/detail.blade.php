@if (isset($bookingContainerDetails['container_bookings']))
    <label class="col-form-label" for="booking_no">Booking No: {{ $bookingContainerDetails['booking_no']??$bookingContainerDetails['virtual_booking_no']??$bookingContainerDetails['request_order_no']??'' }}</label>
    @php $listContainers = []; @endphp

    @foreach($bookingContainerDetails['container_bookings'] as $containerBooking)
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
                                $detail['pickup_address'] = $detail['schedules']['pickup_address']?$detail['schedules']['pickup_address'] : '';
                                $detail['delivery_address'] = $detail['schedules']['delivery_address'] ? $detail['schedules']['delivery_address'] : '';
                                $detail['booking_no'] = !empty($bookingContainerDetails['booking_no']) 
            												? $bookingContainerDetails['booking_no'] : (!empty($bookingContainerDetails['virtual_booking_no'])
															? $bookingContainerDetails['virtual_booking_no'] : $bookingContainerDetails['request_order_no']);
								$detail['booking_type'] = $bookingContainerDetails['booking_type'];
								$detail['por_1'] = $bookingContainerDetails['por_1'];
								$detail['por_2'] = $bookingContainerDetails['por_2'];
								$detail['pol_1'] = $bookingContainerDetails['pol_1'];
								$detail['pol_2'] = $bookingContainerDetails['pol_2'];
								$detail['pod_1'] = $bookingContainerDetails['pod_1'];
								$detail['pod_2'] = $bookingContainerDetails['pod_2'];
								$detail['del_1'] = $bookingContainerDetails['del_1'];
								$detail['del_2'] = $bookingContainerDetails['del_1'];
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
                                $detail['container_id'] = $containerBooking['container_id'];
                                $detail['pickup_address'] = $bookingContainerDetails['pickup_address'] ? $bookingContainerDetails['pickup_address'] : '';
                                $detail['delivery_address'] = $bookingContainerDetails['delivery_address'] ? $bookingContainerDetails['delivery_address'] : '';
                                $detail['booking_no'] = !empty($bookingContainerDetails['booking_no']) 
            												? $bookingContainerDetails['booking_no'] : (!empty($bookingContainerDetails['virtual_booking_no'])
															? $bookingContainerDetails['virtual_booking_no'] : $bookingContainerDetails['request_order_no']);
                            	$detail['booking_type'] = $bookingContainerDetails['booking_type'];
								$detail['por_1'] = $bookingContainerDetails['por_1'];
								$detail['por_2'] = $bookingContainerDetails['por_2'];
								$detail['pol_1'] = $bookingContainerDetails['pol_1'];
								$detail['pol_2'] = $bookingContainerDetails['pol_2'];
								$detail['pod_1'] = $bookingContainerDetails['pod_1'];
								$detail['pod_2'] = $bookingContainerDetails['pod_2'];
								$detail['del_1'] = $bookingContainerDetails['del_1'];
								$detail['del_2'] = $bookingContainerDetails['del_1'];
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
            		$detail['booking_no'] = !empty($bookingContainerDetails['booking_no']) 
            												? $bookingContainerDetails['booking_no'] : (!empty($bookingContainerDetails['virtual_booking_no'])
															? $bookingContainerDetails['virtual_booking_no'] : $bookingContainerDetails['request_order_no']);
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
                    $detail['container_id'] = $containerBooking['container_id'];
                    $detail['pickup_address'] = $bookingContainerDetails['pickup_address'] ? $bookingContainerDetails['pickup_address'] : '';
                    $detail['delivery_address'] = $bookingContainerDetails['delivery_address'] ? $bookingContainerDetails['delivery_address'] : '';
                    $detail['booking_type'] = $bookingContainerDetails['booking_type'];
					$detail['por_1'] = $bookingContainerDetails['por_1'];
					$detail['por_2'] = $bookingContainerDetails['por_2'];
					$detail['pol_1'] = $bookingContainerDetails['pol_1'];
					$detail['pol_2'] = $bookingContainerDetails['pol_2'];
					$detail['pod_1'] = $bookingContainerDetails['pod_1'];
					$detail['pod_2'] = $bookingContainerDetails['pod_2'];
					$detail['del_1'] = $bookingContainerDetails['del_1'];
					$detail['del_2'] = $bookingContainerDetails['del_1'];
                    $listContainers[] = $detail;
                }
        	@endphp
    @endforeach
    <table class="table table-container-list table-bordered table-striped table-inverse table-hover table-responsive" style="overflow-y:scroll">
        <thead>
        <tr style = "background-color:#020267; color:white;">
            <th>No.</th>
            <th>BKG No</th>
            <th>Con</th>
            <th>Con No</th>
            <th>Router</th>
            <th>Pickup Plan</th>
            <th>Delivery Plan</th>
            <th>Completed Time</th>
            <th>Transport Cost</th>
            <th>Pickup Address</th>
            <th>Delivery Address</th>
            <th>Container Truck</th>
            <th>Driver</th>
            <th>Driver Name</th>
        </tr>
        </thead>
        <tbody>
        @php
            $i = 1;
        @endphp
        @foreach($listContainers as $list)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $bookingContainerDetails['booking_no'] }}</td>
                <td>{{ $list['container_code'] }}</td>
                <td>{{ $list['container_no'] }}</td>
                @if($list['booking_type'] == 'IMPORT')
            	<td style="min-width: 150px" >{{ $list['pod_1'].$list['pod_2'].' ~ '.$list['del_1'].$list['del_2']}}</td>
            	@elseif($list['booking_type'] == 'EXPORT')
            	<td style="min-width: 150px" >{{ $list['por_1'].$list['por_2'].' ~ '.$list['pol_1'].$list['pol_2']}}</td>
            	@endif
                <td>
                    {{ $list['pickup_plan'] }}
                </td>
                <td>
                    {{ $list['delivery_plan'] }}
                </td>
                <td>
                    {{ $list['completed_date'] }}
                </td>
                <td>
                    <span class="currency_label">{{ $list['transport_cost'] }}</span>
                </td>
                <td>
                    {{ $list['pickup_address'] }}
                </td>
                <td>
                    {{ $list['delivery_address'] }}
                </td>
                <td>{{ $list['container_truck_code'] }}</td>
                <td>{{ $list['driver_code'] }}</td>
                <td>{{ $list['driver_name'] }}</td>
            </tr>
            @php
                $i++;
            @endphp
        @endforeach
        </tbody>
    </table>
    <style>
        .hr-table-detail {
            background-color: #d8dbe0
        }
        .hr-table-detail, .hr-table-detail th, .hr-table-detail td {
            border-color: #b2b4b7;
        }
        .hr-table-detail thead th {
            border-bottom-color: #b2b4b7;
        }
    </style>
@endif
