@if (isset($bookingContainerDetails['container_bookings']))
    <label class="col-form-label" for="booking_no">Booking No: {{ $bookingContainerDetails['booking_no'] }}</label>
    @foreach($bookingContainerDetails['container_bookings'] as $containerBooking)
        @php
            $containerCode = isset($containerBooking['container']) && !empty($containerBooking['container']) ? $containerBooking['container']['container_code']:'';

            if (is_array($containerBooking['details'])) {
                foreach ($containerBooking['details'] as $detail) {
                    $detail['container_code'] = $containerCode;
                    if ($detail['schedules']) {
                        $driver = \App\Employee::find($detail['schedules']['driver_id']);
                        $detail['container_truck_id'] = $detail['schedules']['container_truck_id'];
                        $detail['container_truck_code'] = $detail['schedules']['container_truck_code'];
                        $detail['driver_code'] = $driver->employee_code;
                        $detail['driver_name'] = $detail['schedules']['driver_name'];
                        $detail['etd'] = $detail['schedules']['etd'];
                        $detail['eta'] = $detail['schedules']['eta'];
                        $detail['container_no'] = $detail['schedules']['container_no'];
                    } else {
                        $detail['container_no'] = $detail['container_no'];
                        $detail['container_truck_code'] = '';
                        $detail['driver_code'] = '';
                        $detail['driver_name'] = '';
                        $detail['etd'] = '';
                        $detail['eta'] = '';
                    }

                    $listContainers[] = $detail;
                }
            }
        @endphp
    @endforeach
    <table class="table table-bordered hr-table-detail">
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
                <td>{{ '{'.$bookingContainerDetails['por_1'].'}'.'{'.$bookingContainerDetails['por_2'].'}'.'{'.$bookingContainerDetails['pol_1'].'}'.'{'.$bookingContainerDetails['pol_2'].'} ~ '.'{'.$bookingContainerDetails['pod_1'].'}'.'{'.$bookingContainerDetails['pod_2'].'}'.'{'.$bookingContainerDetails['del_1'].'}'.'{'.$bookingContainerDetails['del_2'].'}' }}</td>
                <td>
                    {{ $list['etd'] }}
                </td>
                <td>
                    {{ $list['eta'] }}
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
