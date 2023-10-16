@extends('layout.main')

@section('page-title')
    <i class="fad fa-file-alt mr-2"></i> Archivadores
@stop

@section('headerButtons')
	@include('layout.headerButtonSmall')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <sf-archivador />
        </div>
    </div>
@endsection

