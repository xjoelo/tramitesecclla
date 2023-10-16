@extends('layout.main-externo')
@section('content')
<div class="container-fluid" style="max-width:1200px; margin:0 auto !important">
	{{-- <div class="row">
		<div class="col py-3">
			<h4 class="text-center text-white">MESA DE PARTES VIRTUAL</h4>
		</div>
	</div> --}}
	<div class="row justify-content-md-center">
		<div class="col-12 col-md-9">
			<sf-tramite-virtual></sf-tramite-virtual>
		</div>
	</div>
</div>
@endsection
