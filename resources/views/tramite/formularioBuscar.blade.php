@extends('layout.main')

@section('headerButtons')
	@include('layout.headerButtonSmall')
@endsection

@section('content')
<div class="row justify-content-md-center">
    <div class="col-12 col-md-10" >
    	<div class="card">
            <div class="card-header text-center">
                <h5 >Busqueda Personalizada</h5>
            </div>
    		<div class="card-block d-flex justify-content-center">
                <div class="col-12">
                    <ul class="nav nav-tabs md-tabs " role="tablist" style="border:none;">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#basico" role="tab"><i class="fad fa-2x fa-file-search mr-2"></i>Básico</a>
                            <div class="slide"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#personalizado" role="tab"><i class="fad fa-2x fa-file-search mr-2"></i>Personalizada</a>
                            <div class="slide"></div>
                        </li>
                    </ul>
                    <div class="tab-content card-block" style="border:solid 2px #448aff;">
                        <div class="tab-pane active" id="basico" role="tabpanel">
                            <form action="{{ route('buscarDocumento') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-4">
                                        <label for="nroDocumentoTipo">ORIGEN DE DOCUMENTO</label>
                                        <select name="origenDocumento" class="form-control">
                                            <option value="0">DOCUMENTO INTERNO</option>
                                            <option value="1">DOCUMENTO EXTERNO</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-4">
                                        <label for="nroDocumentoTipo">N° DE REGISTRO</label>
                                        <input name="nroDocumento" type="number" required class="form-control">
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
                            <sf-busqueda-personalizada></sf-busqueda-personalizada>
                        </div>
                    </div>
                </div>
    		</div>
    	</div>
    </div>
 </div>
@endsection

