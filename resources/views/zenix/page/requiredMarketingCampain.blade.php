{{-- Extends layout --}}
@extends('layout.fullwidth')

{{-- Content --}}
@section('content')
    <div class="col-md-8">
        <div class="form-input-content text-center error-page">
            <h4>Please wait...</h4>
            <p>You are not assigned to any marketing campaign yet. Once admin assigns you to one of them, you will be able to use the platform.!!!</p>
            <div class="py-5 my-3">
                <a class="btn btn-primary" href="{!! url('/'); !!}">Back to Home</a>
            </div>	
        </div>
    </div>
@endsection