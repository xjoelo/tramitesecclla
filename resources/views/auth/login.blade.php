@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="content-logo">
                        <img src="{{ asset('images/logo-munisecclla-tramite-virtual.png') }}"  alt="logo muni secclla">
                    </div>
                    <div class="sub-title">Iniciar Sesión</div>
                    <div >
                        @error('username')
                            <div class="alert alert-danger" role="alert">  
                                Las credenciales no son correctas  ó su usuario esta desactivado
                            </div>
                        @enderror
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-row mt-3">
                            <div class="col-12">
                                <label for="email" class="text-left">
                                    <i class="fas fa-user mr-2"></i>
                                    Usuario
                                </label>
                                <input id="email" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" placeholder="admin" autofocus>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-12">
                                <label for="password" class="text-left">
                                    <i class="fas fa-key mr-2"></i>
                                    Contraseña
                                </label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="**********">
                            </div>
                        </div>
                        <div class="form-row align-items-center mt-4">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label pointer" for="remember"> Recordar </label>
                                </div>
                           
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                     Ingresar
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="text-right mt-3">
                        @if (Route::has('password.request'))
                            <a class="btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
