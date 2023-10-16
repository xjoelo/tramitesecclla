<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Sistema de Tramite Documentario | Municipalidad Distrital de Secclla - Huancavelica</title>
        <!--[if lt IE 10]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="Description" content="Sistema de Tramite Documentario | Municipalidad Distrital de Secclla - Huancavelica | SofticsLab - construimos y desarrollamos experiencias digitales">
        <meta name="user" content="{{ Auth::user()->load('dependencia')}}">
        <meta name="csrf" content="{{ csrf_token() }}">
        <meta property="og:url"                content="http://munisecclla.gob.pe" />
        <meta property="og:type"               content="web" />
        <meta property="og:title"              content="Sistema de Tramite Documentario | Municipalidad Distrital de Secclla - Huancavelica" />
        <meta property="og:description"        content="Sistema de Tramite Documentario | Municipalidad Distrital de Secclla - Huancavelica | SofticsLab - construimos y desarrollamos experiencias digitales" />
        <meta property="og:image"              content="{{ asset('assets/images/og-image-softicsfact.png') }}" />

        <meta name="author" content="SofticsLab Perú">
        <meta name="theme-color" content="#2871FC" />
        <meta name="keywords" content="sistema de tramite documentario  -Municipalidad Distrital de Secclla - Huancavelica , trtamite, huancavbelca, tramite virtual, huancavelica huancayo, softicslab, softicslab EIRL,peru,asistente virtual ">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">

        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="{{asset('components/bootstrap/css/bootstrap.min.css')}}">
        {{-- TOASTY STYLE --}}
        <link rel="stylesheet" href="{{ asset('components/toastjq/css/jquery.toast.css')}}">
        <!-- waves.css -->
        <link rel="stylesheet" href="{{ asset('assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
        <!-- font-awesome icon -->
        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/sweetalert.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/vue-select.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/add-styles.css') }}">
    </head>
    <body themebg-pattern="theme1">
        <!-- [ Pre-loader ] start -->
        <div class="row d-none d-print-block p-2">
            <div class="col-12 d-flex justify-content-between pb-1" style="border-bottom: 1px solid #e6e6e6">
                <img class="logo-login" src="{{ asset('images/logo-munisecclla-tramite-virtual.png') }}" alt="" height="40" >
                <div class="text-right" style="width: 250px" >
{{--                     <div class="float-left">
                        @isset ($imageQR)
                            <img src="data:image/png;base64, {!! $imageQR !!}  " height="65px">
                        @endisset
                    </div> --}}
                    <div class="float-right" style="font-size: 12px">
                        <span class="d-block p-0 font-weight-bold">
                            Fecha de Impresión
                        </span>
                        <span>{{ date('d-m-Y H:i:s') }}</span>
                    </div>
                        
                 </div>
            </div>
        </div>
        <div class="loader-bg">
            <div class="loader-bar"></div>
        </div>
        <!-- [ Pre-loader ] end -->
        <div id="pcoded" class="pcoded">
            <div class="pcoded-overlay-box"></div>
            <div class="pcoded-container navbar-wrapper">
                
                <!-- [ Header ] start -->
                @include('layout.header')
                <!-- [ Header ] end -->
                <div class="pcoded-main-container " >
                    <div class="pcoded-wrapper">
                        <!-- [ navigation menu ] start -->
                        @include('layout.sidebar')
                        <!-- [ navigation menu ] end -->
                        <div class="pcoded-content content-fixed-add">
                            <!-- [ breadcrumb ] start -->
                            <div class="page-header hidden-print">
                                <div class="page-block">
                                    <div class="row align-items-center" id="pageHeader">
                                        {{-- <div class="col-12 col-md-auto">
                                            <div class="page-header-title">
                                                <h4 class="m-b-10">
                                                    @yield('page-title')
                                                </h4>
                                            </div>
                                        </div> --}}

                                        @error('message')
                                                <div class="col-12">
                                                    <div class="alert alert-danger background-danger" role="alert">
                                                        Las contraseñas no coinciden
                                                    </div>
                                                </div>
                                            
                                            
                                        @enderror
                                        @error('success')
                                                <div class="col-12">
                                                    <div class="alert alert-success background-success" role="alert">
                                                        Se cambio la contraseña correctamente
                                                    </div>
                                                </div>
                                            
                                            
                                        @enderror
                                        
                                        <div class="col-12 mb-3 d-block d-sm-none">
                                             <div class="row d-flex justify-content-center" style="margin-top: -15px">
                                                <div class="col-10 col-md-4  mb-2">
                                                     <form action="{{ route('buscarDocumento') }}" method="POST">
                                                        <div class="  input-group input-group-sm  input-group-info position-relative" style="top:10px;font-size: 10px !important">
                                                
                                                            @csrf
                                                            <input required="required" autocomplete="off" type="search" name="nroDocumento" id="inputSearch" placeholder="N° de Registro" class="form-control format-numero" style="padding: 0.25rem 0.5rem !important;"> 
                                                            <div class="input-group-append">
                                                                <button type="submit" class="btn  btn-info" ><i class="fas fa-file-search mr-2"></i>Buscar</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="col-12 col-md-auto text-right">
                                            @yield('headerButtons')
                                            <!-- HEADER BUTTONS -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- [ breadcrumb ] end -->
                            <div class="pcoded-inner-content">
                                <!-- Main-body start -->
                                <div class="main-body">
                                    <div class="page-wrapper">
                                        <!-- Page body start -->
                                        <div class="page-body">

                                            @yield('content')
                                        </div>
                                        <!-- Page body end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Required Jquery -->
        <script type="text/javascript" src="{{ asset('components/jquery/js/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('components/jquery-ui/js/jquery-ui.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('components/popper.js/js/popper.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('components/bootstrap/js/bootstrap.min.js')}}"></script>
        <!-- waves js -->
        <script src="{{ asset('assets/pages/waves/js/waves.min.js')}}"></script>
        <!-- jquery slimscroll js -->
        <script type="text/javascript" src="{{ asset('components/jquery-slimscroll/js/jquery.slimscroll.js')}}"></script>
        <!-- modernizr js -->
        <script type="text/javascript" src="{{ asset('components/modernizr/js/modernizr.js')}}"></script>
        <script type="text/javascript" src="{{ asset('components/modernizr/js/css-scrollbars.js')}}"></script>
        <!-- waves js -->
        <script src="{{ asset('assets/pages/waves/js/waves.min.js')}}"></script>
        <!-- i18next.min.js -->
        <script type="text/javascript" src="{{ asset('components/i18next/js/i18next.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('components/i18next-xhr-backend/js/i18nextXHRBackend.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('components/jquery-i18next/js/jquery-i18next.min.js')}}"></script>
        <!-- Custom js -->
        <script type="text/javascript" src="{{ asset('assets/js/script.js')}}"></script>
        <script src="{{ asset('assets/js/pcoded.min.js')}}"></script>
        <script src="{{ asset('assets/js/vertical/vertical-layout.min.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
        <script src="{{ asset('components/toastjq/js/jquery.toast.js') }}"></script>

        <script type="text/javascript" src="{{ asset('assets/js/script.js')}}"></script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>

        {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> --}}

        {{-- <script type="text/javascript" src="{{ asset('js/app.js') }}"></script> --}}
        <script src="{{ mix('/js/app.js') }}"></script>
        @yield('scripts')
    <script>
    $('#fileup').change(function(){
        //here we take the file extension and set an array of valid extensions
        var res=$('#fileup').val();
        var arr = res.split("\\");
        var filename=arr.slice(-1)[0];
        filextension=filename.split(".");
        filext="."+filextension.slice(-1)[0];
        valid=[".pdf"];
        //if file is not valid we show the error icon, the red alert, and hide the submit button
        if (valid.indexOf(filext.toLowerCase())==-1){
            $( ".imgupload" ).hide("slow");
            $( ".imgupload.ok" ).hide("slow");
            $( ".imgupload.stop" ).show("slow");

            $('#namefile').css({"color":"red","font-weight":700});
            $('#namefile').html("El archivo "+filename+" no es correcto");

            $( "#submitbtn" ).hide();
            $( "#fakebtn" ).show();
        } else {
            //if file is valid we show the green alert and show the valid submit
            $(".imgupload" ).hide("slow");
            $(".imgupload.stop" ).hide("slow");
            $(".imgupload.ok" ).show("slow");

            $('#namefile').css({"color":"green","font-weight":700});
            $('#namefile').html(filename);

            $("#submitbtn" ).show();
            $("#fakebtn" ).hide();
        }
    });
        </script>
        @if(session()->has('message'))
            <script>
                Swal.fire({ icon: 'success', title: 'Bien', text: 'El Proceso se realizo correctamente' })
            </script>
        @endif
    </body>
</html>
