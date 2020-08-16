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
                                                $listContainers[] = $detail;
                                                $vol--;
                                            }
                                        }

                                        for ($i = 0; $i < $vol; $i++) {
                                            $example['booking_container_id'] = $containerBooking['id'];
                                            $example['booking_no'] = $bookingContainerDetails['booking_no'];
                                            $example['container_id'] = $containerBooking['container_id'];
                                            $example['booking_id'] = $containerBooking['booking_id'];
                                            $example['container_code'] = $containerCode;
                                            $listContainers[] = $example;
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
                            <td>{{ $list['container_code'] }}</td>
                            <td><input type="text" name="containerbookingdetail[<?=$i?>][container_no]" {{ $readonly }} value="{{ $list['container_no'] }}" class="form-control container_no"></td>
                            <td><input type="text" maxlength="50" name="containerbookingdetail[<?=$i?>][seal_no_1]" {{ $readonly }} value="{{ $list['seal_no_1'] }}" class="form-control seal_no_1"></td>
                            <td><input type="text" maxlength="50" name="containerbookingdetail[<?=$i?>][seal_no_2]" {{ $readonly }} value="{{ $list['seal_no_2'] }}" class="form-control seal_no_2"></td>
                            <td><input type="number" min="1" name="containerbookingdetail[<?=$i?>][package]" {{ $readonly }} value="{{ $list['package'] }}" class="form-control package"></td>
                            <td><input type="number" min="1" step="any" name="containerbookingdetail[<?=$i?>][weight]" {{ $readonly }} value="{{ $list['weight'] }}" class="form-control weight"></td>
                            <td><input type="number" min="1" step="any" name="containerbookingdetail[<?=$i?>][vgm]" {{ $readonly }} value="{{ $list['vgm'] }}" class="form-control vgm"></td>
                            <td>KGS</td>
                            <td><input type="number" min="1" step="any" name="containerbookingdetail[<?=$i?>][measure]" {{ $readonly }} value="{{ $list['measure'] }}" class="form-control measure"></td>
                            <td><input type="text" name="containerbookingdetail[<?=$i?>][st]" value="{{ $list['st'] }}" {{ $readonly }} class="form-control st"></td>
                            <td><input type="number" min="1" maxlength="11" name="containerbookingdetail[<?=$i?>][rf]" {{ $readonly }} value="{{ $list['rf'] }}" class="form-control rf"></td>
                            <td>@if(isset($list['id']) && $booking_status !== $statusApproved)<button type="button" onclick="onDelete(this)" data-id="{{ $list['id'] }}" class="btn btn-sm btn-danger action-delete">Del</button>@endif</td>
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
<!-- Modal -->
<div class="modal fade" id="confirmBookingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content panel-warning">
            <div class="modal-header panel-heading-warning">
                <h5 class="modal-title" id="exampleModalLabel"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> WARNING</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                The current number of containers does not match the requirements of the booking.<br/> Do you want to continue?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning continue-confirm-booking">YES</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="confirmInfoBookingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content panel-info">
            <div class="modal-header panel-heading-info">
                <h5 class="modal-title" id="exampleModalLabel"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> CONFIRM</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>After confirming you will not be able to perform the actions.</p>
                Do you want to continue?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info continue-confirm-booking">YES</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
            </div>
        </div>
    </div>
</div>
<style>
    .btn-primary:disabled {
        cursor: no-drop;
    }
    .add-full {
        margin-bottom: 15px;
    }
    .modal-body p {
        margin-bottom: 0.3rem;
    }
    .modal-header.panel-heading-danger {
        background-color: #e55353;
        border-color: #e55353;
        color: #fff;
    }
    .modal-header.panel-heading-warning {
        background-color: #f9b115;
        border-color: #f9b115;
    }
    .modal-header.panel-heading-info {
        background-color:#39f;
        border-color: #39f;
        color: #fff;
    }
    .form-control:disabled, .form-control[readonly], .form-control:disabled, .form-control[readonly]:focus {
        background: rgba(0, 0, 0, 0);
        border: 0;
        box-shadow: 0 0 0 0;
    }
</style>

<script type="text/javascript">
    function onDelete(e) {
        let ID = $(e).attr('data-id');
        $('#delete').attr('data-id', ID);
        $('#confirmDeleteModal').modal('show');
    }
    $(function () {
        function getAllValues() {
            var inputValues = $('#main-form :input').map(function() {
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

        function confirmBooking() {
            let inputValues = [];
            inputValues.push({name: 'confirm-booking', value:true})
            inputValues.push({name: '_token', value:$('input[name="_token"]').val()})
            inputValues.push({name: '_method', value:$('input[name="_method"]').val()})
            $.ajax({
                url: $('form').prop("action"),
                dataType: "json",
                method: 'post',
                data: inputValues,
                success: function (result) {
                    if (typeof result.data.booking_status !== undefined && result.data.booking_status === '{{$statusApproved}}') {
                        $('.table-container-list input').each((index,item) => {
                            item.setAttribute('readonly', true)
                        });
                        $('.table-container-list .action-delete').remove();
                        $('#confirm-booking').remove();
                        $('#save-container').remove();
                    }
                    toastr.success(result.message)
                },
                error: err => {
                    toastr.error(err.responseJSON.message)
                }
            });
        }
        $('#confirm-booking').on('click', e => {
            e.preventDefault();
            if ($('.table-container-list tbody tr').length !== $('.table-container-list tbody tr .action-delete').length) {
                $('#confirmBookingModal').modal('show');
            } else {
                $('#confirmInfoBookingModal').modal('show');
            }
        });
        $('.continue-confirm-booking').on('click', e => {
            e.preventDefault();
            confirmBooking();
            $('#confirmBookingModal').modal('hide');
            $('#confirmInfoBookingModal').modal('hide');
        });
        $('#save-container').on('click', e => {
            e.preventDefault();
            if ($('#is-booking').length > 0) {
                var inputValues = getAllValues();
                inputValues.push({name: 'save-container', value:true})
                inputValues.push({name: '_token', value:$('input[name="_token"]').val()})
                inputValues.push({name: '_method', value:$('input[name="_method"]').val()})
                $.ajax({
                    url: $('form').prop("action"),
                    dataType: "json",
                    method: 'post',
                    data: inputValues,
                    success: function (result) {
                        $.each(result.data, (index, item) => {
                            let tr = $('.table-container-list tbody tr:nth-child('+parseInt(item.position)+')');
                            var input = $("<button type=\"button\" onclick=\"onDelete(this)\" data-id=\""+item.id+"\" class=\"btn btn-sm btn-danger action-delete\">Del</button>")
                            tr.find('td:last-child').html(input);
                        });
                        toastr.success(result.message)
                    },
                    error: err => {
                        toastr.error(err.responseJSON.message)
                    }
                });
            } else {
                $('#form-transport-container').submit();
            }
        });
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
        });
        $('#delete').on('click', e => {
            let ID = e.target.getAttribute('data-id');
            if (typeof ID !== undefined) {
                $('#confirmDeleteModal').modal('hide');
                $.ajax({
                    url: "/booking/transport/registration/"+ID,
                    dataType: "json",
                    method: 'delete',
                    data: {
                        _token: $('input[name="_token"]').val()
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
    })
</script>
