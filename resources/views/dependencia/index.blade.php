@extends('layout.main')

@section('page-title')
    <i class="fad fa-home-lg mr-2"></i> Áreas
@stop

@section('headerButtons')
	@include('layout.headerButtonSmall')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <sf-dependencia/>
        </div>
    </div>
@endsection

