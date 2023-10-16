<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Sistema de Tramite Documentario |  Municipalidad Distrital de Secclla - Huancavelica</title>
        <!--[if lt IE 10]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="Description" content="Sistema de Tramite Documentario | Municipalidad Distrital de Secclla - Huancavelica | SofticsLab - construimos y desarrollamos experiencias digitales">
        {{-- <meta name="user" content="{{ Auth::user()->load('dependencia')}}"> --}}
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
        <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
        
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
        <link rel="stylesheet" type="text/css" href="{{ asset('css/add-styles.css') }}">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"> --}}
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        <style>
            .pcoded .pcoded-header[header-theme="theme1"] {
                padding: 10px !important;
            }
        </style>
        @yield('styles')
    </head>
    <body themebg-pattern="theme1">

        <!-- [ Pre-loader ] start -->
        <div class="loader-bg">
            <div class="loader-bar"></div>
        </div>
        <!-- [ Pre-loader ] end -->
        <div id="pcoded" class="pcoded">
            <div class="pcoded-overlay-box"></div>
            <div class="pcoded-container navbar-wrapper ">
                <div class="row d-none d-print-block  p-2">
                    <div class="col-12 d-flex justify-content-between pb-1" style="border-bottom: 1px solid #e6e6e6">
                        <img class="logo-login" src="{{ asset('images/logo-munisecclla-tramite-virtual.png') }}" alt="" height="55" >

                        <div class="text-right" style="width: 250px" >
                            <div class="float-left">
                                @isset ($imageQR)
                                    <img src="data:image/png;base64, {!! $imageQR !!}  " height="65px">
                                @endisset
                                
                            </div>
                            <div class="float-right">
                                <span class="d-block p-1 font-weight-bold">
                                    Fecha de Impresión
                                </span>
                                <span>{{ date('d-m-Y H:i:s') }}</span>
                            </div>
                                
                         </div>
                    </div>
                </div>
                <nav class="navbar header-navbar pcoded-header navbar-fixed-add iscollapsed hidden-print {{ Auth::id() ? 'd-none':'' }} " >
                    <div class="container ">
                        <div class="navbar-wrapper">
                            <div class="navbar-logo">
                                <a href="{{ route('home') }}">
                                     <img class="logo-login" src="{{ asset('images/logo-munisecclla-tramite-virtual.png') }}" alt="" >
                                 </a> 
                            </div>
                        </div>
                        <div class="nav-right  ">
                            <div class="btn-group">
                                <button type="button" class="btn   btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-th-large mr-2"></i>
                                    <span class="d-none d-md-inline">Opciones</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right1">
                                    <a href="/login" class="dropdown-item">
                                        <i class="fas fa-user-unlock mr-2"></i>
                                        Ingresar al Sistema
                                    </a>
                                    <a href="/consultar/documento" class="dropdown-item" type="button">
                                        <i class="fas fa-file-search mr-2"></i>
                                        Buscar Trámite
                                    </a>
                                    <a href="/tramite/virtual" class="dropdown-item" type="button">
                                        <i class="fas fa-file-plus mr-2"></i>
                                        Nuevo tramite
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            
            <div class="pcoded-inner-content1" style="margin-top: {{ Auth::id()? '0px' :'80px'}}">
                <!-- Main-body start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- Page body start -->
                        <div class="page-body">
                            {{-- <div class="container-fluid " style="max-width: 1200px; margin-top: 0px!important;">
                                <div class="row justify-content-center my-2">
                                    <div class="col-sm-12 col-md-9">
                                        <div class="row justify-content-between">
                                            <div class="col-12 col-md-4">
                                                <a href="{{ route('tramite.virtual') }}" class="btn btn-success btn-lg btn-block">
                                                    <i class="fas fa-file-plus mr-2"></i>
                                                    Nuevo Trámite
                                                </a>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <a href="{{ route('tramite.virtual') }}" class="btn btn-secondary btn-lg btn-block">
                                                    <i class="fas fa-file-plus mr-2"></i>
                                                    Buscar Trámite
                                                </a>
                                            </div>
                                            
                                        </div>
                                    </div>    
                                </div>
                            </div> --}}
                                
                            @yield('content')
                        </div>
                        <!-- Page body end -->
                    </div>
                </div>
            </div>


        </div>

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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> --}}

        <script type="text/javascript" src="{{ asset('js-virtual/app.js')}}"></script>
        {{-- <script src="https://unpkg.com/aos@next/dist/aos.js"></script> --}}
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
    }else{
        //if file is valid we show the green alert and show the valid submit
        $( ".imgupload" ).hide("slow");
        $( ".imgupload.stop" ).hide("slow");
        $( ".imgupload.ok" ).show("slow");
      
        $('#namefile').css({"color":"green","font-weight":700});
        $('#namefile').html(filename);
      
        $( "#submitbtn" ).show();
        $( "#fakebtn" ).hide();
    }
});
        </script>
        @yield('scriptsJs')
    </body>
</html>
