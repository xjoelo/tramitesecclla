@extends('layout.main')

@section('page-title')
	<i class="fad fa-users mr-2"></i> Usuarios
@stop

@section('headerButtons')
	@include('layout.headerButtonSmall')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <sf-usuarios></sf-usuarios>
        </div>
    </div>
@endsection

