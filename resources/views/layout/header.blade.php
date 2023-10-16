<nav class="navbar header-navbar pcoded-header navbar-fixed-add iscollapsed hidden-print" >
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                <i class="far fa-bars"></i>
            </a>
            <a href="{{ route('home') }}">
                <img class="img-fluid logo" src="{{ asset('images/logo-munisecclla-tramite-virtual.png')}}"  style="max-width: 170px !important" alt="Logo SofticsFact" />
                {{-- <img class="img-fluid logo d-inline-block d-sm-none" src="{{ asset('svg/logo-softicsfact-50x50.png')}}"  alt="Logo SofticsFact" /> --}}
            </a>
        </div>
        <div class="navbar-container">
            <ul class="nav-right">
                <li class="header-notification d-none d-sm-inline-block">
                    <form action="{{ route('buscarDocumento') }}" method="POST">
                        <div class="  input-group input-group-sm  input-group-primary position-relative" style="top:10px;font-size: 10px !important">
                        
                            @csrf
                            <input required="required" autocomplete="off" type="search" name="nroDocumento" id="inputSearch" placeholder="N° de Registro" class="form-control format-numero" style="padding: 0.25rem 0.5rem !important;"> 
                            <div class="input-group-append">
                                <button type="submit" class="btn  btn-primary" ><i class="fas fa-file-search mr-2"></i>Buscar</button>
                            </div>
                        </div>
                    </form>
                </li>
                <li class="user-profile header-notification px-1 px-sm-3">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ asset('assets/images/avatar-softics-fact.png') }}" class="img-radius" alt="User-Profile-Image">
                            <i class="fas fa-sort-down text-primary"></i>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            {{-- <li>
                                <a href="#!">
                                <i class="feather icon-settings"></i> Settings
                                </a>
                            </li>
                            <li>
                                <a href="user-profile.html">
                                <i class="feather icon-user"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a href="email-inbox.html">
                                <i class="feather icon-mail"></i> My Messages
                                </a>
                            </li>
                            <li>
                                <a href="auth-lock-screen.html">
                                <i class="feather icon-lock"></i> Lock Screen
                                </a>
                            </li> --}}
                            <li>
                                <a href="#" class="py-2 hoverS" data-toggle="modal" data-target="#changePassword">
                                    <i class="feather icon-log-out"></i> Cambiar contraseña
                                </a>
                                <br>
                                <a href="javascript:;" onclick="event.preventDefault();document.getElementById('form-logout').submit()">
                                    <i class="feather icon-log-out"></i> Cerrar sesión
                                </a>
                                
                                <form id="form-logout" action="{{ route('logout') }}" class="d-none" method="post">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambiar Contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/cambiar-password" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div  class="form-group col-sm-12">
                            <label  for="folios">Contraseña Actual</label>
                            <input  required name="passwordAnterior" type="password" class="form-control">
                        </div>
                        <div  class="form-group col-sm-12">
                            <label  for="folios">Contraseña Nueva</label>
                            <input  required name="newPassword" type="password" class="form-control">
                        </div>
                        <div  class="form-group col-sm-12">
                            <label  for="folios">Repita Contraseña</label>
                            <input  required name="repitPassword" type="password" class="form-control">
                        </div> 
                    </div>
                </div>
            
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                </div>
            </form>
        </div>
    </div>
</div>