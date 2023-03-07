<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Mack Servicios - Sistema Licitaciones</title>
        @include('partials.head')
    </head>
    <body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                @include('partials.basemenu')
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    @include('partials.header')
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <div class="toolbar" id="kt_toolbar">
                            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: &#39;#kt_content_container&#39;, &#39;lg&#39;: &#39;#kt_toolbar_container&#39;}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                    @yield('contentHeader')
                                </div>
                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                </div>
                            </div>
                        </div>
                        @if(Session::has('msj'))
                            <script type="text/javascript">
                                $.notify({icon: "add_alert", message: '<?php echo Session::get('msj')?>'},{type: 'info', timer: 1000})
                            </script>
                        @endif
                        @if(Session::has('msjError'))
                            <script type="text/javascript">
                                $.notify({icon: "add_alert", message: '<?php echo Session::get('msjError')?>'},{type: 'danger', timer: 1000})
                            </script>
                        @endif
                        @if(Session::has('msjAlert'))
                            <script type="text/javascript">
                                $.notify({icon: "add_alert", message: '<?php echo Session::get('msjAlert')?>'},{type: 'warning', timer: 1000})
                            </script>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            @yield('content')
                        </div>
                    </div>
                    @include('partials.footer')
                </div>
            </div>
        </div>
        <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
            <span class="svg-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor"></rect>
                    <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor"></path>
                </svg>
            </span>
        </div>

        <div class="modal fade" id="ModalDetalle" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div id="bodyModalDetalle">
                    </div>
                </div>
            </div>
        </div>

        @include('partials.javascript')
        @yield('javascript')
        <svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
            <defs id="SvgjsDefs1002"></defs>
            <polyline id="SvgjsPolyline1003" points="0,0"></polyline>
            <path id="SvgjsPath1004" d="M-1 150L-1 150C-1 150 64.8 150 64.8 150C64.8 150 129.6 150 129.6 150C129.6 150 194.4 150 194.4 150C194.4 150 259.2 150 259.2 150C259.2 150 324 150 324 150C324 150 324 150 324 150 "></path>
        </svg>
    </body>
</html>