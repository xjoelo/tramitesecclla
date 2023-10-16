@extends('layout.main')
@section('headerButtons')
@include('layout.headerButtonSmall')
@endsection
<?php 
    $tipoOperacion = [1 => 'Registrado' , 2 => 'Derivado' ,3 => 'Archivado' ,4 => 'Adjuntado'];
    $formaEntrega = [1 => 'ORIGINAL', 2 => 'COPIA', 3 => 'DIGITAL'];
    ?>
@section('content')
<div class="container-fluid" style="max-width:1200px; margin:0 auto !important;font-family: Arial !important">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-10">
            <div class="card">
                <div class="card-body printShow">
                    <div class="col-12 text-center py-0">
                        <button class="btn  btn-dark hidden-print" id="btn-imprimirTramite" onclick="window.print();">
                        <img src="{{ asset('svg/imprimir.svg') }}" class="img-30 ">
                        <span class="ml-0 ml-md-2 d-none d-md-inline-block">IMPRIMIR</span>
                        </button>
                        <h4 class="m-0 p-0">HOJA DE TRAMITE</h4>
                        <span class="text-muted m-0 p-0">Nro de Registro</span>
                        <h3 class="m-0 p-0 format-numero">{{ $documento->origenDocumento == 1 ? "E" : "I" }}{{ str_pad($documento->nroDocumento,  8, "0",STR_PAD_LEFT) }}</h3>
                    </div>
                    <div class="col-12">
                        <table class="table table-bordered table-tramite tr11  mb-1" style="border:solid 2px #717171;">
                            <tbody>
                                <tr>
                                    <th style="width:150px">Documento</th>
                                    <td>{{ $documento->full_documento }}</td>
                                </tr>
                                <tr>
                                    <th>Fecha del Documento</th>
                                    <td>{{ $documento->fechaDocumento }}</td>
                                </tr>
                                <tr>
                                    <th>Fecha del Registro</th>
                                    <td>{{ $documento->fechaRegistro }}</td>
                                </tr>
                                <tr>
                                    <th>Folios</th>
                                    <td>{{ $documento->folios }}</td>
                                </tr>
                                <tr>
                                    <th>Asunto</th>
                                    <td class="text-uppercase">{{ $documento->asunto }}</td>
                                </tr>
                                <tr>
                                    <th>Adjuntos</th>
                                    <td class="text-uppercase" >{{ $documento->adjuntos }}</td>
                                </tr>
                                @if ($documento->tipoPersona == 2 || $documento->origenDocumento == 0)
                                    <tr>
                                        <th>Dependencia</th>
                                        <td>{{ ltrim($documento->dependencia) }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Firma</th>
                                    <td>{{ ltrim($documento->firma) }}</td>
                                </tr>
                                @if ($documento->tipoPersona == 2 ||  $documento->origenDocumento == 0)
                                    <tr>
                                        <th>Cargo</th>
                                        <td>{{ ltrim($documento->cargoFirma) }}</td>
                                    </tr>
                                @endif
                        </table>
                        @if ($documento->docReferencia)
                            <table class="table table-bordered table-tramite tr11 mb-1 " style="border:solid 2px #717171;">
                                <tbody>
                                    <tr>
                                        <th  colspan="2" style="text-align:center">DOCUMENTO DE REFERENCIA</th>
                                    </tr>
                                    <tr>
                                        <th  style="width:150px">Nro de Registro</th>
                                        <td class="format-numero"><a href="/documento/ver/tramite/{{$documento->docReferencia->id}}/{{$documento->docReferencia->nroDocumento}}">{{ $documento->docReferencia->full_nro_registro }}</a></td>
                                    </tr>
                                    <tr>
                                        <th  style="width:150px">Documento</th>
                                        <td class="format-numero">{{ $documento->docReferencia->full_documento }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-tramite tr10 mb-1" width="100%" style="border:solid 2px #717171;">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-file-exclamation"></i></th>
                                        <th style="min-width:70px">FECHA</th>
                                        <th>OPERACIÓN</th>
                                        <th>FORMA</th>
                                        <th>AREA/OFICINA</th>
                                        <th>USUARIO</th>
                                        <th>OFICINA DESTINO</th>
                                        <th>USUARIO DESTINO</th>
                                        <th>PROVEIDO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($documento->operaciones as $operacion)
                                    <tr class="{{ $operacion->isProcesado == 1 ? 'procesado ' : "enProceso "}}">
                                        <td class="text-center"><span class="d-none d-print-inline">{!! $operacion->tipoOperacion == 1 ? '<i class="fas fa-file-signature fa-2x"></i>' : ($operacion->tipoOperacion == 2 ? '<i class="fas fa-share-square fa-flip-vertical fa-2x"></i>' : ($operacion->tipoOperacion == 3 ? '<i class="fas fa-inbox-in fa-2x"></i>' : '<i class="fas fa-copy fa-2x"></i>')) !!}</span><span class="d-print-none" >{!! $operacion->isProcesado == 1 ? '<i class="fas fa-check-circle text-success fa-lg"></i>' : '<i class="fas fa-spinner fa-pulse fa-lg"></i>' !!}</span></td>
                                        <td>{{ $operacion->fechaOperacion }}</td>
                                        <td class="text-center">{{strtoupper($tipoOperacion[$operacion->tipoOperacion])}}</td>
                                        <td>{{ $formaEntrega[$operacion->forma] }}</td>
                                        <td>{{ $operacion->nombreDependencia }}</td>
                                        <td>{{ ltrim($operacion->nombreUsuario) }}</td>
                                        <td>{{ $operacion->derivadoOficina->nombre ?? '' }}</td>
                                        <td>{{ ltrim($operacion->derivadoUsuario->full_name ?? '') }}</td>
                                        <td>{!! $operacion->proveido !!}@if ($operacion->tipoOperacion == 3) @isset ($operacion->archivador) <small class="text-muted">ARCHIVADO EN {{ $operacion->archivador->nombre }} - {{ $operacion->archivador->periodo }}@endisset @endif @if ($operacion->isDesarchivado) - DESARCHIVADO ({{ $operacion->fechaDesarchivado }})@endif</small></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($documento->docAtendido)
                            <table class="table table-bordered table-tramite tr11 mb-1" style="border:solid 2px #717171;">
                                <tbody>
                                    <tr>
                                        <th  colspan="2" style="text-align:center">SE ATENDIÓ CON EL DOCUMENTO</th>
                                    </tr>
                                    <tr>
                                        <th  style="width:150px">Nro de Registro</th>
                                        <td class="format-numero"><a href="/documento/ver/tramite/{{$documento->docAtendido->id}}/{{$documento->docAtendido->nroDocumento}}">{{ $documento->docAtendido->full_nro_registro }}</td>
                                    </tr>
                                    <tr>
                                        <th  style="width:150px">Documento</th>
                                        <td class="format-numero">{{ $documento->docAtendido->full_documento }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection