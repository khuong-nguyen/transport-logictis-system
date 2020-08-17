@extends('layout.app')
@section('title', 'Customer Registration')
@section('content')
    <style type="text/css">
        .required:after{
            content:"*";
            color:red;
        }
        .error-messages {
            color: red;
            font-size: 12px;
        }
        .nav-tabs .nav-item .active{
            background:#0E0EFF !important;
            color:#fff !important;
            font-weight: bold;
            border-color: #0E0EFF;
        }
        .nav-tabs-boxed .nav-tabs .nav-link {
            color: #768192
        }
    </style>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">@lang('customer.customer_registration')</div>
                <div class="card-body container-fluid">
                    @if (session('status'))
                        <div class="alert alert-success">@lang(session('status'))</div>
                    @endif
                    <form action="/customer/registration{{ isset($customer) ? '/'.$customer->id.'?'.$params :''}}" method="post">
                        @csrf
                        @if(isset($customer))  @method('PUT') @endif
                        <div class="row">
                            <div class="col ">
                                <div class="nav-tabs-boxed form-group">
                                    <ul class="nav nav-tabs" role="tablist" >
                                        <li class="nav-item"><a class="nav-link active" id="cust_tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="profile">Customer Creation</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="cust_tab">
                                            <div class="form-row row">
                                                <div class="col-md-12">
                                                    <div class="card-body border">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label required" for="customer_legal_english_name">Legal Name</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control @if($errors->has('customer.customer_legal_english_name')) is-invalid @endif" id="customer_legal_english_name" value="{{old('customer.customer_legal_english_name') ?? $customer->customer_legal_english_name ?? ''}}" type="text" name="customer[customer_legal_english_name]" required>
                                                                        @error('customer.customer_legal_english_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="customer_language_name">Language Name</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="customer_language_name" value="{{old('customer.customer_language_name') ?? $customer->customer_language_name ?? ''}}" type="text" name="customer[customer_language_name]">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="tax_code">Tax Code</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="tax_code" value="{{old('customer.tax_code') ?? $customer->tax_code ?? ''}}" type="text" name="customer[tax_code]">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="customer_address">Address</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="customer_address" value="{{old('customer.customer_address') ?? $customer->customer_address ?? ''}}" type="text" name="customer[customer_address]">
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
                                                                    <div class="col-md-3">
                                                                        {{ Form::select('customer[city]', $cityCodeOptions,(empty($customer->city) ? $cityCodeOptionDefault : $selectedCityCodeOption), ['class'=>'form-control']) }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="country_code">Country</label>
                                                                    </div>
                                                                    <div class="col-md-3 pr-0">
                                                                        {{ Form::select('customer[country_code]', $countryCodeOptions,(empty($customer->country_code) ? $countryCodeOptionDefault : $selectedCountryCodeOption), ['class'=>'form-control']) }}
                                                                    </div>
                                                                    <div class="col-md-3 pr-0">
                                                                        <label class="col-form-label" for="zip_code">Zip Code</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="zip_code" value="{{old('customer.zip_code') ?? $customer->zip_code ?? ''}}" type="text" name="customer[zip_code]">
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
                                                                        <input class="form-control" id="post_office_box" value="{{old('customer.post_office_box') ?? $customer->post_office_box ?? ''}}" type="text" name="customer[post_office_box]">
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
                                                                        <input class="form-control" id="fax" value="{{old('customer.fax') ?? $customer->fax ?? ''}}" type="text" name="customer[fax]">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="email">Email</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="email" value="{{old('customer.email') ?? $customer->email ?? ''}}" type="email" name="customer[email]">
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
                                                                        <input class="form-control" id="tel" value="{{old('customer.tel') ?? $customer->tel ?? ''}}" type="text" name="customer[tel]">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label required" for="sale_office_code">Sales Office</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control @if($errors->has('customer.sale_office_code')) is-invalid @endif" id="sale_office_code" value="{{old('customer.sale_office_code') ?? $customer->sale_office_code ?? ''}}" type="text" name="customer[sale_office_code]" required>
                                                                        @error('customer.sale_office_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label required" for="sale_rep_code">Sales Rep Office</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control @if($errors->has('customer.sale_rep_code')) is-invalid @endif" id="sale_rep_code" value="{{old('customer.sale_rep_code') ?? $customer->sale_rep_code ?? ''}}" type="text" name="customer[sale_rep_code]" required>
                                                                        @error('customer.sale_rep_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                                    </div>
                                                                </div>
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
@endsection
