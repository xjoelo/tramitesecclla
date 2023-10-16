@extends('layout.main')

@section('page-title')

@stop
@section('content')
@section('headerButtons')
    <div class="row">
        <div class="col-12 text-center text-white">
            <h3 class="m-0 p-0">SISTEMA DE TRAMITE DOCUMENTARIO</h3>
            <h5 class="text-uppercase">Municipalidad Distrital de Secclla</h5>
            <h6><i class="fas fa-hotel mr-2"></i>[ {{ Auth::user()->dependencia->abreviado }} ]</h6>
            <h6><i class="fas fa-user mr-2"></i> [ {{ Auth::user()->full_name }} ]</h6>
        </div>
    </div>  
@endsection 
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted m-b-0">N°  de Documentos</h6>
                            <h4 class="text-c-blue">{{ $documentosPorRecibir }}</h4>
                            
                        </div>
                        <div class="col-4 text-right">
                            <i class="feather icon-file-text f-28"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-c-blue">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <h6 class="text-white m-b-0">Documentos por Recibir</h6>
                        </div>
                        <div class="col-3 text-right">
                            <a href="/documento/por-recibir" class="btn btn-outline-light btn-mini">
                        		<i class="fas fa-info-circle fa-lg mr-1"></i>
                        		Ver
                        	</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted m-b-0">N°  de Documentos</h6>
                            <h4 class="text-c-yellow">{{ $documentosEnProceso }}</h4>
                            
                        </div>
                        <div class="col-4 text-right">
                            <i class="feather icon-bar-chart-2 f-28"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-c-yellow">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <h6 class="text-white m-b-0">Documentos en Proceso</h6>
                        </div>
                        <div class="col-3 text-right">
                        	<a href="/documento/proceso" class="btn btn-outline-light btn-mini">
                        		<i class="fas fa-info-circle fa-lg mr-1"></i>
                        		Ver
                        	</a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted m-b-0">N°  de Documentos</h6>
                            <h4 class="text-c-green">{{ $documentosDerivados }}</h4>
                            
                        </div>
                        <div class="col-4 text-right">
                            <i class="feather icon-file-text f-28"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-c-green">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <h6 class="text-white m-b-0">Documentos Derivados</h6>
                        </div>
                        <div class="col-3 text-right">
                            <a href="/documento/derivados" class="btn btn-outline-light btn-mini">
                        		<i class="fas fa-info-circle fa-lg mr-1"></i>
                        		Ver
                        	</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
    @include('layout.headerButtons')
@endsection

