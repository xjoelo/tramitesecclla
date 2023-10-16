@extends('layout.main-reportes')
@section('contentmain')
<div class="col-12 col-sm-12 mx-auto">
	<div class="card">
		<div class="card-block">
			<button  onclick="window.print();" class="btn btn-dark hidden-print position-absolute " style="top:0px; right:0px;z-index: 9999">
				<img src="{{ asset('/svg/imprimir.svg') }}" class="img-30 ">
				<span class="ml-0 ml-md-2 d-none d-md-inline-block">IMPRIMIR</span>
			</button>
			<div class="row">
				<div class="col-12 text-center titulo-print">
					<h6 class="p-0 m-0">DOCUMENTOS DERIVADOS DESDE</h6>
					<h5 class="p-0 m-0">{{ Auth::user()->dependencia->nombre }}
						@if ($documentos->count() > 0)
							@if ($isDependencia)
								<i class="fas fa-arrow-alt-right mx-2"></i> {{ $documentos[0]->derivadoOficina->nombre }}
							@endif
						@endif
					</h5>
					<hr class="m-1 p-0 bg-white">
				</div>
				<div class="col-6 text-center">
					<table class="mx-auto table-desde-hasta">
						<tr class="bg-dark text-white">
							<th>DESDE</th>
						</tr>
						<tr class="format-numero">
							<td class="px-2">{{ $desde }}</td>
						</tr>
					</table>
				</div>
				<div class="col-6  text-center">
					<table class="mx-auto table-desde-hasta">
						<tr class="bg-dark text-white">
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
						<table  class="tabla-reportes tabla-reportes-print" width="100%" >
							<tr>
								<td>
									<table width="100%">
										<tr>
											<th class="border-b-table  tamanio"  width="100px">N° DE REGISTRO</th>
											<td class="border-b-table"  width="200px"><span class="format-numero">{{ $documento->documento->full_nro_registro }}</span></td>
											<th class="border-b-table" >ESTADO</th>
											<td class="border-b-table" ><span class="format-numero">{{ $documento->isProcesado ? "RECIBIDO" : "DERIVADO" }}</span><small class="text-muted">[{{ $documento->fechaOperacion }}]</small></td>
											<th class="border-b-table" >FOLIOS</th>
											<td class="border-b-table" >{{ $documento->documento->folios }}</td>
											<td rowspan="7" width="150px" class="p-2">
												<table style="border:solid 1px #646464"  width="100%">
													<tr class="text-center">
														<th>FIRMA DE RECEPCIÓN</th>
													</tr>	
													<tr>
														<td>
															<br>
															<br>
															<br>
															<br>
															<br>
															<br>
															<br>
															<br>
															<br>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<th class="border-b-table" >DOCUMENTO</th>
											<td class="border-b-table" colspan="5" ><span class="format-numero">{{ $documento->documento->full_documento }}</span></td>
										</tr>
										<tr>
											<th class="border-b-table" >REMITENTE</th>
											<td  colspan="5" class="border-b-table" >{!! $documento->documento->origenDocumento == 1 ? ($documento->documento->tipoPersona == 1 ? '<span class="badge badge-dark">P. NATURAL</span>'  :'<span class="badge badge-dark">P. JURIDICA</span>'): '<span class="badge badge-primary">MUNI SECCLLA</span>' !!} {{ $documento->documento->origenDocumento == 1 ? ($documento->documento->tipoPersona == 2 ? $documento->documento->dependencia : '') : $documento->documento->dependencia }} {!! $documento->documento->tipoPersona == 2 || $documento->documento->origenDocumento == 0 ? "<br>FIRMA: ":'' !!}<strong>{{ $documento->documento->firma }}</strong><i class="fas fa-phone-square-alt ml-3 mr-2"></i><span class="format-numero">{{ $documento->documento->celularOrigen }}</span></td>
										</tr
										><tr>
											<th class="border-b-table" >ASUNTO</th>
											<td  colspan="5" class="border-b-table" >{{ $documento->documento->asunto }}</td>
										</tr>
										<tr>
											<th class="border-b-table" >ADJUNTOS</th>
											<td  colspan="5" class="border-b-table" >{{ $documento->documento->adjuntos }}</td>
										</tr>
										
										<tr>
											<th >DESTINO</th>
											<td colspan="5" ><strong>{{ $documento->derivadoOficina->nombre }}</strong></td>
										</tr>
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

