<form action="/booking/registration{{ isset($booking) ? '/'.$booking->id :''}}" method="post">
    @csrf
    @if(isset($booking))  @method('PUT') @endif
    <div class="row">
        <div class="col">
            <div class="form-group row">
                <div class="col-md-1 col-sm-2">
                    <label class="col-form-label required" for="booking_no">Booking No:</label>
                </div>
                <div class="col-md-2 col-sm-3">
                    <input class="form-control @if($errors->has('booking.booking_no')) is-invalid @endif" id="booking_no" type="text"
                           value="{{ old('booking.booking_no') ?? $booking->booking_no ?? '' }}" required>
                    @error('booking.booking_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary btn-search-booking" disabled>Search</button>
                </div>
                <div class="col-md-3">
                    <input class="form-control" id="virtual_booking_no" type="text" name="virtual_booking_no">
                </div>
            </div>
            <div class="nav-tabs-boxed form-group">
                <ul class="nav nav-tabs" role="tablist" >
                    <li class="nav-item"><a class="nav-link active" id="bkg_tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home">BKG Creation Tab</a></li>
                    <li class="nav-item"><a class="nav-link" id="cust_tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="profile">Customer Tab</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="bkg_tab">
                        <div class="form-row">
                            <div class="row col-md-12">
                                <div class="form-group col-md-8">
                                    <div class="form-group row">
                                        <div class="col-md-2">
                                            <label class="col-form-label required" for="booking_no">BKG No</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control @if($errors->has('booking.booking_no')) is-invalid @endif" name="booking[booking_no]" id="booking_no" type="text"
                                                   value="{{ old('booking.booking_no') ?? $booking->booking_no ?? '' }}" required>
                                            @error('booking.booking_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label required"  for="virtual_booking_no">Virtual BKG No</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control" id="virtual_booking_no" type="text" name="virtual_booking_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2">
                                            <label class="col-form-label required" for="tvvd">T/VVD:</label>
                                        </div>

                                        <div class="col-md-3">
                                            <input class="form-control @if($errors->has('booking.tvvd')) is-invalid @endif" id="tvvd" type="text" name="booking[tvvd]" required value="{{ old('booking.tvvd') ?? $booking->tvvd ?? '' }}">
                                            @error('booking.tvvd')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2">
                                            <label class="col-form-label required" for="por_1">POR</label>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <input class="form-control @if($errors->has('booking.por_1')) is-invalid @endif" id="por_1" type="text" name="booking[por_1]" value="{{ old('booking.por_1') ?? $booking->por_1 ?? '' }}">
                                            @error('booking.por_1')<div class="invalid-feedback" style="position: relative; width: 400%">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <input class="form-control @if($errors->has('booking.por_2')) is-invalid @endif" id="por_2" type="text" name="booking[por_2]" value="{{ old('booking.por_2') ?? $booking->por_2 ?? '' }}">
                                            @error('booking.por_2')<div class="invalid-feedback " style="position: relative; width: 400%">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-1"></div>
                                        <!-- <div class="col-md-2 "> -->
                                        <label class="col-form-label required" for="pol_1">POL</label>
                                        <!--</div>-->
                                        <div class="col-md-2 form-group">
                                            <input class="form-control  @if($errors->has('booking.pol_1')) is-invalid @endif" id="pol_1" type="text" name="booking[pol_1]" value="{{ old('booking.por_1') ?? $booking->pol_1 ?? '' }}">
                                            @error('booking.pol_1')<div class="invalid-feedback" style="position: relative; width: 400%">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <input class="form-control" id="pol_2" type="text" name="booking[pol_2]" value="{{ old('booking.pol_2') ?? $booking->pol_2 ?? '' }}">
                                        </div>


                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-2">
                                            <label class="col-form-label required" for="pod_1">POD</label>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <input class="form-control @if($errors->has('booking.pod_1')) is-invalid @endif" id="pod_1" type="text" name="booking[pod_1]" value="{{ old('booking.pod_1') ?? $booking->pod_1 ?? '' }}">
                                            @error('booking.pod_1')<div class="invalid-feedback" style="position: relative; width: 400%">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <input class="form-control" id="pod_2" type="text" name="booking[pod_2]" value="{{ old('booking.pod_2') ?? $booking->pod_2 ?? '' }}">
                                        </div>
                                        <div class="col-md-1">

                                        </div>
                                        <!-- <div class="col-md-2 "> -->
                                        <label class="col-form-label required" for="del_1">DEL</label>
                                        <!--</div> -->
                                        <div class="col-md-2 form-group">
                                            <input class="form-control @if($errors->has('booking.del_1')) is-invalid @endif" id="del_1" type="text" name="booking[del_1]" value="{{ old('booking.del_1') ?? $booking->del_1 ?? '' }}">
                                            @error('booking.del_1')<div class="invalid-feedback" style="position: relative; width: 400%">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <input class="form-control" id="del_2" type="text" name="booking[del_2]" value="{{ old('booking.del_2') ?? $booking->del_2 ?? '' }}">
                                        </div>


                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2">
                                            <label class="col-form-label required" for="text-input">R/D Term</label>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <input class="form-control @if($errors->has('booking.r_d_term_1')) is-invalid @endif" id="r_d_term_1" type="text" name="booking[r_d_term_1]" value="{{ old('booking.r_d_term_1') ?? $booking->r_d_term_1 ?? '' }}">
                                            @error('booking.r_d_term_1')<div class="invalid-feedback" style="position: relative; width: 400%">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <input class="form-control" id="r_d_term_2" type="text" name="booking[r_d_term_2]" value="{{ old('booking.r_d_term_2') ?? $booking->r_d_term_2 ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label required" for="b_l_no">B/L No</label>
                                        </div>

                                        <div class="col-md-5 form-group">
                                            <input class="form-control @if($errors->has('booking.b_l_no')) is-invalid @endif" id="b_l_no" type="text" name="booking[b_l_no]"
                                                   value="{{old('booking.b_l_no') ?? $booking->b_l_no ?? ''}}"
                                            >
                                            @error('booking.b_l_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="custom-control custom-checkbox col-md-2">
                                            <input class="custom-control-input" id="si" type="checkbox" value="0" name="booking[si]" >
                                            <label class="custom-control-label" for="si">SI</label>
                                        </div>

                                        <div class="custom-control custom-checkbox col-md-2">
                                            <input class="custom-control-input" id="brd" type="checkbox" value="0" name="booking[brd]">
                                            <label class="custom-control-label" for="brd">BRD</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label">SHBR</label>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <input class="form-control" type="text" name="SHBR[country]" disabled >
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <input class="form-control" type="text" name="SHBR[code]" disabled >
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <input class="form-control" type="text" name="SHBR[full]" disabled >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label" >FWDR</label>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <input class="form-control" type="text" name="FWDR[country]" disabled>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <input class="form-control" type="text" name="FWDR[code]" disabled>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <input class="form-control" type="text" name="FWDR[full]" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label" >CNEE</label>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <input class="form-control" type="text" name="CNEE[country]" disabled>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <input class="form-control" type="text" name="CNEE[code]" disabled>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <input class="form-control" type="text" name="CNEE[full]" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">  <label class="col-form-label required" for="cmdt_1">CMDT</label></div>
                                        <div class="col-md-4 form-group">
                                            <input class="form-control @if($errors->has('booking.booking_no')) is-invalid @endif" id="cmdt_1" type="text" name="booking[cmdt_1]" value="{{old('booking.cmdt_1') ?? $booking->cmdt_1 ?? ''}} " >
                                            @error('booking.booking_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <input class="form-control" id="cmdt_2" type="text" name="booking[cmdt_2]" value="{{old('booking.cmdt_2') ?? $booking->cmdt_2 ?? ''}}" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="row col-md-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label class="col-md-12 col-form-label" for="TotalVol">Total Vol</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input class="form-control" id="TotalVol" type="text" value="0" name="TotalVol" disabled >
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div>
                            <div class="form-group row col-md-12 ">
                                <div class="col-md-5">
                                    <table class="table table-responsive-sm table-bordered" id="container_table">
                                        <thead>
                                        <tr>
                                            <th>TP/SZ</th>
                                            <th>Vol</th>
                                            <th>EQ Sub(Incl. R/D</th>
                                            <th>S.O.C</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control select2" id="select1" style="width: 100%;" name="select1"></select>
                                            </td>
                                            <td><input type="text" class="form-control" id="container_vol"></td>
                                            <td><input type="text" class="form-control" id="container_eq_sub"></td>
                                            <td><input type="text" class="form-control" id="container_soc"></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" id="add_container" type="button">Add</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="form-group row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4 form-group">
                                            <div class="custom-control custom-checkbox col-md-2">
                                                <input class="custom-control-input" id="fh" type="checkbox" value="0" name="booking[fh]">
                                                <label class="custom-control-label" for="fh">Fh</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group row">
                                        <div class="col-md-2">
                                            <label class="col-form-label required form-group" for="weight">Weight</label>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <input class="form-control @if($errors->has('booking.weight')) is-invalid @endif" id="weight" type="text" name="booking[weight]" value="{{old('booking.weight') ?? $booking->weight ?? ''}}">
                                            @error('booking.weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <input class="form-control @if($errors->has('booking.unit')) is-invalid @endif" type="number" name="booking[unit]" min="0" value="{{old('booking.unit') ?? $booking->unit ?? ''}}">
                                            @error('booking.unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-2 ">
                                            <label class="col-form-label required" for="lofc_1">L.OFC/Rep.:</label>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <input class="form-control @if($errors->has('booking.lofc_1')) is-invalid @endif" id="lofc_1" type="text" name="booking[lofc_1]" value="{{old('booking.lofc_1') ?? $booking->lofc_1 ?? ''}}">
                                            @error('booking.lofc_1')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <input class="form-control" type="text" name="booking[lofc_2]"  value="{{old('booking.lofc_2') ?? $booking->lofc_2 ?? ''}}">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="row col-md-12">
                                <div class="col-md-3 border">
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label" for="text-input">Planned Delvery Schedule</label>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-6 col-form-label required" for="sailling_due_date">Sailling Due Date</label>
                                        <div class="col-md-6 input-group date">
                                            <input class="form-control @if($errors->has('booking.sailling_due_date')) is-invalid @endif " id="sailling_due_date" required type="text" name="booking[sailling_due_date]">
                                            @error('booking.sailling_due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 border">
                                    <div class="form-group row">
                                        <label class=" col-md-12 col-form-label" for="text-input">Empty CNTR P/Up & RTN CY</label>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-6 col-form-label" for="pick_up_cy">M'Ty Pick up CY </label>
                                        <div class="col-md-6">
                                            <input class="form-control " id="pick_up_cy" type="text" name="booking[pick_up_cy]" value="{{old('booking.pick_up_cy') ?? $booking->pick_up_cy ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-6 col-form-label @if($errors->has('booking.sailling_due_date')) is-invalid @endif" for="pick_up_dt">M'Ty Pick up DT </label>
                                        <div class="col-md-6">
                                            <input class="form-control" id="pick_up_dt" type="text" name="booking[pick_up_dt]">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-6 col-form-label" for="full_return_cy">Full Return CY</label>
                                        <div class="col-md-6">
                                            <input class="form-control" id="full_return_cy" type="text" name="booking[full_return_cy]" value="{{old('booking.pick_up_cy') ?? $booking->pick_up_cy ?? ''}}">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label" for="text-input">BKG Contact</label>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-6 col-form-label" for="bkg_contact_name">Contact Name</label>
                                        <div class="col-md-6">
                                            <input class="form-control" id="bkg_contact_name" type="text" name="booking['bkg_contact_name']" value="{{old('booking.bkg_contact_name') ?? $booking->bkg_contact_name ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-6 col-form-label" for="bkg_contact_email">E-mail </label>
                                        <div class="col-md-6">
                                            <input class="form-control" id="bkg_contact_email" type="text" name="booking[bkg_contact_email]" value="{{old('booking.bkg_contact_email') ?? $booking->bkg_contact_email ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-6 col-form-label" for="bkg_contact_tel">Tel.</label>
                                        <div class="col-md-6">
                                            <input class="form-control" id="bkg_contact_tel" type="text" name="booking[bkg_contact_tel]" value="{{old('booking.bkg_contact_tel') ?? $booking->bkg_contact_tel ?? ''}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-md-6 col-form-label" for="BOFC">B.OFC</label>
                                        <div class="col-md-6">
                                            <input class="form-control" id="BOFC" type="text" disabled name="BOFC">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-6 col-form-label" for="BStaff">B.Staff</label>
                                        <div class="col-md-6">
                                            <input class="form-control" id="BStaff" type="text" name="BStaff" disabled>
                                        </div>
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
                                        <textarea class="form-control" id="ext_remark" name="booking[ext_remark]" rows="9" placeholder="Content..">{{old('booking.ext_remark') ?? $booking->ext_remark ?? ''}}</textarea>                                                            </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="int_remark"> Int Remark</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="int_remark" name="booking[int_remark]" rows="9" placeholder="Content..">{{old('booking.int_remark') ?? $booking->int_remark ?? ''}}</textarea>                                                            </div>
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
                                                    <input type="hidden" value="" id="shipper_id" name="booking[shipper_id]">
                                                    <label class="col-form-label" for="shiper_country">Shiper</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control" id="shiper_country" type="text" name="shiper_country">
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control" id="shiper_code" type="text" name="shiper_code">
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="button" class="btn btn-primary" id="shiper_search">Search</button>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label class="col-form-label" for="customer_legal_english_name">Name</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input class="form-control" id="customer_legal_english_name" type="text" name="shiper[customer_legal_english_name]" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label class="col-form-label" for="customer_address">Address</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input class="form-control" id="customer_address" type="text" name="shiper[customer_address]" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label class="col-form-label" for="city">City/Stage</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input class="form-control" id="city" type="text" name="shiper[city]" disabled>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control" id="location_code" type="text" name="shiper[location_code]" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label class="col-form-label" for="country_code">Country</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control" id="country_code" type="text" name="shiper[country_code]" disabled>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="col-form-label" for="zip_code">Zip Code</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control" id="zip_code" type="text" name="shiper[zip_code]" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label class="col-form-label" for="text-input">Street/P.O  Box</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input class="form-control" id="text-input" type="text" name="text-input" disabled>
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
                                                    <input class="form-control" id="fax" type="text" name="shiper[fax]" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label class="col-form-label" for="text-input">Email</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input class="form-control" id="text-input" type="text" name="text-input" disabled>
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
                                                    <input class="form-control" id="tel" type="text" name="shiper[tel]" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body border my-1">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <input type="hidden" value="" name="booking[consignee_id]" id="consignee_id">
                                                    <label class="col-form-label" for="text-input">Consignee</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control" id="consignee_country" type="text" name="consignee_country">
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control" id="consignee_code" type="text" name="consignee_code">
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="button" class="btn btn-primary" id="consignee_search">Search</button>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label class="col-form-label" for="consignee_name">Name</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input class="form-control" id="consignee_customer_legal_english_name" type="text" name="consignee[customer_legal_english_name]" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="col-form-label" for="consignee_customer_address">Address</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input class="form-control" id="consignee_customer_address" type="text" name="consignee[customer_address]" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="col-form-label" for="consignee_city">City/Stage</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input class="form-control" id="consignee_city" type="text" name="consignee[city]" disabled>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control" id="consignee_location_code" type="text" name="consignee[location_code]" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="col-form-label" for="consignee_country_code">Country</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control" id="consignee_country_code" type="text" name="consignee[country_code]" disabled>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="col-form-label" for="consignee_zip_code">Zip Code</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control" id="consignee_zip_code" type="text" name="consignee[zip_code]" disabled>
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
                                                    <input class="form-control" id="consignee_street" type="text" name="consignee[street]" disabled>
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
                                                    <input class="form-control" id="consignee_fax" type="text" name="consignee[fax]" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="col-form-label" for="text-input">Email</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input class="form-control" id="text-input" type="text" name="text-input" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class=col-form-label" for="consignee_tel">Tel</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input class="form-control" id="consignee_tel" type="text" name="consignee[tel]" disabled>
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
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="forwarder_country">Forwarder</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-row row">
                                                <div class="col-sm-4">
                                                    <input class="form-control" id="forwarder_country" type="text" name="forwarder[country]">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input class="form-control" id="forwarder_code" type="text" name="forwarder[code]">
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-primary" id="forwarder_search">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="text-input">Name & address</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form-row float-right">
                        <div class="form-group  float-right">
                            <div class="btn-group">
                                <button class="btn btn-primary" type="button">BKG Cancel</button>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-primary" type="button">Split</button>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-primary" type="button">Fax/EDI</button>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-primary" type="button">Copy</button>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-primary" type="submit"> Save</button>
                            </div>
                            <div class="btn-group">
                                <a class="btn btn-primary" href="/" role="button">Close</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
