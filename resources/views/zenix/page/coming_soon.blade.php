{{-- Extends layout --}}
@extends('layout.fullwidth')

{{-- Content --}}
@section('content')
    <div class="col-md-5">
        <div class="form-input-content text-center error-page">
            <h4>Coming Soon!!!</h4>
			<div class="py-5 my-3">
                <a class="btn btn-primary" href="{!! url('/'); !!}">Back to Home</a>
            </div>	
        </div>
    </div>
@endsection