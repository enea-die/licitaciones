<script>
    var baseurl = "{!! url('/') !!}/";
    var urlpagina1 = "{!! Request::segment(1) !!}";
    var urlpagina2 = "{!! Request::segment(2) !!}";
    var urlpagina3 = "{!! Request::segment(3) !!}";

    function returnHome() {
        window.location.href = baseurl;
    }

    function viewConfiguracionGeneral() {
        window.location.href = baseurl+'configuraciones';
    }
</script>
<script src="{{ url('extras/js/plugins.bundle.js') }}"></script>
<script src="{{ url('extras/js/scripts.bundle.js') }}"></script>
<script src="{{ url('extras/js/fullcalendar.bundle.js') }}"></script>
<script src="{{ url('extras/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('extras/js/widgets.bundle.js') }}"></script>
<script src="{{ url('extras/js/widgets.js') }}"></script>
<script src="{{ url('extras/js/intro.js') }}"></script>
<script src="{{ url('extras/js/upgrade-plan.js') }}"></script>
<script src="{{ url('extras/js/create-app.js') }}"></script>
<script src="{{ url('extras/js/users-search.js') }}"></script>
<script src="{{ url('extras/js/tableExporter.js') }}"></script>
<script src="{{ url('extras/js/bootstrap-notify.js') }}"></script>
<script src="{{ url('extras/select2/js/select2.min.js') }}"></script>
<script src="{{ url('extras/js/echarts.min.js') }}"></script>
<script>
    $('.select2').select2();

    function modalSolicitudNoParticipacion(id){
        var href = baseurl+'modal-no-participar-etapa-uno/'+id;
        $('#bodyModalDetalle').load(href,function(){
            $('#ModalDetalle').modal('toggle');
        });
    }

    function modalResponderSolicitudParticipacion(id){
        var href = baseurl+'modal-responder-solicitud-participar-etapa-uno/'+id;
        $('#bodyModalDetalle').load(href,function(){
            $('#ModalDetalle').modal('toggle');
        });
    }

    function modalAprobarEtapaUno(id){
        var href = baseurl+'modal-aprobar-etapa-uno/'+id;
        $('#bodyModalDetalle').load(href,function(){
            $('#ModalDetalle').modal('toggle');
        });
    }

    function modalAsignarResponsable(id){
        var href = baseurl+'modal-asignar-responsable/'+id;
        $('#bodyModalDetalle').load(href,function(){
            $('#ModalDetalle').modal('toggle');
        });
    }

    function modalPendienteVisita(id){
        var href = baseurl+'modal-gestionar-visita/'+id;
        $('#bodyModalDetalle').load(href,function(){
            $('#ModalDetalle').modal('toggle');
        });
    }

    function modalResponderSolicitudDardeBaja(id){
        var href = baseurl+'modal-responder-solicitud-dar-de-baja/'+id;
        $('#bodyModalDetalle').load(href,function(){
            $('#ModalDetalle').modal('toggle');
        });
    }

    function modalResponderSolicitudRevisionCotizacion(id){
        var href = baseurl+'modal-responder-solicitud-revision-cotizacion/'+id;
        $('#bodyModalDetalle').load(href,function(){
            $('#ModalDetalle').modal('toggle');
        });
    }

    function modalAddPlanta(){
        $("#modalAddPlanta").modal('toggle');
    }

    function modalAddAreaPlanta(idplanta){
        $("#idplantaAddArea").val(idplanta);
        $("#modalAddArea").modal('toggle');
    }

    function modalEditAreaPlanta(idplanta, idarea){
        $("#idplantaEditArea").val(idplanta);
        $("#idareaEditArea").val(idarea);
        $("#modalEditArea").modal('toggle');

        $.ajax({
            url: baseurl+'get-area/'+idarea,
            method: 'GET',
            success: function(data) {
                if(data.status == 'success'){
                    //actualizar el nombre de sucursal seleccionado y el active en el topbar
                    $("#Editareaplanta").val(data.area.nombre);
                    $("#Editareacontacto").val(data.area.contacto);
                    $("#Editareatelefono").val(data.area.telefono);
                }else{
                    $.notify({icon: "add_alert", message: 'Ocurrio un error al procesar la solicitud, favor intente nuevamente!'},{type: 'warning', timer: 1000})
                }
            },
            error:function(data){
                var error = data.responseJSON.errors;
                for(var i in error){
                    for(var j in error[i]){
                        var message = error[i][j];
                        $.notify({icon: "add_alert", message: message},{type: 'warning', timer: 1000})
                    }
                }
            }
        });
    }

    function modalAddPGPEmpresa(){
        $("#modalAddPGP").modal('toggle');
    }

    /*
    function modalInformacionnTecnica(id){
        var href = baseurl+'modal-ingresar-informacion-tecnica/'+id;
        $('#bodyModalDetalle').load(href,function(){
            $('#ModalDetalle').modal('toggle');
        });
    }
    */

    $('select#empresalicitacion').on('change',function(){
        var get_valor = $(this).val();

        if(get_valor == ""){
            var valor = 0;
        }else{
            var valor = get_valor;
        }

        $.get(baseurl+"get-plantas-empresa/"+valor, function(response1, id) {
            $("#plantalicitacion").empty()
            $("#arealicitacion").empty()
            $("#plantalicitacion").append("<option value='' selected>Seleccione...</option>")
            $("#arealicitacion").append("<option value='' selected>Seleccione...</option>")

            if (response1 == "") {
                $('.plantalicitacion').select('refresh')
                $('.arealicitacion').select('refresh')
            }else{
                for(i = 0; i <response1.length; i++) {
                    $("#plantalicitacion").append("<option value='"+response1[i].id+"'>"+response1[i].nombre+"</option>")
                    $('.plantalicitacion').select('refresh')
                }
                $('#plantalicitacion').val(id)
                $('.plantalicitacion').select('refresh')
            }
        });

        if(valor != 0){
            //consultar si esta seleccionado PGP
            var valortipolicit = $("#tipolicitacion").val();

            if(valortipolicit == 4){
                $("#divpgpempresa").css('display','block');
                cargarPGPempresa(valor);
            }else{
                $("#divpgpempresa").css('display','none');
            }
        }else{
            $("#divpgpempresa").css('display','none');
        }
    });

    $('select#plantalicitacion').on('change',function(){
        var get_valor = $(this).val();

        if(get_valor == ""){
            var valor = 0;
        }else{
            var valor = get_valor;
        }

        $.get(baseurl+"get-areas-planta/"+valor, function(response1, id) {
            $("#arealicitacion").empty()
            $("#arealicitacion").append("<option value='' selected>Seleccione...</option>")

            if (response1 == "") {
                $('.arealicitacion').select('refresh')
            }else{
                for(i = 0; i <response1.length; i++) {
                    $("#arealicitacion").append("<option value='"+response1[i].id+"'>"+response1[i].nombre+"</option>")
                    $('.arealicitacion').select('refresh')
                }
                $('#arealicitacion').val(id)
                $('.arealicitacion').select('refresh')
            }
        });
    });

    $('select#tipolicitacion').on('change',function(){
        var get_valor = $(this).val();

        if(get_valor == ""){
            var valor = 0;
        }else{
            var valor = get_valor;
        }

        if(valor == 4){
            //si es PGP
            var valorempresa = $("#empresalicitacion").val();
            if(valorempresa != ''){
                //si seleccionaron empresa
                $("#divpgpempresa").css('display','block');
                cargarPGPempresa(valorempresa);
            }else{
                $.notify({icon: "add_alert", message: 'Deben seleccionar un empresa, para cargar sus PGP!'},{type: 'warning', timer: 1000})
            }
        }else{
            $("#divpgpempresa").css('display','none');
        }
    });

    function cargarPGPempresa(idempresa){
        $.get(baseurl+"get-pgp-empresa/"+idempresa, function(response1, id) {
            $("#pgplicitacion").empty()
            $("#pgplicitacion").append("<option value='' selected>Seleccione...</option>")

            if (response1 == "") {
                $('.pgplicitacion').select('refresh')
            }else{
                for(i = 0; i <response1.length; i++) {
                    $("#pgplicitacion").append("<option value='"+response1[i].id+"'>"+response1[i].nombre+"</option>")
                    $('.pgplicitacion').select('refresh')
                }
                $('#pgplicitacion').val(id)
                $('.pgplicitacion').select('refresh')
            }
        });
    }

</script>
