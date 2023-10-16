@extends('layout.main')

@section('headerButtons')
	@include('layout.headerButtonSmall')
@endsection

@section('content')

<div class="row">
    <div class="col-12" >
        <sf-en-proceso
        	:user="{{auth()->user()->load('dependencia')}}"
        	name-entity="{{ config('app.siglas_entity') }}"
        >
        		
        </sf-en-proceso>
    </div>
</div>
@endsection

