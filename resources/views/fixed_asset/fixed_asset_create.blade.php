@extends('layout.app')
@section('title', 'Fixed Asset Registration')
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
                <div class="card-header">@lang('fixed_asset.fixed_asset_registration')</div>
                <div class="card-body container-fluid">
                    @if (session('status'))
                        <div class="alert alert-success">@lang(session('status'))</div>
                    @endif
                    <form action="/fixed_asset/registration{{ isset($fixed_asset) ? '/'.$fixed_asset->id :''}}" method="post">
                        @csrf
                        @if(isset($fixed_asset))  @method('PUT') @endif
                        <div class="row">
                            <div class="col ">
                                <div class="nav-tabs-boxed form-group">
                                    <ul class="nav nav-tabs" role="tablist" >
                                        <li class="nav-item"><a class="nav-link active" id="fixed_asset_tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="profile">Fixed Asset Creation</a></li>
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
                                                                        <label class="col-form-label required" for="fixed_asset_name">Fixed Asset Name</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control @if($errors->has('fixed_asset.fixed_asset_name')) is-invalid @endif" id="fixed_asset_name" value="{{old('fixed_asset.fixed_asset_name') ?? $fixed_asset->fixed_asset_name ?? ''}}" type="text" name="fixed_asset[fixed_asset_name]" required>
                                                                        @error('fixed_asset.fixed_asset_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="fixed_asset_code">Fixed Asset Code</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="fixed_asset_code" value="{{old('fixed_asset.fixed_asset_code') ?? $fixed_asset->fixed_asset_code ?? ''}}" type="text" name="fixed_asset[fixed_asset_code]">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="manuafacture">Manuafacture</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="manuafacture" value="{{old('fixed_asset.manuafacture') ?? $fixed_asset->manuafacture ?? ''}}" type="text" name="fixed_asset[manuafacture]">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="fixed_asset_type">Fixed Asset Type</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        {{ Form::select('fixed_asset[fixed_asset_type]', $fixedAssetTypeOptions,(empty($fixed_asset->fixed_asset_type) ? $fixedAssetTypeOptionDefault : $selectedFixedAssetTypeOption), ['class'=>'form-control']) }}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <label class="col-form-label" for="desc">Description</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" id="desc" value="{{old('fixed_asset.desc') ?? $fixed_asset->desc ?? ''}}" type="text" name="fixed_asset[desc]">
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