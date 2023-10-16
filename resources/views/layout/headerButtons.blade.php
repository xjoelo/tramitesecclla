<div class="row d-flex justify-content-center  px-3 py-0">
    <div class="col-6 col-sm-6 col-md-4 ">
        <a href="{{ url('/documento/por-recibir') }}" class="btn btn-primary btn-block mb-3">
            <img src="{{ asset('svg/recibir-tramite.svg')}}" class="img-70"  >
            <br>
            <span class="d-none d-md-inline">DOCUMENTOS</span> POR RECIBIR
        </a> 
    </div>
    <div class="col-6 col-sm-6 col-md-4 ">
        <a href="{{ url('/documento/proceso') }}" class="btn btn-warning btn-block mb-3">
            <img src="{{ asset('svg/en-proceso-tramite.svg')}}" class="img-70"  >
            <br>
            <span class="d-none d-md-inline">DOCUMENTOS</span> EN PROCESO
        </a> 
    </div>
    <div class="col-6 col-sm-6 col-md-4 ">
        <a href="{{ url('documento/derivados') }}" class="btn btn-success btn-block mb-3">
            <img src="{{ asset('svg/derivar-tramite.svg')}}" class="img-70"  >
            <br>
            <span class="d-none d-md-inline">DOCUMENTOS</span> DERIVADOS
        </a> 
    </div>

    <div class="col-6 col-sm-6 col-md-4 ">
        <a href="{{ url('/tramite') }}" class="btn btn-secondary btn-block mb-3">
            <img src="{{ asset('svg/nuevo-tramite.svg')}}" class="img-70"  >
            <br>
            NUEVO <span class="d-none d-md-inline">TRÁMITE</span>   
        </a> 
    </div>
    <div class="col-6 col-sm-6 col-md-4 ">
        <a href="{{ url('documento/archivados') }}" class="btn btn-info btn-block mb-3">
            <img src="{{ asset('svg/archivados-tramite.svg')}}" class="img-70"  >
            <br>
            <span class="d-none d-md-inline">DOCUMENTOS</span> ARCHIVADOS
        </a> 
    </div>
    
    <div class="col-6 col-sm-6 col-md-4 ">
        <a href="{{ url('documento/buscar') }}" class="btn btn-light btn-block mb-3">
            <img src="{{ asset('svg/buscar-tramite.svg')}}" class="img-70"  >
            <br>
            BUSCAR <span class="d-none d-md-inline">TRÁMITE</span>   
        </a> 
    </div>
</div>