@extends('layout.main')
@section('headerButtons')
	@include('layout.headerButtonSmall')
@endsection
@section('content')
  <div class="row justify-content-md-center">
    <div class="col-12 col-md-12 col-lg-10" >
    	@if (isset($documento))
    		<sf-nuevo-tramite
    			:documento-adjuntar="{{ $documento }}"
    			:adjuntar="{{ $adjuntar }}"
                :operacion-adjuntar="{{ $operacion }}"
		        :user="{{auth()->user()->load('dependencia')}}"
		        name-entity="{{ config('app.siglas_entity') }}" />
    	@else
	    	<sf-nuevo-tramite
	        :user="{{auth()->user()->load('dependencia')}}"
	        name-entity="{{ config('app.siglas_entity') }}" />
    	@endif
    	
      
    </div>
  </div>
@endsection

