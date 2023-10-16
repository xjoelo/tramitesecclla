@extends('layout.main')

@section('headerButtons')
	@include('layout.headerButtonSmall')
@endsection

@section('content')
<div class="row">
    <div class="col-12" >
        <sf-derivados
        	:user="{{auth()->user()->load('dependencia')}}"
        	name-entity="{{ config('app.siglas_entity') }}"
        >
        </sf-derivados>
    </div>
</div>
@endsection

