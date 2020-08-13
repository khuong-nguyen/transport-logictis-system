<form action="/booking/transport/registration{{ isset($bookingContainerDetails) ? '/'.$bookingContainerDetails->id :''}}" method="post">
    @csrf
    @if(isset($booking))  @method('PUT') @endif
    <div class="row">
        <div class="col">
            <div class="form-group row">
                <div class="col-md-1 col-sm-2">
                    <label class="col-form-label required" for="booking_no">Booking No:</label>
                </div>
                <div class="col-md-2 col-sm-3">
                    <input class="form-control @if($errors->has('booking.booking_no')) is-invalid @endif" id="booking_no" type="text" name="booking_no"
                           value="{{ isset($search) ? $search : '' }}" required>
                    @error('booking.booking_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary btn-search-booking" disabled>Search</button>
                </div>
            </div>
            @if (isset($bookingContainerDetails))
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
                            @endphp
                            @foreach($bookingContainerDetails->containerBookings as $containerBooking)
                                @php
                                    $containerCode = $containerBooking->oneContainer?$containerBooking->oneContainer->container_code:'';
                                    for ($i = 0;$i < $containerBooking->vol; $i++) {
                                        $listContainers[] = ['booking_container_id' => $containerBooking->id, 'container_id' => $containerBooking->booking_id, 'container_code' => $containerCode];
                                    }

                                @endphp
                                <tr>
                                    <td>{{ $containerCode }}</td>
                                    <td>{{ $containerBooking->vol }}</td>
                                    <td>{{ $containerBooking->eq_sub }}</td>
                                    <td>{{ $containerBooking->soc }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6">
                    <label for="">Route {{ '{'.$bookingContainerDetails->por_1.'}'.'{'.$bookingContainerDetails->por_2.'}'.'{'.$bookingContainerDetails->pol_1.'}'.'{'.$bookingContainerDetails->pol_2.'} ~ '.'{'.$bookingContainerDetails->pod_1.'}'.'{'.$bookingContainerDetails->pod_2.'}'.'{'.$bookingContainerDetails->del_1.'}'.'{'.$bookingContainerDetails->del_2.'}' }}</label>
                </div>
            </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>TP/SZ</th>
                            <th>Container No</th>
                            <th>Seal No 1</th>
                            <th>Seal No 2</th>
                            <th>package</th>
                            <th>weight</th>
                            <th colspan="2">VGM</th>
                            <th>Measure</th>
                            <th>ST</th>
                            <th>RF</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach($listContainers as $list)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $list['container_code'] }}</td>
                            <td><input type="text" name="containerbookingdetail[container_no]" value="" class="form-control"></td>
                            <td><input type="text" max="50" name="containerbookingdetail[seal_no_1]" value="" class="form-control"></td>
                            <td><input type="text" max="50" name="containerbookingdetail[seal_no_2]" value="" class="form-control"></td>
                            <td><input type="number" max="11" name="containerbookingdetail[package]" value="" class="form-control"></td>
                            <td><input type="number" step="0.01" name="containerbookingdetail[weight]" value="" class="form-control"></td>
                            <td><input type="number" step="any" name="containerbookingdetail[vgm]" value="" class="form-control"></td>
                            <td>KGS</td>
                            <td><input type="number" step="any" name="containerbookingdetail[measure]" value="" class="form-control"></td>
                            <td><input type="text" name="containerbookingdetail[st]" value="" class="form-control"></td>
                            <td><input type="number" max="11" name="containerbookingdetail[rf]" value="" class="form-control"></td>
                            <td><button type="button" class="btn btn-sm btn-danger">Del</button></td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                    </tbody>
                </table>
                <div class="float-right">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary">Close</button>
                </div>
            @endif
        </div>
    </div>

</form>
<style>
    .btn-primary:disabled {
        cursor: no-drop;
    }
</style>

<script type="text/javascript">
    $(function () {
        $('#booking_no').on('keyup', e => {
           if (e.target.value !== '') {
                $('.btn-search-booking').prop('disabled', false)
           } else {
               $('.btn-search-booking').prop('disabled', true)
           }
        });

        $('.btn-search-booking').on('click', e => {
            let bookingNo = $('#booking_no').val();

            if (bookingNo !== '') {
                document.location.search = 'search='+bookingNo
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
        })
    })
</script>
