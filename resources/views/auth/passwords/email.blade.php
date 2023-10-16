@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="content-logo">
                    <img src="{{ asset('images/logo-munisecclla-tramite-virtual.png') }}" height="90" alt="logo muni secclla">
                </div>
                <div class="sub-title">{{ __('Reset Password') }}</div>

                <div class="card-body ">
                    <div class="row">
                        <div class="col-12">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    Se envio un email con un link para reestablecer su contraseña
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="email" class="">
                                        <i class="far fa-envelope mr-2"></i>
                                        {{ __('E-Mail Address') }}
                                    </label>

                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                          
                                </div>

                                <div class="form-group text-center">

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane mr-2"></i>
                                        Reestablecer Contraseña
                                    </button>
                                </div>
                                <div class="form-group text-center">

                                    <a href="/" type="submit" class="btn btn-outline-success">
                                        <i class="fas fa-lock"></i>
                                        Volver al Autenticación
                                    </a>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                           
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
