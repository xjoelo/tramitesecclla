@extends('layout.main')

@section('headerButtons')
	@include('layout.headerButtonSmall')
@endsection

@section('content')
<div class="row justify-content-md-center">
    <div class="col-12" >
    	<div class="card">
    		<div class="card-header text-center p-3 bg-light">
    			<h4 class="m-0 p-0">Resultados de busqueda</h4>
    		</div>
    		<div class="card-block">
    			@if (count($documentos) >= 1)
    				<div class="table-responsive">
    					<table class="table table-xs table-personal table-hover">
    						<thead style="background: #EBEBEB">
    							<tr>
    								<th>N° de Registro</th>
    								<th>Fecha de Registro</th>
    								<th>Documento</th>
    								<th>Dependencia</th>
    								<th>Firma</th>
    								{{-- <th>Cargo</th> --}}
                                    <th>Folios</th>
    							</tr>
    						</thead>
    						<tbody>
    							@foreach ($documentos as $documento)
                                    <tr>
                                        <td class="format-numero" style="font-size: 15px !important">
                                            <a href="/documento/ver/tramite/{{ $documento->id }}/{{ $documento->nroDocumento }}">{{ $documento->origenDocumento == 0 ?"I":"E" }}{{ str_pad($documento->nroDocumento, 8, "0", STR_PAD_LEFT) }}</a>
                                        </td>
                                        <td style="font-size: 12px !important">{{ $documento->fechaRegistro->format('d-m-Y')}}</td>
                                        <td class="format-numero" style="font-size: 12px !important">{{ $documento->tipoDocumento->nombre }} N° {{ str_pad($documento->nroDocumentoTipo, 4, "0", STR_PAD_LEFT) }}-{{ $documento->siglas }}</td>
                                        <td style="font-size: 12px !important">{{ $documento->dependencia }}</td>
                                        <td style="font-size: 12px !important">{{ $documento->firma }}</td>
                                        {{-- <td style="font-size: 12px !important">{{ $documento->cargo }}</td> --}}
                                        <td style="font-size: 12px !important">{{ $documento->folios }}</td>
                                       
                                @endforeach
    							
    						</tbody>
    					</table>
    				</div>
    			@else
    				<div class="row">
    					<div class="col-12 text-center">
    						<span class="text-muted">No se encontraron resultados<br>
    						Si no recuerda el nro de registro puede hacer una busqueda personalizada</span> <br>		
    						<a href="/documento/buscar" class="btn btn-dark my-3">
						        <img src="{{ asset('svg/buscar-tramite.svg')}}" class="img-30"  >
						        <span class="">BUSQUEDA PERSONALIZADA</span>
						    </a> 
    					</div>
    				</div>	
    			@endif
    		</div>
    	</div>
    </div>
 </div>
@endsection

