@extends('layout.app')
@section('title', 'Location Registration')
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
                <div class="card-header">@lang('location_code.location_code_registration')</div>
                <div class="card-body container-fluid">
                    @if (session('status'))
                        <div class="alert alert-success">@lang(session('status'))</div>
                    @endif
                    <form action="/location_code/registration{{ isset($location_code) ? '/'.$location_code->id :''}}" method="post">
                        @csrf
                        @if(isset($location_code))  @method('PUT') @endif
                        <div class="nav-tabs-boxed form-group">
                            <ul class="nav nav-tabs" role="tablist" >
                                <li class="nav-item"><a class="nav-link active" id="employee_tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="profile">Location Creation</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="cust_tab">
                                    <div class="form-row row">
                                        <div class="col-md-12">
                                            <div class="card-body border">
                                            	<div class="form-group row">
                                                    <div class="col-md-3">
                                                        <label class="col-form-label required" for="node_code">Node Code</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control @if($errors->has('location_code.node_code')) is-invalid @endif" id="node_code" value="{{old('location_code.node_code') ?? $location_code->node_code ?? ''}}" type="text" name="location_code[node_code]" required>
                                                        @error('location_code.location_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                        <label class="col-form-label" for="node_name">Node Name</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="form-control " id="node_name" value="{{old('location_code.node_name') ?? $location_code->node_name ?? ''}}" type="text" name="location_code[node_name]">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                        <label class="col-form-label" for="address">Address</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="form-control" id="address" value="{{old('location_code.address') ?? $location_code->address ?? ''}}" type="text" name="location_code[address]">    
                                                    </div>
                                                </div>
                                    		</div>
                                		</div>
                            		</div>
	                        		<div class="card-footer">
                                        <div class="form-row float-right">
                                            <div class="form-group">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script type="text/javascript">
    	$('#sidebar').removeClass('c-sidebar-lg-show');
    </script>
    
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
@endsection