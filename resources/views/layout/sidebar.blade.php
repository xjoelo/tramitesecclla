<nav class="pcoded-navbar hidden-print">
    <div class="pcoded-inner-navbar main-menu app-sidebar">
        <div class="">
            <div class="main-menu-header text-center">
                <img class="img-menu-user img-radius" src="{{asset('assets/images/avatar-softics-fact.png')}}" alt="User-Profile-Image">
                <div class="user-details d-block">
                    <p id="more-details" class="text-uppercase text-center">{{ Auth::user()->full_name }}</p>
                    <small class="text-muted"></small>
                </div>
            </div>
        </div>
        <div class="text-center bg-primary text-white pcoded-navigation-label">
            <h6 class="text-white m-0 p-0">{{ Auth::user()->dependencia->abreviado }}</h6>
        </div>
        
        <div class="pcoded-navigation-label">DOCUMENTOS</div>
        <ul class="pcoded-item pcoded-left-item">
            <li>
                <a href="{{ route('nuevo-tramite') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon">
                        <img src="{{ asset('svg/nuevo-tramite.svg') }}" width="35px" alt="">
                    </span>
                    <span class="pcoded-mtext ml-3">Nuevo trámite</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/documento/por-recibir') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon">
                        <img src="{{ asset('svg/recibir-tramite.svg') }}" width="35px" alt="">
                    </span>
                    <span class="pcoded-mtext ml-3">Por Recibir</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/documento/proceso') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon">
                        <img src="{{ asset('svg/en-proceso-tramite.svg') }}" width="35px" alt="">
                    </span>
                    <span class="pcoded-mtext ml-3">En Proceso</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/documento/derivados') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon">
                        <img src="{{ asset('svg/derivar-tramite.svg') }}" width="35px" alt="">
                    </span>
                    <span class="pcoded-mtext ml-3">Derivados</span>
                </a>
            </li>
            
            <li>
                <a href="{{ url('/documento/archivados') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon">
                        <img src="{{ asset('svg/archivados-tramite.svg') }}" width="35px" alt="">
                    </span>
                    <span class="pcoded-mtext ml-3">Archivados</span>
                </a>
            </li>
        </ul>
        <div class="pcoded-navigation-label">REPORTES</div>
        <ul class="pcoded-item pcoded-left-item">
            <li>
                <a href="{{ route('reportes') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon">
                        <img src="{{ asset('svg/reportes-tramire.svg') }}" width="35px" alt="">
                    </span>
                    <span class="pcoded-mtext ml-3">Reportes</span>
                </a>
            </li>
        </ul>
        <div class="pcoded-navigation-label">Administración</div>
        <ul class="pcoded-item pcoded-left-item">
            <li>
                <a href="{{ route('archivadores') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon">
                        <i class="fad fa-file-alt"></i>
                    </span>
                    <span class="pcoded-mtext">Archivadores</span>
                </a>
            </li>
            @if (Auth::user()->idRol == 1)
                <li>
                    <a href="{{ route('dependencia') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fad fa-home-lg"></i>
                        </span>
                        <span class="pcoded-mtext">Áreas</span>
                    </a>
                </li>
                <li>
                  <a href="{{ route('tipo-documentos') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon">
                      <i class="fad fa-file-alt"></i>
                    </span>
                    <span class="pcoded-mtext">Tipo documentos</span>
                  </a>
                </li>
                <li>
                  <a href="{{ route('usuarios') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon">
                      <i class="fad fa-users"></i>
                    </span>
                    <span class="pcoded-mtext">Usuarios</span>
                  </a>
                </li>

            @endif
    <br>
    <br>
    <br>
    <br>
    <br>
        </ul>
    </div>
</nav>
