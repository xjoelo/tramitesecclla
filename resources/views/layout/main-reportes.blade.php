@extends('layout.main')
@section('content')
<div class="row d-flex align-items-center">
    <div class="col-12 d-print-none" >
    	<div class="card " >
            <div class="card-header text-center">
                <h4 class="m-0 p-0">
                    <i class="fas fa-file-contract mr-2"></i>
                    MODULO DE REPORTES
                </h4>
            </div>
    		<div class="card-block" style="background: #F7F7F7">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 text-center">
                        <div id="botones">
                            <a id="boton" href="/formulario/derivados" class="btn btn-lg btn-success">
                                <i class="fas fa-share-square fa-flip-vertical fa-lg mr-2"></i>
                                Derivados
                            </a>
                            <a id="boton" href="/formulario/por-recibir" class="btn btn-lg btn-primary">
                                <i class="fas fa-share-square fa-flip-vertical fa-flip-horizontal fa-lg mr-2"></i>
                                por Recibir
                            </a>
                            <a id="boton" href="/formulario/generados" class="btn btn-lg btn-dark">
                                <i class="far fa-file-signature fa-lg mr-2"></i>
                                Generados
                            </a>
                            <a id="boton" href="/formulario/recibidos" class="btn btn-lg btn-warning">
                                <i class="far fa-file-signature fa-lg mr-2"></i>
                                Recibidos
                            </a>
                            <a id="boton" href="/formulario/archivados" class="btn btn-lg btn-info">
                                <i class="far fa-inbox-in mr-2 fa-lg"></i>
                                Archivados
                            </a>
                        </div>
                    </div>
                </div>  
    		</div>
        </div>
    </div>
    
    @yield('contentmain')
 
 </div>
@endsection

