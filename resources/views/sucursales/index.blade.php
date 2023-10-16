@extends('layout.main')

@section('page-title')
	<i class="fad fa-building mr-2"></i> Sucursales
@stop

@section('headerButtons')
	@include('layout.headerButtons')
@endsection
@section('content')
<div class="row">
	<div class="col-12">
		<sf-sucursales></sf-sucursales>
	</div>
</div>
@endsection

