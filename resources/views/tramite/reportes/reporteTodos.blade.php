@php
	$estados = [
					1 =>[0 => 'POR RECIBIR',1 => "RECIBIDO"],
					2 =>[0 => 'GENERADO',1 => "GENERADO"],
					3 =>[0 => 'RECIBIDO',1 => "RECIBIDO"]
				]
@endphp	
@extends('layout.main-reportes')
@section('contentmain')
<div class="col-12 col-sm-12 col-md-8 mx-auto">
	<div class="card">
		<div class="card-block">
			<button  onclick="window.print();" class="btn btn-dark hidden-print position-absolute " style="top:0px; right:0px;z-index: 9999">
				<img src="{{ asset('/svg/imprimir.svg') }}" class="img-30 ">
				<span class="ml-0 ml-md-2 d-none d-md-inline-block">IMPRIMIR</span>
			</button>
			<div class="row">
				<div class="col-12 text-center  titulo-print">
					<h6 class="p-0 m-0">{{ $titulo }}</h6>
					<h5 class="p-0 m-0">{{ Auth::user()->dependencia->nombre }}</h5>
					<hr class="m-1 p-0 bg-white">
				</div>
				<div class="col-6 text-center">
					<table class="mx-auto table-desde-hasta">
						<tr class="bg-dark text-white ">
							<th>DESDE</th>
						</tr>
						<tr class="format-numero">
							<td class="px-2">{{ $desde }}</td>
						</tr>
					</table>
				</div>
				<div class="col-6  text-center">
					<table class="mx-auto table-desde-hasta">
						<tr class="bg-dark text-white ">
							<th>HASTA</th>
						</tr>
						<tr class="format-numero">
							<td class="px-2">{{ $hasta }}</td>
						</tr>
					</table>
				</div>
				<div class="col-12">
					<hr class="m-0 mb-2 p-0">
					@if ($documentos->count() <= 0)
						<h4 class="text-center">No se encontraron documentos</h4>
					@endif

					@foreach ($documentos as $documento)
						<table  class="tabla-reportes-todos mt-2" width="100%" >
							<tr>
								<td>
									<table width="100%" class="table-bordered">
										<tr>
											<th  width="100px">N° DE REGISTRO</th>
											<td ><span class="format-numero">{{ $documento->documento->full_nro_registro }}</span></td>
											<th  width="50px" >ESTADO</th>
											<td>{{ $estados[$estado][$documento->isProcesado] }} [{{ $documento->fechaOperacion }}]</td>
											<th width="40px">FOLIOS</th>
											<td width="50px"><span class="format-numero">{{ $documento->documento->folios }}</span></td>
										</tr>
										<tr>
											<th  >DOCUMENTO</th>
											<td colspan="6" ><span class="format-numero">{{ $documento->documento->full_documento }}</span></td>
											

											
										</tr>
										<tr>
											<th  >REMITENTE</th>
											<td colspan="6" >{!! $documento->documento->origenDocumento == 1 ? ($documento->documento->tipoPersona == 1 ? '<span class="badge badge-dark">P. NATURAL</span>'  :'<span class="badge badge-dark">P. JURIDICA</span>'): '<span class="badge badge-primary">MUNI SECCLLA</span>' !!} {{ $documento->documento->origenDocumento == 1 ? ($documento->documento->tipoPersona == 2 ? $documento->documento->dependencia : '') : $documento->documento->dependencia }} {!! $documento->documento->tipoPersona == 2 || $documento->documento->origenDocumento == 0 ? "<br>FIRMA: ":'' !!}<strong>{{ $documento->documento->firma }}</strong></td>
										</tr>
										{{-- <tr>
											<th  >ASUNTO</th>
											<td colspan="6">{{ $documento->documento->asunto }}</td>
										</tr> --}}
										@if ($estado==1)
											<tr>
												<th >ORIGEN</th>
												<td colspan="6"><strong>{{ $documento->origenOficina->nombre }}</strong></td>
											</tr>
										@endif
											
									</table>
								</td>
							</tr>
						</table>

					@endforeach

						
				</div>
			</div>
		</div>
			
	</div>

</div>
@endsection

