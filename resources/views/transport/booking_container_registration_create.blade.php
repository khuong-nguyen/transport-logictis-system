@extends('layout.app')
@section('title', 'Booking Registration')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">@lang('sidebar.container_booking_registration')</div>
                <div class="card-body">

                        @include('transport.content_create')

                </div>
            </div>
        </div>
    </div>
@endsection
