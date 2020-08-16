@extends('layout.app')
@section('title', 'Booking Registration')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">@lang('sidebar.container_booking_registration')</div>
                <div class="card-body">
                    <form id="form-transport-container" action="/booking/transport/registration{{ isset($bookingContainerDetails['id']) ? '/'.$bookingContainerDetails['id'] :''}}" method="post">
                        @csrf
                        @if(isset($bookingContainerDetails))  @method('PUT') @endif
                        @include('transport.content_create')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
