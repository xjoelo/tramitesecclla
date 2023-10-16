<div class="row d-flex justify-content-center  px-3 py-0">
    <a href="{{ url('documento/por-recibir') }}" class="btn btn-primary" style="border: 1px solid #94B6FF; box-shadow: 0px 0px 5px #80B0FF ">
        <img src="{{ asset('svg/recibir-tramite.svg')}}" class="img-30"  >
        <span class="d-none d-md-inline-block">POR RECIBIR</span>
    </a> 
    <a href="{{ url('documento/proceso') }}" class="btn btn-warning ">
        <img src="{{ asset('svg/en-proceso-tramite.svg')}}" class="img-30"  >
        <span class="d-none d-md-inline-block">EN PROCESO</span>
    </a> 
    <a href="{{ url('documento/derivados') }}" class="btn btn-success ">
        <img src="{{ asset('svg/derivar-tramite.svg')}}" class="img-30"  >
        <span class="d-none d-md-inline-block">DERIVADOS</span>
    </a> 
    
    <a href="/tramite" class="btn btn-secondary">
        <img src="{{ asset('svg/nuevo-tramite.svg')}}" class="img-30"  >
        <span class="d-none d-md-inline-block">NUEVO </span>
    </a> 
    <a href="{{ url('documento/archivados') }}" class="btn btn-info">
        <img src="{{ asset('svg/archivados-tramite.svg')}}" class="img-30"  >
        <span class="d-none d-md-inline-block">ARCHIVADOS</span>
    </a> 
    <a href="{{ url('documento/buscar') }}" class="btn btn-light ">
        <img src="{{ asset('svg/buscar-tramite.svg')}}" class="img-30"  >
        <span class="d-none d-md-inline-block">BUSCAR</span>
    </a> 
</div>