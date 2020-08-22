@if (isset($advanceMoneyBookingDetails['booking']))
    <label class="col-form-label" for="booking_no">Booking No: {{ $advanceMoneyBookingDetails['booking']['booking_no'] }}</label>
    @php $listAdvanceMoneys = []; @endphp
    @foreach($advanceMoneyBookingDetails['advance_money_bookings'] as $advanceMoneyBooking)
        @php
            if ($advanceMoneyBooking) {
                $detail['advance_money_code'] = $advanceMoneyBooking['advance_money_code'];
                $detail['advance_money_type'] = $advanceMoneyBooking['advance_money_type'];
                $detail['advance_money_employee_name'] = $advanceMoneyBooking['advance_money_employee_name'];
                $detail['give_money_employee_name'] = $advanceMoneyBooking['give_money_employee_name'];
                $detail['advance_money_date'] = $advanceMoneyBooking['advance_money_date'];
                $detail['advance_money'] = $advanceMoneyBooking['advance_money'];
                $detail['advance_money_reason'] =$advanceMoneyBooking['advance_money_reason'];
            } else {
                $detail['advance_money_code'] = '';
                $detail['advance_money_type'] = '';
                $detail['advance_money_employee_name'] = '';
                $detail['give_money_employee_name'] = '';
                $detail['advance_money_date'] = '';
                $detail['advance_money'] = '';
                $detail['advance_money_reason'] ='';
            }

            $listAdvanceMoneys[] = $detail;
        @endphp
    @endforeach
    <table class="table table-bordered hr-table-detail">
        <thead>
        <tr>
            <th>No.</th>
            <th>Adv Money No</th>
            <th>Type</th>
            <th>Reciever</th>
            <th>Give</th>
            <th>Adv Money Date</th>
            <th>Adv Money</th>
            <th>Reason</th>
        </tr>
        </thead>
        <tbody>
        @php
            $i = 1;
        @endphp
        @foreach($listAdvanceMoneys as $list)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $list['advance_money_code'] }}</td>
                <td>{{ $list['advance_money_type'] }}</td>
                <td>{{ $list['advance_money_employee_name'] }}</td>
                <td>
                    {{ $list['give_money_employee_name'] }}
                </td>
                <td>
                    {{ $list['advance_money_date'] }}
                </td>
                <td>{{ $list['advance_money'] }}</td>
                <td>{{ $list['advance_money_reason'] }}</td>
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
