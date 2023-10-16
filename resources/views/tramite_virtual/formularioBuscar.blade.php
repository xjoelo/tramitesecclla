@extends('layout.main-externo')

@section('headerButtons')
	@include('layout.headerButtonSmall')
@endsection

@section('content')
@php
    $tipoDocumentos = App\Models\TipoDocumento::where('isActive',1)->get();
@endphp
<div class="row justify-content-md-center">
    <div class="col-12 col-md-8" >
    	<div class="card">
            <div class="card-header">
                <h5 >Busqueda</h5>
                <div class="card-header-right mr-0 align-middle">
                    <a href="/tramite/consultar" class="btn btn-primary">
                        <i class="fas fa-qrcode mr2"></i> 
                        ESCANEAR QR
                    </a>
                </div>
            </div>
    		<div class="card-block">
                    @error('documento')
                        <div class="col-12 col-md-12">
                            <div class="alert alert-danger" role="alert">
                                No se encontró  resultados del documento <span class="format-numero">E{{ str_pad($errors->first(), 8, '0', STR_PAD_LEFT) }}</span> 
                            </div>
                        </div>
                    @enderror
                    <div class="col-12 col-md-12">
                        <ul class="nav nav-tabs md-tabs " role="tablist" style="border:none;">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#basico" role="tab"><i class="fad fa-2x fa-file-search mr-2"></i>Básico</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item {{ $errors->personalizado ? 'active': '' }}">
                                <a class="nav-link " data-toggle="tab" href="#personalizado" role="tab"><i class="fad fa-2x fa-file-search mr-2"></i>Personalizada</a>
                                <div class="slide"></div>
                            </li>
                        </ul>
                        <div class="tab-content card-block" style="border:solid 2px #448aff;">
                            <div class="tab-pane active" id="basico" role="tabpanel">
                                <form action="{{ route('buscarDocumentoExternoBasico') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-4">
                                            <label for="nroDocumentoTipo">ORIGEN DE DOCUMENTO</label>
                                            <select name="origenDocumento" class="form-control" readonly disabled="1">
                                                <option value="1" selected="">DOCUMENTO EXTERNO</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4">
                                            <label for="nroDocumentoTipo">N° DE REGISTRO</label>
                                            <input name="nroDocumento" type="number"  placeholder="1" required class="form-control">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4">
                                            <label for="nroDocumentoTipo">&nbsp;</label>
                                            <button class="btn btn-block btn-primary" style="padding: 6.75px">
                                                <i class="fa fa-search mr-2"></i> Buscar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane " id="personalizado" role="tabpanel">
                                 <form action="{{ route('buscarDocumentoExternoPersonalizado') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-12 col-lg-4">
                                            <label for="nroDocumentoTipo">ORIGEN DE DOCUMENTO</label>
                                            <select name="origenDocumento" class="form-control" readonly disabled="1">
                                                <option value="1" selected="">DOCUMENTO EXTERNO</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                            <label for="nroDocumentoTipo">DESDE</label>
                                            <input type="date" name="desde" class="form-control">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                            <label for="nroDocumentoTipo">HASTA</label>
                                            <input type="date" name="hasta" class="form-control">
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="nroDocumentoTipo">UNIDAD ORGANICA</label>
                                            <input type="text" name="dependencia" class="form-control">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="nroDocumentoTipo">FIRMA</label>
                                            <input name="firma" class="form-control" type="text">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                            <label for="nroDocumentoTipo">TIPO DE DOCUMENTO</label>
                                            <select name="tipoDocumento" class="form-control">
                                                <option value="">.. Seleccione ..</option>
                                                @foreach ($tipoDocumentos as $tipo)
                                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-2">
                                            <label for="nroDocumentoTipo">N° DOCUMENTO</label>
                                            <input name="nroDocumento" type="text" class="form-control">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6">
                                            <label for="nroDocumentoTipo">SIGLAS</label>
                                            <input name="nroDocumento" type="text" class="form-control">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="nroDocumentoTipo">ASUNTO</label>
                                            <textarea name="asunto" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                            <label for="nroDocumentoTipo">&nbsp;</label>
                                            <button type="submit" class="btn btn-block btn-primary" style="padding: 6.75px">
                                                <i class="fa fa-search mr-2"></i> Buscar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            
    		</div>
    	</div>
    </div>
 </div>
@endsection

