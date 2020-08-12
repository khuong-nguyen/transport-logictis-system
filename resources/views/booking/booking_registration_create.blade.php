@extends('layout.app')
@section('title', 'Booking Registration')
@section('content')
    <style type="text/css">
        .required:after{
            content:"*";
            color:red;
        }
    </style>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">@lang('sidebar.booking_registration')</div>

                <div class="card-body">
                    <form action="/booking/registration{{ $booking ?? ''}}" method="post">
                        @csrf
                        @if(isset($booking))
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col">
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
                                                                <input class="form-control" name="booking[booking_no]" id="booking_no" type="text">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="col-form-label required" for="virtual_booking_no">Virtual BKG No</label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input class="form-control" id="virtual_booking_no" type="text" name="virtual_booking_no">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-2">
                                                                <label class="col-form-label" for="tvvd">T/VVD:</label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <input class="form-control" id="tvvd" type="text" name="booking[tvvd]">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-2">
                                                                <label class="col-form-label" for="por_1">POR</label>
                                                            </div>
                                                            <div class="col-md-1 form-group">
                                                                <input class="form-control" id="por_1" type="text" name="booking[por_1]">
                                                            </div>
                                                            <div class="col-md-1 form-group">
                                                                <input class="form-control" id="por_2" type="text" name="booking[por_2]">
                                                            </div>
                                                            <div class="col-md-2 ">
                                                                <label class="col-form-label" for="pol_1">POL</label>
                                                            </div>
                                                            <div class="col-md-1 form-group">
                                                                <input class="form-control" id="pol_1" type="text" name="booking[pol_1]">
                                                            </div>
                                                            <div class="col-md-1 form-group">
                                                                <input class="form-control" id="pol_2" type="text" name="booking[pol_2]">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="col-form-label" for="text-input">R/D Term</label>
                                                            </div>

                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-2">
                                                                <label class="col-form-label" for="pod_1">POD</label>
                                                            </div>
                                                            <div class="col-md-1 form-group">
                                                                <input class="form-control" id="pod_1" type="text" name="booking[pod_1]">
                                                            </div>
                                                            <div class="col-md-1 form-group">
                                                                <input class="form-control" id="pod_2" type="text" name="booking[pod_2]">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="col-form-label" for="del_1">DEL</label>
                                                            </div>
                                                            <div class="col-md-1 form-group">
                                                                <input class="form-control" id="del_1" type="text" name="booking[del_1]">
                                                            </div>
                                                            <div class="col-md-1 form-group">
                                                                <input class="form-control" id="del_2" type="text" name="booking[del_2]">
                                                            </div>
                                                            <div class="col-md-2 form-group">
                                                                <input class="form-control" id="r_d_term_1" type="text" name="booking[r_d_term_1]">
                                                            </div>
                                                            <div class="col-md-2 form-group">
                                                                <input class="form-control" id="r_d_term_2" type="text" name="booking[r_d_term_2]">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <div class="form-group row">
                                                            <div class="col-md-3">
                                                                <label class="col-form-label required" for="b_l_no">B/L No</label>
                                                            </div>

                                                            <div class="col-md-5 form-group">
                                                                <input class="form-control" id="b_l_no" type="text" name="booking[b_l_no]">
                                                            </div>

                                                            <div class="custom-control custom-checkbox col-md-2">
                                                                <input class="custom-control-input" id="si" type="checkbox" value="0" name="booking[si]">
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
                                                                <input class="form-control" type="text" name="SHBR[country]" disabled>
                                                            </div>

                                                            <div class="col-md-3 form-group">
                                                                <input class="form-control" type="text" name="SHBR[code]" disabled>
                                                            </div>

                                                            <div class="col-md-3 form-group">
                                                                <input class="form-control" type="text" name="SHBR[full]" disabled>
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
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-3">
                                                        <div class="row">
                                                            <div class="col-md-4">  <label class="col-form-label" for="cmdt_1">CMDT</label></div>
                                                            <div class="col-md-4 form-group"><input class="form-control" id="cmdt_1" type="text" name="booking[cmdt_1]"></div>
                                                            <div class="col-md-4 form-group"><input class="form-control" id="cmdt_2" type="text" name="booking[cmdt_2]"></div>
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
                                                            <input class="form-control" id="TotalVol" type="text" name="TotalVol" disabled>
                                                        </div>
                                                        <div class="col-md-2"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row col-md-12 ">
                                                        <div class="col-md-5">
                                                            <table class="table table-responsive-sm table-bordered">
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
                                                                    <td>D2</td>
                                                                    <td>30.00</td>
                                                                    <td>0.00</td>
                                                                    <td>0.00</td>
                                                                    <td>Del</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>D2</td>
                                                                    <td>30.00</td>
                                                                    <td>0.00</td>
                                                                    <td>0.00</td>
                                                                    <td>Del</td>
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
                                                                <div class="col-md-4 form-group">
                                                                    <button class="btn btn-block btn-primary" type="button">Add row</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="form-group row">
                                                                <div class="col-md-2">
                                                                    <label class="col-form-label" for="weight">Weight</label>
                                                                </div>
                                                                <div class="col-md-2 form-group">
                                                                    <input class="form-control" id="weight" type="text" name="booking[weight]">
                                                                </div>
                                                                <div class="col-md-2 form-group">
                                                                    <input class="form-control" type="number" name="booking[unit]" min="0">
                                                                </div>
                                                                <div class="col-md-2 ">
                                                                    <label class="col-form-label" for="lofc_1">L.OFC/Rep.:</label>
                                                                </div>
                                                                <div class="col-md-2 form-group">
                                                                    <input class="form-control" id="lofc_1" type="text" name="booking[lofc_1]">
                                                                </div>
                                                                <div class="col-md-2 form-group">
                                                                    <input class="form-control" type="text" name="booking[lofc_2]">
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
                                                            <label class="col-md-6 col-form-label" for="sailling_due_date">Sailling Due Date</label>
                                                            <div class="col-md-6 input-group date">
                                                                <input class="form-control" id="sailling_due_date" type="text" name="booking[sailling_due_date]">
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
                                                                <input class="form-control" id="pick_up_cy" type="text" name="booking[pick_up_cy]">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-6 col-form-label" for="pick_up_dt">M'Ty Pick up DT </label>
                                                            <div class="col-md-6">
                                                                <input class="form-control" id="pick_up_dt" type="text" name="booking[pick_up_dt]">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-6 col-form-label" for="full_return_cy">Full Return CY</label>
                                                            <div class="col-md-6">
                                                                <input class="form-control" id="full_return_cy" type="text" name="booking[full_return_cy]">
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
                                                                <input class="form-control" id="bkg_contact_name" type="text" name="booking['bkg_contact_name']">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-6 col-form-label" for="bkg_contact_email">E-mail </label>
                                                            <div class="col-md-6">
                                                                <input class="form-control" id="bkg_contact_email" type="text" name="booking[bkg_contact_email]">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-6 col-form-label" for="bkg_contact_tel">Tel.</label>
                                                            <div class="col-md-6">
                                                                <input class="form-control" id="bkg_contact_tel" type="text" name="booking[bkg_contact_tel]">
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
                                                                <textarea class="form-control" id="ext_remark" name="booking[ext_remark]" rows="9" placeholder="Content.."></textarea>                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-md-2 col-form-label" for="int_remark"> Int Remark</label>
                                                            <div class="col-md-10">
                                                                <textarea class="form-control" id="int_remark" name="booking[int_remark]" rows="9" placeholder="Content.."></textarea>                                                            </div>
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
                                                                        <label class="col-form-label" for="text-input">Shiper</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <button type="button" class="btn btn-primary">Search</button>                                                                </div>
                                                                    </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">Name</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">Address</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">City/Stage</label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">Country</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">Zip Code</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
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
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">Fax</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">Email</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">Tel</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
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
                                                                        <label class="col-form-label" for="text-input">Consignee</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <button type="button" class="btn btn-primary">Search</button>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">Name</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">Address</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">City/Stage</label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">Country</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">Zip Code</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">Street/P.O  Box</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">Fax</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="text-input">Email</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class=col-form-label" for="text-input">Tel</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Text">
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
                                                                <label class="col-form-label" for="forwarder">Forwarder</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-row row">
                                                                    <div class="col-sm-4">
                                                                        <input class="form-control" id="forwarder" type="text" name="forwarder[country]">
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <input class="form-control" id="text-input" type="text" name="forwarder[code]">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button type="button" class="btn btn-primary">Search</button>
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
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $('#sailling_due_date').datetimepicker({
                viewMode: 'days',
                format: 'DD/MM/YYYY',
                date: new Date()
            });
            $('#pick_up_dt').datetimepicker({
                viewMode: 'days',
                format: 'DD/MM/YYYY',
                date: new Date()
            });
        });
    </script>
@endsection
