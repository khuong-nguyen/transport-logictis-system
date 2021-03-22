@push('scripts')
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endpush
@extends('layout.app')
@section('title', 'Booking Registration')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="panel panel-default" style="margin-bottom: 0px">
                  <div class="panel-heading" style="color:#d81c61">Booking Action</div>
                  <div class="form-group row" style="margin-top: 10px; margin-bottom: 5px">
                      <label class="col-form-label required" for="booking_no" style="margin-left: 30px; margin-right: 10px">Booking No:</label>
                      <input class="form-control col-md-2" id="edit_booking_no" type="text" name="edit_booking_no" autocomplete = "off">
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary btn-edit-booking">Show</button>
                            <button type="button" class="btn btn-primary btn-new-booking">Registration</button>
                        </div>
                    </div>
                </div>
                <div class="card-body container-fluid">
                    @if (session('status'))
                        <div class="alert alert-success">@lang(session('status'))</div>
                    @endif
                    <form id="form" action="/booking/registration{{ isset($booking) ? '/'.$booking->id :''}}" method="post">
                        @csrf
                        @if(isset($booking))  @method('PUT') @endif
                        <div class="row">
                            <div class="col ">
                                <div class="nav-tabs-boxed form-group">
                                    <ul class="nav nav-tabs" role="tablist" >
                                        <li class="nav-item"><a class="nav-link active" id="bkg_tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home">BKG Creation Tab</a></li>
                                        <li class="nav-item"><a class="nav-link" id="cust_tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="profile">Customer Tab<label class="required"></label></a></li>
                                        @if(isset($booking))
                                            <li class="nav-item"><a class="nav-link" id="container_tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="profile">Container Detail</a></li>
                                            <li class="nav-item"><a class="nav-link" id="schedule_tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="profile">Transport Schedule</a></li>
                                            <li class="nav-item"><a class="nav-link" id="advance_money_tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="profile">Advance Money</a></li>
                                        @endif
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="bkg_tab">
                                            <div class="form-row">
                                                @if(isset($booking) && $booking->booking_status == "BOOKING")
                                                <div class="form-group row">
                                                    <label class="required" style = "margin-left: 25px; margin-right: 10px" for="booking_no">BKG No</label>
                                                    <input class="form-control col-md-6 @if($errors->has('booking.booking_no')) is-invalid @endif" style = "height: 28px" name="booking[booking_no]" id="booking_no" type="text"
                                                            value="{{ old('booking.booking_no') ?? $booking->booking_no ?? '' }}" required>
                                                        @error('booking.booking_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                                @elseif(isset($booking) && $booking->booking_status == "VIRTUAL")
                                                <div class="form-group row">
                                                    <label class="col-md-3 pr-0 col-form-label" for="virtual_booking_no">Virtual BKG No: </label>
                                                    <label class="col-md-5 pr-0 col-form-label" for="virtual_booking_no">{{$booking->virtual_booking_no ?? '' }} </label>
                                                </div>
                                                @elseif(isset($booking) && $booking->booking_status == "ORDER")
                                                <div class="form-group row">
                                                    <label class="col-md-3 pr-0 col-form-label" for="request_order_no">Request No: </label>
                                                    <label class="col-md-5 pr-0 col-form-label" for="request_order_no">{{$booking->request_order_no ?? '' }} </label>
                                                </div>
                                                @endif
                                                
                                                @if(isset($booking))
                                                <div class="form-group row col-md-5">
                                                <label class="form-label" for="booking_status">Booking Status </label>
                                                    <div class="col-md-3 pr-0">
                                                        {{ Form::radio('booking[booking_status]', 'ORDER', $booking->booking_status == 'ORDER'?true:false )}} Order
                                                    </div>
                                                    <div class="col-md-3 pr-0">
                                                        {{ Form::radio('booking[booking_status]', 'VIRTUAL', $booking->booking_status == 'VIRTUAL'?true:false )}} Virtual
                                                    </div>
                                                    <div class="col-md-3 pr-0">
                                                        {{ Form::radio('booking[booking_status]', 'BOOKING', $booking->booking_status == 'BOOKING'?true:false )}} Booking
                                                    </div>
                                                    
                                                </div>
                                                @endif
                                                <div class="panel panel-default col-md-7" style="margin-bottom: 0px">
                                                    <div class="panel-heading" style="color:#d81c61">Thông tin tàu</div>
                                                    <div class="form-group row" style="margin-bottom:5px; margin-top:5px;">
                                                        <label class="required" style="margin-left: 25px; margin-right: 10px" for="tvvd" >T/VVD:</label>
                                                        <input class="form-control col-md-6 @if($errors->has('booking.tvvd')) is-invalid @endif" style="height: 28px" id="tvvd" type="text" name="booking[tvvd]" required value="{{ old('booking.tvvd') ?? $booking->tvvd ?? '' }}">
                                                            @error('booking.tvvd')<br/><div class="invalid-feedback">{{ $message }}</div>@enderror
                                                    </div>
                                                    <div class="form-group row" style="margin-bottom:5px">
                                                        <label class="required" style="margin-left: 25px; margin-right: 25px" for="por_1">POR</label>
                                                        <input class="form-control col-md-2 por_booking @if($errors->has('booking.por_1')) is-invalid @endif" style="height: 28px" id="por_1" type="text" name="booking[por_1]" value="{{ old('booking.por_1') ?? $booking->por_1 ?? '' }}" autocomplete="off">
                                                        <input class="form-control col-md-2 @if($errors->has('booking.por_2')) is-invalid @endif" style="height: 28px; margin-left:5px" id="por_2" type="text" name="booking[por_2]" value="{{ old('booking.por_2') ?? $booking->por_2 ?? '' }}" autocomplete="off" readonly>
                                                        <div class="input-group-prepend btnSearchPOR">
                                                            <span class="input-group-text">
                                                                <svg class="c-icon">
                                                                <use xlink:href="/assets/icons/sprites/free.svg#cil-search"></use>g#cui-user"></use>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <label class="required" style="margin-left: 10px; margin-right: 10px" for="pol_1">POL</label>
                                                        <input class="form-control col-md-2 pol_booking @if($errors->has('booking.pol_1')) is-invalid @endif" style="height: 28px" id="pol_1" type="text" name="booking[pol_1]" value="{{ old('booking.por_1') ?? $booking->pol_1 ?? '' }}" autocomplete="off">
                                                        <input class="form-control col-md-2" style="height: 28px; margin-left:5px;" id="pol_2" type="text" name="booking[pol_2]" value="{{ old('booking.pol_2') ?? $booking->pol_2 ?? '' }}" readonly>
                                                        <div class="input-group-prepend btnSearchPOL">
                                                            <span class="input-group-text">
                                                                <svg class="c-icon">
                                                                <use xlink:href="/assets/icons/sprites/free.svg#cil-search"></use>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                            @error('booking.por_1')<div class="invalid-feedback" style="position: relative; width: 400%">{{ $message }}</div>@enderror
                                                            @error('booking.por_2')<div class="invalid-feedback " style="position: relative; width: 400%">{{ $message }}</div>@enderror
                                                            @error('booking.pol_1')<div class="invalid-feedback" style="position: relative; width: 400%">{{ $message }}</div>@enderror
                                                        <input type = "hidden" id="pol_address" name = "pol_address" value = "{{ $booking->pol_address ?? $booking->pol_address ?? '' }}"/>
                                                    </div>

                                                    <div class="form-group row" style="margin-bottom:5px">
                                                        <label class ="required" style="margin-left: 25px; margin-right: 25px" for="pod_1">POD</label>
                                                        <input class="form-control col-md-2 pod_booking @if($errors->has('booking.pod_1')) is-invalid @endif" style="height: 28px" id="pod_1" type="text" name="booking[pod_1]" value="{{ old('booking.pod_1') ?? $booking->pod_1 ?? '' }}" autocomplete="off">
                                                        <input class="form-control col-md-2" style="height: 28px; margin-left:5px" id="pod_2" type="text" name="booking[pod_2]" value="{{ old('booking.pod_2') ?? $booking->pod_2 ?? '' }}" readonly>
                                                        <div class="input-group-prepend btnSearchPOD" style="height: 28px">
                                                            <span class="input-group-text">
                                                                <svg class="c-icon">
                                                                <use xlink:href="/assets/icons/sprites/free.svg#cil-search"></use>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <label class="col-form-label required" for="del_1" style="margin-left: 10px; margin-right: 10px" >DEL</label>
                                                        <input class="form-control col-md-2 del_booking @if($errors->has('booking.del_1')) is-invalid @endif" style="height: 28px" id="del_1" type="text" name="booking[del_1]" value="{{ old('booking.del_1') ?? $booking->del_1 ?? '' }}" autocomplete="off">   
                                                        <input class="form-control col-md-2" style="height: 28px; margin-left:5px" id="del_2" type="text" name="booking[del_2]" value="{{ old('booking.del_2') ?? $booking->del_2 ?? '' }}" readonly>
                                                        <div class="input-group-prepend btnSearchDEL" style="height: 28px">
                                                            <span class="input-group-text">
                                                                <svg class="c-icon">
                                                                <use xlink:href="/assets/icons/sprites/free.svg#cil-search"></use>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        @error('booking.pod_1')<div class="invalid-feedback" style="position: relative; width: 400%">{{ $message }}</div>@enderror
                                                        @error('booking.del_1')<div class="invalid-feedback" style="position: relative; width: 400%">{{ $message }}</div>@enderror
                                                        <input type = "hidden" id="del_address" name = "del_address" value = "{{ $booking->del_address ?? $booking->del_address ?? '' }}"/>
                                                    </div>
                                                    <div class="form-group row" style="margin-bottom:5px">
                                                        <label style="margin-left: 25px; margin-right: 28px" for="text-input">Term</label>
                                                        <input class="form-control col-md-2 @if($errors->has('booking.r_d_term_1')) is-invalid @endif" style="height: 28px" id="r_d_term_1" type="text" name="booking[r_d_term_1]" value="{{ old('booking.r_d_term_1') ?? $booking->r_d_term_1 ?? '' }}">
                                                                @error('booking.r_d_term_1')<div class="invalid-feedback" style="position: relative; width: 400%">{{ $message }}</div>@enderror
                                                        <input class="form-control col-md-4" style="height: 28px; margin-left:5px" id="r_d_term_2" type="text" name="booking[r_d_term_2]" value="{{ old('booking.r_d_term_2') ?? $booking->r_d_term_2 ?? '' }}">
                                                    </div>
                                                    <div class="form-group row" style="margin-bottom:5px">
                                                            <label style="margin-left: 25px; margin-right: 14px" for="b_l_no" style = "text-align: right">B/L No</label>
                                                            <input class="form-control col-md-3 @if($errors->has('booking.b_l_no')) is-invalid @endif" style="height: 28px" id="b_l_no" type="text" name="booking[b_l_no]"
                                                                    value="{{old('booking.b_l_no') ?? $booking->b_l_no ?? ''}}">
                                                                @error('booking.b_l_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                            <div class="custom-control custom-checkbox col-md-2" style="margin-left:10px">
                                                                <input class="custom-control-input" id="si" @if(old('booking.si') == 1 || (isset($booking) && $booking->si ==1)) checked @endif type="checkbox" value="1" name="booking[si]" >
                                                                <label class="custom-control-label" for="si">SI</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox col-md-2">
                                                                <input class="custom-control-input" id="brd" @if(old('booking.brd') == 1 || (isset($booking) && $booking->brd ==1)) checked @endif type="checkbox" value="1" name="booking[brd]">
                                                                <label class="custom-control-label" for="brd">BRD</label>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default col-md-5" style="margin-bottom: 0px">
                                                    <div class="panel-heading" style="color:#d81c61">Thông tin khách hàng</div>
                                                    
                                                    <div class="form-group row" style="margin-bottom:5px; margin-top:5px">
                                                        <label class="col-md-2 col-form-label" style = "text-align: right">SHBR</label>
                                                        <input class="form-control col-md-2 shipper" style="height: 28px" id="SHBR_customer_code" type="text" value="{{ $shipper->customer_code ?? ''}}" name="SHBR[code]" autocomplete = "off" >
                                                        <input class="form-control col-md-6" style="height: 28px; margin-left:5px" id="SHBR_customer_legal_english_name" type="text" value="{{ $shipper->customer_legal_english_name ?? ''}}" name="SHBR[full]" >
                                                        <div class="input-group-prepend btnSearchSHBR" style="height: 28px">
                                                            <span class="input-group-text">
                                                                <svg class="c-icon">
                                                                <use xlink:href="/assets/icons/sprites/free.svg#cil-search"></use>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <input type = "hidden" id="SHBR_store_address" name = "SHBR_store_address" value = "{{$shipper->customer_store_address1??''}}"/>
                                                    </div>
                                                    <div class="form-group row" style="margin-bottom:5px">
                                                        <label class="col-md-2 col-form-label" style = "text-align: right">FWDR</label>
                                                        <input class="form-control col-md-2 forwarder" style="height: 28px" id="FWDR_customer_code" type="text" value="{{ $forwarder->customer_code ?? ''}}" name="FWDR[code]" autocomplete = "off">
                                                        <input class="form-control col-md-6" style="height: 28px; margin-left:5px" id="FWDR_customer_legal_english_name" type="text" value="{{ $forwarder->customer_legal_english_name ?? ''}}" name="FWDR[full]">
                                                        <div class="input-group-prepend btnSearchFWDR" style="height: 28px">
                                                            <span class="input-group-text">
                                                                <svg class="c-icon">
                                                                <use xlink:href="/assets/icons/sprites/free.svg#cil-search"></use>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" style="margin-bottom:5px">
                                                        <label class="col-md-2 col-form-label" style = "text-align: right">CNEE</label>
                                                        <input class="form-control col-md-2 consignee" style="height: 28px" id="CNEE_customer_code" type="text" value="{{ $consignee->customer_code ?? ''}}" name="CNEE[code]" autocomplete = "off">
                                                        <input class="form-control col-md-6" style="height: 28px; margin-left:5px" id="CNEE_customer_legal_english_name" type="text" value="{{ $consignee->customer_legal_english_name ?? ''}}" name="CNEE[full]">
                                                        <div class="input-group-prepend btnSearchCNEE" style="height: 28px">
                                                            <span class="input-group-text">
                                                                <svg class="c-icon">
                                                                <use xlink:href="/assets/icons/sprites/free.svg#cil-search"></use>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <input type = "hidden" id="CNEE_store_address" name = "CNEE_store_address" value = "{{$consignee->customer_store_address1??''}}"/>
                                                    </div>
                                                </div>
                                                
                                        </div>
                                        <hr>
                                        <div class="form-row">
                                                <div class="panel panel-default col-md-12" style="margin-bottom: 0px">
                                                    <div class="panel-heading" style="color:#d81c61">Thông tin vận chuyển hàng hoá xuất nhập</div>
                                                    <div class="form-group row">
                                                        <div class="col-md-2" style = "margin-left: 15px">
                                                            {{ Form::radio('booking[booking_type]', 'IMPORT', isset($booking->booking_type) ? ($booking->booking_type == 'IMPORT' ? true:false) : true)}} Hàng nhập
                                                        </div>
                                                        <div class="col-md-2">
                                                            {{ Form::radio('booking[booking_type]', 'EXPORT', isset($booking->booking_type) ? ($booking->booking_type == 'EXPORT'?true:false) : false )}} Hàng xuất
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" style="margin-bottom:5px">
                                                        <label style = "margin-left: 35px; margin-right: 130px">ETB</label>
                                                        <div class="input-group date" style="width: 15%">
                                                            <input class="form-control" id="etb_dt" type="text" name="booking[etb_dt]" autocomplete="off" value="{{old('booking.etb_dt') ?? $booking->etb_dt ?? ''}}">
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar">
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" style="margin-bottom:5px">
                                                        <label style = "margin-left: 35px; margin-right: 20px">Thời gian nhận hàng</label>
                                                        <div class="input-group date" style="width: 15%">
                                                            <input class="form-control" id="pick_up_dt" type="text" name="booking[pick_up_dt]" autocomplete="off" value="{{old('booking.pick_up_dt') ?? $booking->pick_up_dt ?? ''}}">
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar">
                                                                </span>
                                                            </span>
                                                        </div>
                                                        <label style = "margin-left: 20px; margin-right: 15px">Nơi nhận</label>
                                                        <input class="form-control col-md-4" style="height: 28px" id="pickup_address" type="text" value="{{ $booking->pickup_address ?? ''}}" name="booking[pickup_address]">
                                                    </div>
                                                    <div class="form-group row" style="margin-bottom:5px">
                                                        <label class = "required" style = "margin-left: 35px; margin-right: 20px" for="sailling_due_date">Thời gian giao hàng</label>
                                                        <div class="input-group date" style="width: 15%">
                                                            <input class="form-control @if($errors->has('booking.sailling_due_date')) is-invalid @endif" id="sailling_due_date" required type="text" name="booking[sailling_due_date]" autocomplete="off" 
                                                            value="{{old('booking.sailling_due_date') ?? $booking->sailling_due_date ?? ''}}"
                                                            >
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar">
                                                                </span>
                                                            </span>
                                                        </div>
                                                        
                                                        <label style = "margin-left: 20px; margin-right: 18px" >Nơi giao</label>
                                                        <input class="form-control col-md-4" style="height: 28px" id="delivery_address" type="text" value="{{ $booking->delivery_address ?? ''}}" name="booking[delivery_address]">
                                                        @error('booking.sailling_due_date')<br/><label class="col-md-2" style = "color: red">{{ $message }}</label>@enderror  
                                                    </div>
                                                    <div class="form-group row" style="margin-bottom:5px">
                                                        <label style = "margin-left: 35px; margin-right: 8px" for="recieve_return_con">Nơi nhận/trả Con rỗng </label>
                                                        <input class="form-control receive_take_con_place" style="height: 28px; width:10%; margin-right: 5px" id="receive_take_con_place" type="text" name="booking[receive_take_con_place]" value="{{old('booking.receive_take_con_place') ?? $booking->receive_take_con_place ?? ''}}" autocomplete = "off">
                                                        <input class="form-control" style="height: 28px; width:20%" id="pick_up_cy" type="text" name="booking[pick_up_cy]" value="{{old('booking.pick_up_cy') ?? $booking->pick_up_cy ?? ''}}">
                                                        <div class="input-group-prepend btnSearchCONPLACE" style="height: 28px">
                                                            <span class="input-group-text">
                                                                <svg class="c-icon">
                                                                <use xlink:href="/assets/icons/sprites/free.svg#cil-search"></use>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <input class="form-control hide" style="height: 28px; width:40%" id="full_return_cy" type="text" name="booking[full_return_cy]" value="{{old('booking.full_return_cy') ?? $booking->full_return_cy ?? ''}}">
                                                    </div>
                                                    <div class="form-group row" style="margin-bottom:5px">
                                                        <label style = "margin-left: 35px; margin-right: 60px" for = "bkg_contact_name">Người liên lạc</label>
                                                        <input class="form-control" style="height: 28px; width:20%" id="bkg_contact_name" type="text" name="booking[bkg_contact_name]" value="{{old('booking.bkg_contact_name') ?? $booking->bkg_contact_name ?? ''}}">
                                                    </div>
                                                    <div class="form-group row" style="margin-bottom:5px">
                                                        <label style = "margin-left: 35px; margin-right: 120px" for = "bkg_contact_email">Email</label>
                                                        <input class="form-control" style="height: 28px; width:20%" id="bkg_contact_email" type="email" name="booking[bkg_contact_email]" value="{{old('booking.bkg_contact_email') ?? $booking->bkg_contact_email ?? ''}}">
                                                    </div>
                                                    <div class="form-group row" style="margin-bottom:5px">
                                                        <label style = "margin-left: 35px; margin-right: 90px" for = "bkg_contact_tel">Điện thoại</label>
                                                        <input class="form-control" style="height: 28px; width:20%" id="bkg_contact_tel" type="text" name="booking[bkg_contact_tel]" value="{{old('booking.bkg_contact_tel') ?? $booking->bkg_contact_tel ?? ''}}">
                                                    </div>
                                                    <div class="form-group row" style="margin-bottom:5px">
                                                        <label style = "margin-left: 35px; margin-right: 112px" for="BOFC">B.OFC</label>
                                                        <input class="form-control" style="height: 28px; width:10%" id="BOFC" type="text" readonly name="BOFC">
                                                        <label style = "margin-left: 20px; margin-right: 10px" for="BStaff">B.Staff</label>
                                                        <input class="form-control" style="height: 28px; width:10%" id="BStaff" type="text" name="BStaff" readonly>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <hr>
                                            <div class="form-row">
                                                <div class="panel panel-default col-md-12" style="margin-bottom: 0px">
                                                    <div class="panel-heading" style="color:#d81c61">Thông tin hàng hoá và loại Container</div>
                                                    <div class="form-group row" style="margin-bottom:5px; margin-top:10px">
                                                            <label style="margin-left: 25px; margin-right: 25px" for="cmdt_1">CMDT</label>
                                                            <input class="form-control col-md-1 @if($errors->has('booking.cmdt_1')) is-invalid @endif" style="height: 28px" id="cmdt_1" type="text" name="booking[cmdt_1]" value="{{old('booking.cmdt_1') ?? $booking->cmdt_1 ?? ''}} " >
                                                                    @error('booking.cmdt_1')<div class="invalid-feedback" style="position: relative; width: 200%">{{ $message }}</div>@enderror
                                                            <input class="form-control col-md-3" style="height: 28px; margin-left:5px" id="cmdt_2" type="text" name="booking[cmdt_2]" value="{{old('booking.cmdt_2') ?? $booking->cmdt_2 ?? ''}}" >
                                                            <div class="input-group-prepend" style="height: 28px">
                                                                <span class="input-group-text">
                                                                    <svg class="c-icon">
                                                                    <use xlink:href="/assets/icons/sprites/free.svg#cil-search"></use>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <label class="col-md-1 col-form-label" for="weight">Weight</label>
                                                            <input class="form-control col-md-1 @if($errors->has('booking.weight')) is-invalid @endif" style="height: 28px" id="weight" type="text" name="booking[weight]" value="{{old('booking.weight') ?? $booking->weight ?? ''}}">
                                                                    @error('booking.weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                            <input class="form-control col-md-1 @if($errors->has('booking.unit')) is-invalid @endif" type="text" style="height: 28px; margin-left:5px" name="booking[unit]" placeholder="unit" value="{{old('booking.unit') ?? $booking->unit ?? 'KGS'}}">
                                                            @error('booking.unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom:10px">
                                                            <label style="margin-left: 25px; margin-right: 10px" for="TotalVol">Total Vol</label>
                                                            <?php
                                                                if(old('TotalVol')) {$old = old('TotalVol'); } elseif(isset($containers)) $old = $containers->sum('vol');
                                                            ?>
                                                            <input class="form-control col-md-1" id="TotalVol" type="text" value="{{ $old ?? 0}}" style="height: 28px" name="TotalVol" readonly >
                                                            <label style="margin-left: 10px; margin-right: 10px" for="lofc_1">L.OFC/Rep.:</label>
                                                            <input class="form-control col-md-1 @if($errors->has('booking.lofc_1')) is-invalid @endif" style="height: 28px" id="lofc_1" type="text" name="booking[lofc_1]" value="{{old('booking.lofc_1') ?? $booking->lofc_1 ?? ''}}">
                                                                    @error('booking.lofc_1')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                            <input class="form-control col-md-2" type="text" style="height: 28px; margin-left: 5px" name="booking[lofc_2]"  value="{{old('booking.lofc_2') ?? $booking->lofc_2 ?? ''}}">
                                                            <div class="custom-control custom-checkbox col-md-3" style="margin-left: 15px">
                                                                <input class="custom-control-input" id="fh" @if(old('booking.fh') == 1 || (isset($booking) && $booking->fh ==1) )checked @endif type="checkbox" value="1" name="booking[fh]">
                                                                <label class="custom-control-label" for="fh">Fh</label>
                                                            </div>
                                                        </div>
                                                <div class="row col-md-12">
                                                        <div class="col-md-7">
                                                            <table class="table table-responsive-sm table-bordered" id="container_table">
                                                                <thead>
                                                                <tr>
                                                                    <th>TP/SZ <label class="required"></th>
                                                                    <th>Vol <label class="required"></label></th>
                                                                    <th>EQ Sub(Incl. R/D</th>
                                                                    <th>S.O.C</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr id="container_error" class="d-none">
                                                                    <td colspan="5">
                                                                        <span class="error-messages">The TP/SZ has already been taken</span>
                                                                    </td>
                                                                    <input type="hidden" value="" id="deletedBookingContainer" name="deletedBookingContainer">
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <select class="form-control select2" id="select1" style="width: 100%;" name="select1"></select>
                                                                    </td>
                                                                    <td><input type="number" min="1" value="1" class="form-control" id="container_vol">
                                                                    	<span id = "added_container_vol" class="error-messages d-none">Vol must be greater zero</span>
                                                                    </td>
                                                                    <td><input type="number" min="0" value="0" class="form-control" id="container_eq_sub"></td>
                                                                    <td><input type="number" min="0" value="0" class="form-control" id="container_soc"></td>
                                                                    <td>
                                                                        <button class="btn btn-sm btn-primary" id="add_container" type="button">Add</button>
                                                                    </td>
                                                                </tr>

                                                                
                                                                @if(isset($containers))
                                                                    @foreach($containers as $key => $container)
                                                                        @php($id = $container->container_id ?? $key)
                                                                        <tr>
                                                                            <td>
                                                                                @if(old('container'))
                                                                                <input type="hidden" value="{{$container['container_code']}}" id="container_id_{{$id}}" name="container[{{$id}}][container_code]">
                                                                                <input type="hidden" value="{{$container['text']}}" name="container[{{$id}}][text]">
                                                                                <input type="hidden" value="{{$container->id}}" id="container_id_{{$container->container_id}}" name="container[{{$container->container_id}}][id]">
                                                                                @else
                                                                                    <input type="hidden" value="{{$container->id}}" id="container_id_{{$container->container_id}}" name="container[{{$container->container_id}}][id]">
                                                                                @endif
                                                                                <label class="col-form-label">{{$container['text']??$container->container->container_code}}</label>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" min="1" class="form-control @if($errors->has('container.'.$key.'.vol')) is-invalid @endif" name="container[{{$id}}][vol]" id="container_vol_{{$id}}" name="container[{{$id}}][vol]" value="{{$container['vol']??$container->vol}}">
                                                                                @error('container.'.$key.'.vol')<div class="invalid-feedback">Vol field is required.</div>@enderror
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control" name="container[{{$id}}][eq_sub]" value="{{$container['eq_sub']??$container->eq_sub}}">
                                                                            </td>
                                                                            <td><input type="number" class="form-control" min="0" name="container[{{$id}}][soc]" value="{{$container['soc']??$container->soc}}"></td>
                                                                            <td><button class="btn btn-sm btn-primary" id="delete_container" type="button" onclick="remove(this,{{$id}})">Delete</button></td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                            
                                                        </div>
                                                </div>
                                                </div>
                                                
                                            </div>
                                            <hr>
                                            
                                            <div class="form-row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-md-2 col-form-label" for="ext_remark">Ext Remark</label>
                                                            <div class="col-md-9">
                                                                <textarea class="form-control" id="ext_remark" name="booking[ext_remark]" rows="9" placeholder="Content..">{{old('booking.ext_remark') ?? $booking->ext_remark ?? ''}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-md-2 col-form-label" for="int_remark"> Int Remark</label>
                                                            <div class="col-md-10">
                                                                <textarea class="form-control" id="int_remark" name="booking[int_remark]" rows="9" placeholder="Content..">{{old('booking.int_remark') ?? $booking->int_remark ?? ''}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="cust_tab">
                                            <div class="form-row row">
                                                <div class="col-md-8">
                                                    <div class="card-body border">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <input type="hidden" value="{{old('booking.shipper_id')??$booking->shipper_id ?? ''}}" id="shipper_id" name="booking[shipper_id]">
                                                                        <label class="col-form-label required" for="shipper_country">Shipper</label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="customer_legal_english_name">Name</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="customer_legal_english_name" value="{{old('shipper.customer_legal_english_name') ?? $shipper->customer_legal_english_name ?? ''}}" type="text" name="shipper[customer_legal_english_name]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="customer_address">Address</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="customer_address" value="{{old('shipper.customer_address') ?? $shipper->customer_address ?? ''}}" type="text" name="shipper[customer_address]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="city">City</label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input class="form-control" id="city" value="{{old('shipper.city') ?? $shipper->city ?? ''}}" type="text" name="shipper[city]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="location_code" value="{{old('shipper.location_code') ?? $shipper->location_code ?? ''}}" type="text" name="shipper[location_code]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="country_code">Country</label>
                                                                    </div>
                                                                    <div class="col-md-3 pr-0">
                                                                        <input class="form-control" id="country_code" value="{{old('shipper.country_code') ?? $shipper->country_code ?? ''}}" type="text" name="shipper[country_code]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                    <div class="col-md-3 pr-0">
                                                                        <label class="col-form-label" for="zip_code">Zip Code</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="zip_code" value="{{old('shipper.zip_code') ?? $shipper->zip_code ?? ''}}" type="text" name="shipper[zip_code]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="post_office_box ">Street/P.O  Box</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="post_office_box" value="{{old('shipper.post_office_box') ?? $shipper->post_office_box ?? ''}}" type="text" name="shipper[post_office_box]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="fax">Fax</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="fax" value="{{old('shipper.fax') ?? $shipper->fax ?? ''}}" type="text" name="shipper[fax]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="email">Email</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="email" value="{{old('shipper.email') ?? $shipper->email ?? ''}}" type="email" name="shipper[email]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="tel">Tel</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="tel" value="{{old('shipper.tel') ?? $shipper->tel ?? ''}}" type="text" name="shipper[tel]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body border my-1">
                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-4">
                                                                        <input type="hidden" value="{{old('booking.consignee_id')??$booking->consignee_id ?? ''}}" name="booking[consignee_id]"  id="consignee_id">
                                                                        <label class="col-form-label" for="text-input">Consignee</label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="consignee_name">Name</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="consignee_customer_legal_english_name" value="{{old('consignee.customer_legal_english_name') ?? $consignee->customer_legal_english_name ?? ''}}" type="text" name="consignee[customer_legal_english_name]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="consignee_customer_address">Address</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="consignee_customer_address" value="{{old('consignee.customer_address') ?? $consignee->customer_address ?? ''}}" type="text" name="consignee[customer_address]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="consignee_city">City</label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input class="form-control" id="consignee_city" value="{{old('consignee.city') ?? $consignee->city ?? ''}}" type="text" name="consignee[city]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="consignee_location_code" value="{{old('consignee.location_code') ?? $consignee->location_code ?? ''}}" type="text" name="consignee[location_code]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="consignee_country_code">Country</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="consignee_country_code" value="{{old('consignee.country_code') ?? $consignee->country_code ?? ''}}" type="text" name="consignee[country_code]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                    <div class="col-md-3 pr-0">
                                                                        <label class="col-form-label" for="consignee_zip_code">Zip Code</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="consignee_zip_code" value="{{old('consignee.zip_code') ?? $consignee->zip_code ?? ''}}" type="text" name="consignee[zip_code]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="consignee_street">Street/P.O  Box</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="consignee_street" value="{{old('consignee.post_office_box') ?? $consignee->post_office_box  ?? ''}}" type="text" name="consignee[post_office_box]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="consignee_fax">Fax</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="consignee_fax" value="{{old('consignee.fax') ?? $consignee->fax ?? ''}}" type="text" name="consignee[fax]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="consignee_email">Email</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="consignee_email" value="{{old('consignee.email') ?? $consignee->email ?? ''}}" type="email" name="consignee[email]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group  row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class=col-form-label" for="consignee_tel">Tel</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="consignee_tel" value="{{old('consignee.tel') ?? $consignee->tel ?? ''}}" type="text" name="consignee[tel]" @if(!isset($booking)) @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <div class="card-body border">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <label class="col-form-label" for="forwarder_country">Forwarder</label>
                                                                <input type="hidden" value="{{old('booking.forwarder_id')??$booking->forwarder_id ?? ''}}" name="booking[forwarder_id]" id="forwarder_id">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3">
                                                                <label class="col-form-label" for="text-input">Name & address</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <textarea class="form-control" id="forwarder_customer_address" name="forwarder[customer_address]" rows="3">{{old('forwarder.customer_address') ?? $forwarder->customer_address ?? ''}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(isset($booking))
                                            <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="container_tab">
                                                @include('transport.content_create')
                                            </div>
                                        @endif
                                        @if(isset($booking))
                                            <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="schedule_tab">
                                                @include('transport.schedule.detail')
                                            </div>
                                        @endif
                                        @if(isset($booking))
                                            <div class="tab-pane" id="tab5" role="tabpanel" aria-labelledby="advance_money_tab">
                                                @include('advance_money.booking.detail')
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer">
                                        <div class="form-row float-right">
                                            <div class="form-group  float-right">
                                                <div class="btn-group">
                                                    <button class="btn btn-primary" type="button" @if(!isset($booking)) disabled @endif>BKG Cancel</button>
                                                </div>
                                                <div class="btn-group">
                                                    <button class="btn btn-primary" type="button" @if(!isset($booking)) disabled @endif>Split</button>
                                                </div>
                                                <div class="btn-group">
                                                    <button class="btn btn-primary print" type="button" @if(!isset($booking)) disabled @endif>Print</button>
                                                </div>
                                                <div class="btn-group">
                                                    <button class="btn btn-primary" type="button" @if(!isset($booking)) disabled @endif>Copy</button>
                                                </div>
                                                <div class="btn-group">
                                                    <button class="btn btn-primary" type="submit" id="submit-form-save"> Save</button>
                                                </div>
                                                <div class="btn-group">
                                                    <button class="btn btn-primary" id="closeRegistration" role="button" type="button"> Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="searchLocationModal" name="searchLocationModal" tabindex="-1" role="dialog" aria-labelledby="searchLocationModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tìm kiếm vị trí</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <input type="search" class="form-control col-md-5" placeholder="Search" aria-label="Search"
                            aria-describedby="search-addon" id = "location-keyword-search" name = "location-keyword-search"/>
                        <button type="button" class="btn btn-primary btn-search-location">search</button>
                        <input type = "hidden" id = "searchLocationFrom" name = "searchLocationFrom" value = ""/>
                    </div>
                    <div id="locationResults" name="locationResults"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="searchCustomerModal" name="searchCustomerModal" tabindex="-1" role="dialog" aria-labelledby="searchCustomerModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tìm kiếm khách hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <input type="search" class="form-control col-md-5" placeholder="Search" aria-label="Search"
                            aria-describedby="search-addon" id = "customer-keyword-search" name = "customer-keyword-search"/>
                        <button type="button" class="btn btn-primary btn-search-customer">search</button>
                        <input type = "hidden" id = "searchCustomerFrom" name = "searchCustomerFrom" value = ""/>
                    </div>
                    <div id="customerResults" name="customerResults"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    @endpush
    <script type="text/javascript">

        $('#sidebar').removeClass('c-sidebar-lg-show');

        let containerId =[];
        var queryString = window.location.search;
        var action = document.getElementById("form").getAttribute("action");
        document.getElementById("form").setAttribute('action',action+queryString);
        
		var deletedBookingContainer = [];
		
        $(function () {
            $(sailling_due_date).datetimepicker({
                format: 'dd/mm/yyyy hh:mm',
                startDate: moment().toDate(),
                minView:1,
                autoclose: true,
                todayHighlight: true,
            }).on('changeDate', function (selected) {
                var maxDate = new Date(selected.date.valueOf());
                $(pick_up_dt).datetimepicker('setEndDate', $(sailling_due_date).data("datetimepicker").getDate());
            });

            $(pick_up_dt).datetimepicker({
                format: 'dd/mm/yyyy hh:mm',
                startDate: moment().toDate(),
                minView:1,
                autoclose: true,
                todayHighlight: true,
            }).on('changeDate', function (selected) {		
                var minDate = new Date(selected.date.valueOf());
                $(sailling_due_date).datetimepicker('setStartDate', $(pick_up_dt).data("datetimepicker").getDate());
                $(sailling_due_date).val('');
            });

            $(etb_dt).datetimepicker({
                format: 'dd/mm/yyyy hh:mm',
                startDate: moment().toDate(),
                minView:1,
                autoclose: true,
                todayHighlight: true,
            }).on('changeDate', function (selected) {		
                var minDate = new Date(selected.date.valueOf());
                $(pick_up_dt).datetimepicker('setStartDate', $(etb_dt).data("datetimepicker").getDate());
                $(pick_up_dt).val('');
            });

            $('#submit-form-save').on('click', e => {
                e.preventDefault();
                $('.table-container-list input').each((index,item) => {
                    item.setAttribute('readonly', true)
                });
                $('form').submit();
            });
            $('#select1').select2({
                placeholder: "Select a state",
                ajax: {
                    url: "/api/container/code",
                    dataType: "json",
                    delay: 200,
                    data: function (params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });

            $("#add_container").click(function(){
                var selected = $("#select1 option:selected").val();
                var vol = $('#container_vol').val();
                if(vol<1){
                	$('#added_container_vol').removeClass('d-none');
                	return;
                }
                if (selected &&  containerId.indexOf(selected) == -1){
                	$('#added_container_vol').addClass('d-none');
                    $('#container_table tr:last').after('<tr>'+
                        '<td>' + '<input type="hidden" value="'+selected+'" id="container_id_'+selected+'" name="container['+selected+'][container_code]">'+
                        '<input type="hidden" value="'+$("#select1 option:selected" ).text()+'" name="container['+selected+'][text]">'+
                        '<label class="col-form-label">'+$("#select1 option:selected" ).text()+'</label>' +
                        '</td>\n' +
                        '<td><input type="number" min="1" class="form-control" id="container_vol_'+selected+'" name="container['+selected+'][vol]"  value="'+vol+'"></td>\n' +
                        '<td><input type="number"  min="0" class="form-control" name="container['+selected+'][eq_sub]" value="'+$('#container_eq_sub').val()+'"></td>\n' +
                        '<td><input type="number"  min="0" class="form-control" name="container['+selected+'][soc]" value="'+$('#container_soc').val()+'"></td>\n' +
                        '<td><button class="btn btn-sm btn-primary" id="delete_container" type="button" onClick="remove(this,'+selected+')">Delete</button></td>'
                        +'</tr>');
                    $('#container_vol').val(1);
                    $('#container_eq_sub').val(0);
                    $('#container_soc').val(0)

                    var total = parseFloat($('#TotalVol').val());
                    total += parseFloat(vol);
                    $('#TotalVol').val(total);
                    containerId.push(selected);
                    $('#container_error').addClass('d-none');
                }else {
                    $('#container_error').removeClass('d-none');
                }
            });

            $('#shipper_search').click(function (){
                $.ajax({
                    url: "/api/customer/code",
                    dataType: "json",
                    method: 'get',
                    data: {
                        country: $('#shipper_country').val(),
                        code: $('#shipper_code').val()
                    },
                    success: function (result) {
                        $('#shipper_id').val(result.id);
                        $.each(result, function (key, value) {
                            $('#'+key).val(value);
                        })
                        
                        $('#SHBR_customer_code').val(result.customer_code)
                        $('#SHBR_customer_legal_english_name').val(result.customer_legal_english_name)
                    }
                });
            })

            $('#consignee_search').click(function (){
                $.ajax({
                    url: "/api/customer/code",
                    dataType: "json",
                    method: 'get',
                    data: {
                        country: $('#consignee_country').val(),
                        code: $('#consignee_code').val()
                    },
                    success: function (result) {
                        $('#consignee_id').val(result.id);
                        $.each(result, function (key, value) {
                            $('#consignee_'+key).val(value);
                        })
                        $('#CNEE_country_code').val(result.country_code)
                        $('#CNEE_customer_code').val(result.customer_code)
                        $('#CNEE_customer_legal_english_name').val(result.customer_legal_english_name)
                    }
                });
            })

            $('#forwarder_search').click(function (){
                $.ajax({
                    url: "/api/customer/code",
                    dataType: "json",
                    method: 'get',
                    data: {
                        country: $('#forwarder_country').val(),
                        code: $('#forwarder_code').val()
                    },
                    success: function (result) {
                        $('#forwarder_id').val(result.id);
                        $('#forwarder_customer_address').val(result.customer_address);
                        $('#FWDR_country_code').val(result.country_code)
                        $('#FWDR_customer_code').val(result.customer_code)
                        $('#FWDR_customer_legal_english_name').val(result.customer_legal_english_name)
                    }
                });
            })

            $('#closeRegistration').click(function (){
                var queryString = window.location.search;
                var url = '/'
                if (queryString){
                    url = '/booking/inquiry'+queryString;
                }
                window.location.replace(url);
            });

            $('.btn-new-booking').click(function (){
                window.location.replace('/booking/registration');
            });

            $('.btn-edit-booking').click(function (){
            	let bookingNo = $('#edit_booking_no').val();
            	//document.location.search = 'search='+bookingNo
                if (bookingNo !== '') {
                    $.ajax({
                        url: "/api/booking/code",
                        dataType: "json",
                        method: 'get',
                        data: {
                            search: bookingNo
                        },
                        success: function (result) {
                            window.location.replace('/booking/registration/' + result.data.id);
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
        function remove(elem,container_id){
            var vol = $('#container_vol_'+ container_id).val();
            var total = parseFloat($('#TotalVol').val());
            total -= parseFloat(vol);
            $('#TotalVol').val(total);
            containerId.splice(containerId.indexOf(container_id), 1);
            if (typeof $('#container_id_'+ container_id).val() !== 'undefined') {
				
            	deletedBookingContainer.push(container_id);
                $('#deletedBookingContainer').val(JSON.stringify(deletedBookingContainer));
        	}
            $(elem).parent('td').parent('tr').remove();
        }

        $('#SHBR_customer_code').change(function (){
            $.ajax({
                url: "/api/customer/code",
                dataType: "json",
                method: 'get',
                data: {
                    code: $('#SHBR_customer_code').val()
                },
                success: function (result) {
                    
                    $('#shipper_id').val(result.id);
                    $.each(result, function (key, value) {
                        $('#'+key).val(value);
                    })
                    $('#SHBR_customer_code').val(result.customer_code)
                    $('#SHBR_customer_legal_english_name').val(result.customer_legal_english_name)
                    if($('input[name="booking[booking_type]"]:checked').val() == 'EXPORT')
                    {
                    	$('#pickup_address').val(result.customer_store_address1);
                    	
                    }
                    $('#SHBR_store_address').val(result.customer_store_address1);
                }
            });
        })
        
        $('#CNEE_customer_code').change(function (){
                $.ajax({
                    url: "/api/customer/code",
                    dataType: "json",
                    method: 'get',
                    data: {
                        code: $('#CNEE_customer_code').val()
                    },
                    success: function (result) {
                        $('#consignee_id').val(result.id);
                        $.each(result, function (key, value) {
                            $('#consignee_'+key).val(value);
                        })
                        $('#CNEE_customer_code').val(result.customer_code);
                        $('#CNEE_customer_legal_english_name').val(result.customer_legal_english_name)
                        if($('input[name="booking[booking_type]"]:checked').val() == 'IMPORT')
                        {
                        	$('#delivery_address').val(result.customer_store_address1);
                        	
                        }
                        $('#CNEE_store_address').val(result.customer_store_address1);
                    }
                });
            })
            
            $('#FWDR_customer_code').change(function (){
                $.ajax({
                    url: "/api/customer/code",
                    dataType: "json",
                    method: 'get',
                    data: {
                        code: $('#FWDR_customer_code').val()
                    },
                    success: function (result) {
                        $('#forwarder_id').val(result.id);
                        $('#forwarder_customer_address').val(result.customer_address);
                        $('#FWDR_customer_code').val(result.customer_code)
                        $('#FWDR_customer_legal_english_name').val(result.customer_legal_english_name)
                    }
                });
            })

            $('#receive_take_con_place').change(function (){

                var pathNodeCode = "{{ route('getLocationCode')}}";
         		$.ajax({
                    url: pathNodeCode,
                    dataType: "json",
                    method: 'get',
                    data: {
                        nodeCode: $('#receive_take_con_place').val()
                    },
                    success: function (result) {
                        $('#pick_up_cy').val(result.address);
                    }
                });
            })
    </script>
    
    <script type="text/javascript">

        var driver_code_path = "{{ route('autocompleteNodeCode') }}";
        $('input.por_booking').typeahead({
            source:  function (query, process) {
            return $.get(driver_code_path, { query: query }, function (data) {
                    return process(data);
                });
            }
        });

        $('input.pol_booking').typeahead({
            source:  function (query, process) {
            return $.get(driver_code_path, { query: query }, function (data) {
                    return process(data);
                });
            }
        });

        $('input.pod_booking').typeahead({
            source:  function (query, process) {
            return $.get(driver_code_path, { query: query }, function (data) {
                    return process(data);
                });
            }
        });

        $('input.del_booking').typeahead({
            source:  function (query, process) {
            return $.get(driver_code_path, { query: query }, function (data) {
                    return process(data);
                });
            }
        });

        $('input.receive_take_con_place').typeahead({
        source:  function (query, process) {
        return $.get(driver_code_path, { query: query }, function (data) {
                return process(data);
            });
        }
    });

        $('.por_booking').on('change', function() {
            por = $('#por_1').val(); 
            por1 = por.substr(0,5);
            por2 = por.substr(5,2);
            
            $('#por_1').val(por1.toUpperCase());
            $('#por_2').val(por2.toUpperCase());
        });

        $('.pol_booking').on('change', function() {
        	pol = $('#pol_1').val(); 
        	pol1 = pol.substr(0,5);
        	pol2 = pol.substr(5,2);
            $('#pol_1').val(pol1.toUpperCase());
            $('#pol_2').val(pol2.toUpperCase());

            var pathNodeCode = "{{ route('getLocationCode')}}";
            $.ajax({
                url: pathNodeCode,
                dataType: "json",
                method: 'get',
                data: {
                    nodeCode: $('#pol_1').val() + $('#pol_2').val()
                },
                success: function (result) {
                    // if IMPORT, get pickup_address
                    if($('input[name="booking[booking_type]"]:checked').val() == 'EXPORT')
                    {
                        $('#delivery_address').val(result.address);
                    }
                    if (typeof result.address != 'undefined'){
                        $('#pol_address').val(result.address);
                    }
                   
                }
            });


        });

        $('.pod_booking').on('change', function() {
        	pod = $('#pod_1').val(); 
        	pod1 = pod.substr(0,5);
        	pod2 = pod.substr(5,2);
            $('#pod_1').val(pod1);
            $('#pod_2').val(pod2);
            
        });

        $('.del_booking').on('change', function() {
        	del = $('#del_1').val(); 
        	del1 = del.substr(0,5);
        	del2 = del.substr(5,2);
            $('#del_1').val(del1);
            $('#del_2').val(del2);
            
            var pathNodeCode = "{{ route('getLocationCode')}}";
            $.ajax({
                url: pathNodeCode,
                dataType: "json",
                method: 'get',
                data: {
                    nodeCode: $('#del_1').val() + $('#del_2').val()
                },
                success: function (result) {
                    // if IMPORT, get pickup_address
                    if($('input[name="booking[booking_type]"]:checked').val() == 'IMPORT')
                    {
                        $('#pickup_address').val(result.address);
                    }
                    if (typeof result.address != 'undefined'){
                        $('#del_address').val(result.address);
                    } 
                }
            });
         	
        });

        $('input:radio[name="booking[booking_type]"]').change(function() {
            if ($(this).val() == 'IMPORT') {
            	$('#pickup_address').val($('#del_address').val());
            	$('#delivery_address').val($('#CNEE_store_address').val());
            } else {
            	$('#pickup_address').val($('#SHBR_store_address').val());
            	$('#delivery_address').val($('#pol_address').val());
            }
        });
	</script>
	<script type="text/javascript">
    var path = "{{ route('autocompleteCustomerNo') }}";
    $('input.shipper').typeahead({
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });
    $('input.consignee').typeahead({
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });
    $('input.forwarder').typeahead({
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });

    var pathEditBooking = "{{ route('autocompleteBookingNo') }}";
    $('input.edit_booking_no').typeahead({
        source:  function (query, process) {
        return $.get(pathEditBooking, { query: query }, function (data) {
                return process(data);
            });
        }
    });

    $('.print').click( function(){
        let booking_id = {{ isset($booking)?$booking->id : "no_bboking"}} ;
	    window.document.location = "/print_document/booking/" + booking_id;
    });

    $('.btn-search-location').click(function(e){
        let keyword = $('#location-keyword-search').val();
        searchLocation(keyword);
     })

    $('.btnSearchPOR').click(function(e){
        let keyword = $('#location-keyword-search').val();
        $('#searchLocationFrom').val("btnSearchPOR");
        searchLocation(keyword);
        $("#searchLocationModal").modal('show');
     })

     $('.btnSearchPOL').click(function(e){
        let keyword = $('#location-keyword-search').val();
        $('#searchLocationFrom').val("btnSearchPOL");
        searchLocation(keyword);
        $("#searchLocationModal").modal('show');
     })

     $('.btnSearchPOD').click(function(e){
        let keyword = $('#location-keyword-search').val();
        $('#searchLocationFrom').val("btnSearchPOD");
        searchLocation(keyword);
        $("#searchLocationModal").modal('show');
     })

     $('.btnSearchDEL').click(function(e){
        let keyword = $('#location-keyword-search').val();
        $('#searchLocationFrom').val("btnSearchDEL");
        searchLocation(keyword);
        $("#searchLocationModal").modal('show');
     })

     $('.btnSearchCONPLACE').click(function(e){
        let keyword = $('#location-keyword-search').val();
        $('#searchLocationFrom').val("btnSearchCONPLACE");
        //searchLocation(keyword);
        $("#searchLocationModal").modal('show');
     })

     function searchLocation(keyword){
        var pathNodeCode = "{{ route('searchLocationByKeyword')}}";
        var searchLocationFrom = $('#searchLocationFrom').val();
        $.ajax({
            url: pathNodeCode,
            dataType: "json",
            method: 'get',
            data: {
                keyword: keyword
            },
            success: function (results) {
                let resultsDiv = document.getElementById("locationResults");
                let content = '<table class="table table-container-list table-bordered table-striped table-inverse table-hover table-responsive" style="margin-top: 10px">';
                content += '<thead>';
                content += ' <tr style ="background-color:#020267; color:white">';
                content += '    <th>Mã vị trí</th>';
                content += '    <th>Vị trí</th>';
                content += '    <th>Địa chỉ vị trí</th>';
                content += ' </tr>';
                content += '</thead>';
                content += '<tbody>';
                
                results.forEach(function(result){
                    content += ' <tr id=location_' + result.id;
                    content += '" ondblclick="setLocation';
                    content += '(\'' + result.id + '\'';
                    content += ',' + '\'' + result.node_code + '\'';
                    content += ',' + '\'' + result.node_name + '\'';
                    content += ',' + '\'' + result.address + '\'';
                    content += ');">'; 
                    content += "<td>" + result.node_code + "</td>";
                    content += "<td>" + result.node_name + "</td>";
                    content += "<td>" + result.address + "</td>";
                });
                content += '</tbody>';
                content += "</table>";
                resultsDiv.innerHTML = content;
            }
        });
     }

     function setLocation(locationId, nodeCode, nodeName, address){
        var searchLocationFrom = $('#searchLocationFrom').val();
        switch(searchLocationFrom) {
            case 'btnSearchPOR':
                let por = nodeCode; 
                let por1 = por.substr(0,5);
                let por2 = por.substr(5,2);
            
                $('#por_1').val(por1.toUpperCase());
                $('#por_2').val(por2.toUpperCase());
                break;
            case 'btnSearchPOL':
                // code block
                let pol = nodeCode; 
                let pol1 = pol.substr(0,5);
                let pol2 = pol.substr(5,2);
                $('#pol_1').val(pol1.toUpperCase());
                $('#pol_2').val(pol2.toUpperCase());
                // if IMPORT, get pickup_address
                if($('input[name="booking[booking_type]"]:checked').val() == 'EXPORT')
                {
                    $('#delivery_address').val(address);
                }
                if (typeof address != 'undefined'){
                    $('#pol_address').val(address);
                }
                break;
            case 'btnSearchPOD':
                let pod = nodeCode; 
                let pod1 = pod.substr(0,5);
                let pod2 = pod.substr(5,2);
                $('#pod_1').val(pod1);
                $('#pod_2').val(pod2);
                break;
            case 'btnSearchDEL':
                let del = nodeCode; 
                let del1 = del.substr(0,5);
                let del2 = del.substr(5,2);
                $('#del_1').val(del1);
                $('#del_2').val(del2);
                // if IMPORT, get pickup_address
                if($('input[name="booking[booking_type]"]:checked').val() == 'IMPORT')
                {
                    $('#pickup_address').val(address);
                }
                if (typeof address != 'undefined'){
                    $('#del_address').val(address);
                } 
                break;
            case 'btnSearchCONPLACE':
                $('#pick_up_cy').val(address);
                break;
            default:
                // code block
        }
        $("#searchLocationModal").modal('toggle');
     }
    
     $('.btn-search-customer').click(function(e){
        let keyword = $('#customer-keyword-search').val();
        searchCustomer(keyword);
     })

     function searchCustomer(keyword){
        var pathNodeCode = "{{ route('searchCustomerByKeyword')}}";
        var searchCustomerFrom = $('#searchCustomerFrom').val();
        $.ajax({
            url: pathNodeCode,
            dataType: "json",
            method: 'get',
            data: {
                keyword: keyword
            },
            success: function (results) {
                let resultsDiv = document.getElementById("customerResults");
                let content = '<table class="table table-container-list table-bordered table-striped table-inverse table-hover table-responsive" style="margin-top: 10px">';
                content += '<thead>';
                content += ' <tr style ="background-color:#020267; color:white">';
                content += '    <th>Mã khách hàng</th>';
                content += '    <th>Tên khách hàng</th>';
                content += '    <th>Địa chỉ</th>';
                content += '    <th>Địa chỉ kho</th>';
                content += ' </tr>';
                content += '</thead>';
                content += '<tbody>';
                
                results.forEach(function(result){
                    content += ' <tr id=customer_' + result.id;
                    content += '" ondblclick="setCustomer';
                    content += '(\'' + result.id + '\'';
                    content += ',' + '\'' + result.customer_code + '\'';
                    content += ',' + '\'' + result.customer_legal_english_name + '\'';
                    content += ',' + '\'' + result.customer_code + '\'';
                    content += ',' + '\'' + result.customer_store_address1 + '\'';
                    content += ');">'; 
                    content += "<td>" + result.customer_code + "</td>";
                    content += "<td>" + result.customer_legal_english_name + "</td>";
                    content += "<td>" + result.customer_address + "</td>";
                    content += "<td>" + result.customer_store_address1 + "</td>";
                });
                content += '</tbody>';
                content += "</table>";
                resultsDiv.innerHTML = content;
            }
        });
     }

     $('.btnSearchSHBR').click(function(e){
        let keyword = $('#customer-keyword-search').val();
        $('#searchCustomerFrom').val("btnSearchSHBR");
        searchCustomer(keyword);
        $("#searchCustomerModal").modal('show');
     })

     $('.btnSearchFWDR').click(function(e){
        let keyword = $('#customer-keyword-search').val();
        $('#searchCustomerFrom').val("btnSearchFWDR");
        searchCustomer(keyword);
        $("#searchCustomerModal").modal('show');
     })

     $('.btnSearchCNEE').click(function(e){
        let keyword = $('#customer-keyword-search').val();
        $('#searchCustomerFrom').val("btnSearchCNEE");
        searchCustomer(keyword);
        $("#searchCustomerModal").modal('show');
     })
     
     function setCustomer(customerId, customer_code, customer_legal_english_name, customer_address, customer_store_address1){
        var searchCustomerFrom = $('#searchCustomerFrom').val();
        switch(searchCustomerFrom) {
            case 'btnSearchSHBR':
                $('#SHBR_customer_code').val(customer_code);
                $('#SHBR_customer_code').change();
                break;
            case 'btnSearchFWDR':
                // code block
                $('#FWDR_customer_code').val(customer_code);
                $('#FWDR_customer_code').change();
                break;
            case 'btnSearchCNEE':
                $('#CNEE_customer_code').val(customer_code);
                $('#CNEE_customer_code').change();
                break;
            default:
                // code block
        }
        $("#searchCustomerModal").modal('toggle');
     }
    </script>
@endsection
