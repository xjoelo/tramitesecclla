@extends('layout.main-externo')

@section('content')
<div class="container-fluid" style="max-width:1200px; margin:0 auto !important">
	<div class="row justify-content-center">
    <div class="col-sm-12 col-md-6">
      <div class="card">
        <div class="card-header bg-primary">
          <div class="col-12 text-center">
            <h5 class="mb-0 text-white">Trámite registrado correctamente</h5>
          </div>
        </div>
        <div class="card-body">
          <div class="col-12 text-center py-1">
            <img src="{{ asset('images/correo-electronico.png') }}"  width="90px"  alt="Imagen de buzón de correo entregado">
          </div>
          <div class="col-12 text-center mb-2">
            Sr(a)
            <span class="font-weight-bold">{{ $documento->dependencia }}</span>
            <br>su trámite se ha registrado correctamente.
          </div>
          <div class="col-12 text-center">
            <h5 class="py-1 px-3 bg-secondary d-inline-block text-white">
              NUMERO DE REGISTRO 
            </h5>
            <h4>
              <span class="font-weight-bold format-numero">E{{ str_pad($documento->nroDocumento,  7, "0",STR_PAD_LEFT) }}</span>
            </h4>
             <img src="data:image/png;base64, {!! $imageQR !!} ">
             
          </div>
          <div class="col-12 text-center">
            <small class="text-muted">
              Con el <span class="font-weight-bold">NUMERO DE REGISTRO </span> ud. podrá consultar el seguimiento de su <span class="font-weight-bold">TRÁMITE</span>
            </small>
            <p>
              Tambien puede consultar en la siguiente URL <br>
              <a href="{{$url}}" class="btn-link">
                 {{ $url }}
              </a>
            </p>
          </div>
          @if ($documento->emailOrigen)
            <div class="col-12 text-center">
              <div class="alert alert-info border-info p-1 px-3">
                <small>
                  <i class="fal fa-info-circle mr-2"></i> Se envio un email con los datos de registo
                </small>
              </div>
            </div>
          @endif
            
          <div class="col-12 text-center">
            <p class="text-success">
              Al concluir el tramite nos comunicaremos con ud. a los siguientes <span class="font-weight-bold">DATOS DE CONTACTO</span><br>
            </p>
            <p>
              @if ($documento->emailOrigen)
                <span class="font-weight-bold">CORREO</span>: {{ $documento->emailOrigen }} <br>
              @endif
              @if ($documento->celularOrigen)
                <span class="font-weight-bold">CELULAR</span>: {{ $documento->celularOrigen }} <br>
              @endif
              @if ($documento->direccionOrigen)
                <span class="font-weight-bold">DIRECCION</span>: {{ $documento->direccionOrigen }}
              @endif
                
            </p>
          </div>
        </div>
        <div class="card-footer d-flex justify-content-between hidden-print">
          <button  class="btn btn-secondary" onclick="window.print();" >
            <i class="fad fa-print mr-2"></i>
            Imprimir
          </button>
          <a href="/tramite/virtual" class="btn btn-primary">
            <i class="fad fa-file-plus mr-2"></i>
            Nuevo trámite
          </a>
          
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
