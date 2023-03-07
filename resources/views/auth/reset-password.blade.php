<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Restaurar Contraseña - Sistema Licitaciones</title>
    <meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free.">
    <meta name="keywords" content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="article">
    <meta property="og:title" content="Servicios Industriales">
    <meta property="og:url" content="https://mackservicios.cl">
    <meta property="og:site_name" content="Mack Servicios">
    <link rel="shortcut icon" href="{{ url('extras/images/logomack.png') }}">
    <link rel="stylesheet" href="{{ url('extras/css/css') }}">
    <link href="{{ url('extras/css/plugins.bundle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('extras/css/style.bundle.css') }}" rel="stylesheet" type="text/css">
    <script type="text/javascript" async="" src="{{ url('extras/f.txt') }}"></script>
    <script type="text/javascript" async="" src="{{ url('extras/js/analytics.js') }}"></script>
    <script type="text/javascript" async="" src="{{ url('extras/js/js') }}"></script>
    <script async="" src="{{ url('extras/js/gtm.js') }}"></script>
    <script type="text/javascript" async="" src="{{ url('extras/f(1).txt') }}"></script>
    <script type="text/javascript" async="" src="{{ url('extras/f(2).txt') }}"></script>
</head>
<body id="kt_body" class="bg-body">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url({{ url('extras/images/14.png') }}">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <a href="{{ url('/') }}" class="mb-12">
                    <img alt="Logo" src="{{ url('extras/images/logomack.png') }}" class="h-40px">
                </a>
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="text-center mb-10">
                            <h1 class="text-dark mb-3">Restaurar Contraseña Sistema Licitaciones</h1>
                        </div>
                        <div class="fv-row mb-10 fv-plugins-icon-container">
                            <label class="form-label fs-6 fw-bolder text-dark" for="email">Email</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <div class="fv-row mb-10 fv-plugins-icon-container">
                            <label class="form-label fs-6 fw-bolder text-dark" for="password">Contraseña</label>
                            <input class="form-control form-control-lg form-control-solid" type="password" id="password" name="password" required>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <div class="fv-row mb-10 fv-plugins-icon-container">
                            <label class="form-label fs-6 fw-bolder text-dark" for="password_confirmation">Confirmar Contraseña</label>
                            <input class="form-control form-control-lg form-control-solid" type="password" id="password_confirmation" name="password_confirmation" required>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <div class="text-center">
                            <x-button>
                                {{ __('Restaurar Contraseña') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var hostUrl = "{{ url('/') }}";
    </script>
    <script src="{{ url('extras/js/plugins.bundle.js') }}"></script>
    <script src="{{ url('extras/js/scripts.bundle.js') }}"></script>
    <script src="{{ url('extras/js/general.js') }}"></script>
</body>

</html>