function solo_numeros(e)
{
    var tecla = (document.all) ? event.keyCode : e.which;
    if (tecla == 8)
        return true;

    var patron = /^[0-9]+$/;
    var te = String.fromCharCode(tecla);

    if (!patron.test(te) && tecla == 0) {
        return true;
    }

    return patron.test(te);
}

function checkValorNumerico(valor, input)
{
    var options = { style: 'currency', currency: 'clp', minimumFractionDigits: 0, maximumFractionDigits: 0 };
    var formatter = new Intl.NumberFormat(options);
    var invertido = formatter.format(valor);
    document.getElementById(input).value = invertido;
}

function limpiaPuntoGuionItemSPOM(valorarray)
{
    var valoractual = $('#montoitem'+valorarray).val();

    if(valoractual != '' && valoractual != 'NaN'){
        var valornuevo = valoractual.replace(/\,/g, '');
        var valornuevo2 = valornuevo.replace(/\./g, '');
        $('#montoitem'+valorarray).val(valornuevo2);
    }else{
        $('#montoitem'+valorarray).val(0);
    }
}

function checkValorNumericoFactItemSPOM(valorarray)
{
    var valor = document.getElementById('montoitem'+valorarray).value;
    var options = { style: 'currency', currency: 'clp', minimumFractionDigits: 0, maximumFractionDigits: 0 };
    var formatter = new Intl.NumberFormat(options);
    var invertido = formatter.format(valor);
    document.getElementById('montoitem'+valorarray).value = invertido;
}

//items comparativos
function numericosAlCargarCotizacion()
{
    var etapaactual = $("#idetapa").val();
    var idtipolicitacion = $("#idtipolicitacion").val();
    if(idtipolicitacion == 3){
        if (etapaactual == 7 || etapaactual == 10 || etapaactual == 13) {
            var valorcotizacion = $('#valorcotizacion').val().replaceAll(".", "");
            var ic_montomargen = $('#ic_montomargen').val().replaceAll(".", "");
            var montomaterial = $('#ic_montomaterial').val().replaceAll(".", "");
            var montopersonal = $('#ic_montopersonal').val().replaceAll(".", "");
            var montoequipos = $('#ic_montoequipos').val().replaceAll(".", "");

            checkValorNumerico(valorcotizacion, 'valorcotizacion');
            checkValorNumerico(valorcotizacion, 'valorcotizacion');
            checkValorNumerico(montomaterial, 'ic_montomaterial');
            checkValorNumerico(montopersonal, 'ic_montopersonal');
            checkValorNumerico(montoequipos, 'ic_montoequipos');
            checkValorNumerico(ic_montomargen, 'ic_montomargen');
        }
    }
}

function calcularcotizacionmack()
{
    var options1 = {style: 'currency', currency: 'clp', minimumFractionDigits: 0, maximumFractionDigits: 0};
    var formatter1 = new Intl.NumberFormat(options1);

    var idtipolicitacion = $("#idtipolicitacion").val();

    if(idtipolicitacion == 3){
        //si es SPOT
        var montomaterial = $('#ic_montomaterial').val().replaceAll(".", "");
        var montopersonal = $('#ic_montopersonal').val().replaceAll(".", "");
        var montoequipos = $('#ic_montoequipos').val().replaceAll(".", "");

        if(montomaterial >= 0 && montopersonal >= 0 && montoequipos >= 0 && $.isNumeric(montomaterial) && $.isNumeric(montopersonal) && $.isNumeric(montoequipos)){
            //calculo utilidad
            var getmontoutilidad = (parseInt(montomaterial) + parseInt(montopersonal) + parseInt(montoequipos)) * 0.25;
            var montoutilidad = getmontoutilidad.toFixed(0);
            var montoutilidad_invertido = formatter1.format(montoutilidad);

            $('#ic_ggutilidad').val(montoutilidad);
            $('#ic_ggutilidaddisabled').val(montoutilidad_invertido);
            $('#ic_ggutilidaddisableddiv').html('$'+montoutilidad_invertido);

            //calculo total neto
            var getmontototalneto = parseInt(montomaterial) + parseInt(montopersonal) + parseInt(montoequipos) + parseInt(montoutilidad);
            var montototalneto = getmontototalneto.toFixed(0);
            var montototalneto_invertido = formatter1.format(montototalneto);

            $('#ic_totalneto').val(montototalneto);
            $('#ic_totalnetodisabled').val(montototalneto_invertido);
            $('#ic_totalnetodisableddiv').html('$'+montototalneto_invertido);

        }else{
            $('#ic_ggutilidad').val(0);
            $('#ic_ggutilidaddisabled').val(0);
            $('#ic_ggutilidaddisableddiv').html('$0');
            $('#ic_totalneto').val(0);
            $('#ic_totalnetodisabled').val(0);
            $('#ic_totalnetodisableddiv').html('$0');
        }
    }else if(idtipolicitacion == 4){
        //si es PGP
        var cottotalesvalortotalescotizacion = 0;
        var cottotalvalorpersonal = 0;
        var cottotalvalormaterial = 0;
        var cottotalvalorequipos = 0;
        var cottotalvalorutilidad = 0;
        var cottotalvalortotalneto = 0;
        var cottotalvalormargen = 0;

        //recorrer cada fila
        $("input[name='fila_cotizacion[]']").each(function(indice, elemento) {
            var valorindice = $(elemento).val();

            var valortotal = $('#cot_valor_total'+valorindice).val().replaceAll(".", "");
            var montomaterial = $('#cot_ic_montomaterial'+valorindice).val().replaceAll(".", "");
            var montopersonal = $('#cot_ic_montopersonal'+valorindice).val().replaceAll(".", "");
            var montoequipos = $('#cot_ic_montoequipos'+valorindice).val().replaceAll(".", "");
            var montomargen = $('#cot_ic_montomargen'+valorindice).val().replaceAll(".", "");

            if(montomaterial >= 0 && montopersonal >= 0 && montoequipos >= 0 && $.isNumeric(montomaterial) && $.isNumeric(montopersonal) && $.isNumeric(montoequipos)){
                //calculo utilidad
                var getmontoutilidad = (parseInt(montomaterial) + parseInt(montopersonal) + parseInt(montoequipos)) * 0.25;
                var montoutilidad = getmontoutilidad.toFixed(0);
                var montoutilidad_invertido = formatter1.format(montoutilidad);

                $('#cot_ic_ggutilidad'+valorindice).val(montoutilidad);
                $('#cot_ic_ggutilidaddisabled'+valorindice).val(montoutilidad_invertido);
                $('#ic_ggutilidaddisableddiv'+valorindice).html('$'+montoutilidad_invertido);
    
                //calculo total neto
                var getmontototalneto = parseInt(montomaterial) + parseInt(montopersonal) + parseInt(montoequipos) + parseInt(montoutilidad);
                var montototalneto = getmontototalneto.toFixed(0);
                var montototalneto_invertido = formatter1.format(montototalneto);
    
                $('#cot_ic_totalneto'+valorindice).val(montototalneto);
                $('#cot_ic_totalnetodisabled'+valorindice).val(montototalneto_invertido);
                $('#ic_totalnetodisableddiv'+valorindice).html('$'+montototalneto_invertido);


                cottotalesvalortotalescotizacion += parseInt(valortotal);
                cottotalvalorpersonal += parseInt(montopersonal);
                cottotalvalormaterial += parseInt(montomaterial);
                cottotalvalorequipos += parseInt(montoequipos);
                cottotalvalorutilidad += parseInt(montoutilidad);
                cottotalvalortotalneto += parseInt(montototalneto);
                cottotalvalormargen += parseInt(montomargen);
    
            }else{
                $('#cot_ic_ggutilidaddisabled'+valorindice).val(0);
                $('#cot_ic_ggutilidad'+valorindice).val(0);
                $('#ic_ggutilidaddisableddiv'+valorindice).html('$0');
                $('#cot_ic_totalneto'+valorindice).val(0);
                $('#cot_ic_totalnetodisabled'+valorindice).val(0);
                $('#ic_totalnetodisableddiv'+valorindice).html('$0');
            }
        });

        //recorrer filas que no estan editables
        $("input[name='fila_cotizacion_noeditable[]']").each(function(indice, elemento) {
            var valorindice = $(elemento).val();

            console.log(valorindice)

            var getvalortotal = $('#cot_valor_total'+valorindice).val().replaceAll(".", "");
            var valortotal = getvalortotal.replaceAll("$", "");
            var getmontomaterial = $('#cot_ic_montomaterial'+valorindice).val().replaceAll(".", "");
            var montomaterial = getmontomaterial.replaceAll("$", "");
            var getmontopersonal = $('#cot_ic_montopersonal'+valorindice).val().replaceAll(".", "");
            var montopersonal = getmontopersonal.replaceAll("$", "");
            var getmontoequipos = $('#cot_ic_montoequipos'+valorindice).val().replaceAll(".", "");
            var montoequipos = getmontoequipos.replaceAll("$", "");
            var getmontomargen = $('#cot_ic_montomargen'+valorindice).val().replaceAll(".", "");
            var montomargen = getmontomargen.replaceAll("$", "");

            var getmontoutilidad = (parseInt(montomaterial) + parseInt(montopersonal) + parseInt(montoequipos)) * 0.25;
            var montoutilidad = getmontoutilidad.toFixed(0);

            //calculo total neto
            var getmontototalneto = parseInt(montomaterial) + parseInt(montopersonal) + parseInt(montoequipos) + parseInt(montoutilidad);
            var montototalneto = getmontototalneto.toFixed(0);

            cottotalesvalortotalescotizacion += parseInt(valortotal);
            cottotalvalorpersonal += parseInt(montopersonal);
            cottotalvalormaterial += parseInt(montomaterial);
            cottotalvalorequipos += parseInt(montoequipos);
            cottotalvalorutilidad += parseInt(montoutilidad);
            cottotalvalortotalneto += parseInt(montototalneto);
            cottotalvalormargen += parseInt(montomargen);
        });

        var cottotalesvalortotalescotizacion_invertido = formatter1.format(cottotalesvalortotalescotizacion);
        var cottotalvalorpersonal_invertido = formatter1.format(cottotalvalorpersonal);
        var cottotalvalormaterial_invertido = formatter1.format(cottotalvalormaterial);
        var cottotalvalorequipos_invertido = formatter1.format(cottotalvalorequipos);
        var cottotalvalorutilidad_invertido = formatter1.format(cottotalvalorutilidad);
        var cottotalvalortotalneto_invertido = formatter1.format(cottotalvalortotalneto);
        var cottotalvalormargen_invertido = formatter1.format(cottotalvalormargen);

        $("#cottotalesvalortotalescotizacion").val(cottotalesvalortotalescotizacion_invertido);
        $("#cottotalvalorpersonal").val(cottotalvalorpersonal_invertido);
        $("#cottotalvalormaterial").val(cottotalvalormaterial_invertido);
        $("#cottotalvalorequipos").val(cottotalvalorequipos_invertido);
        $("#cottotalvalorutilidad").val(cottotalvalorutilidad_invertido);
        $("#cottotalvalortotalneto").val(cottotalvalortotalneto_invertido);
        $("#cottotalvalormargen").val(cottotalvalormargen_invertido);

    }
}

function validarvalorcotizacionspot(evento)
{
    evento.preventDefault();

    var valorcotizacion = $("#valorcotizacion").val().replaceAll(".", "");;
    var ic_totalneto = $("#ic_totalneto").val().replaceAll(".", "");;

    if(parseInt(valorcotizacion) == parseInt(ic_totalneto)){
        this.submit();
    }else{
        $.notify({icon: "add_alert", message: 'El valor de la cotización no coincide con el valor neto, favor verificar'},{type: 'danger', timer: 1000})

        return;
    }
}

//etapa servicios finalizados - item sp/om
function modalAdjuntarInformeTecnicoItemSPOM(iditem,isadic)
{
    $("#spom_idregistroitem").val(iditem);
    $("#spom_istrabajoadicional").val(isadic);
    $("#modalAdjuntarInformeTecnicoSPOM").modal('toggle');
}

function modalIngresarHASItemSPOM(iditem,isadic)
{
    $("#spom_idregistroitem2").val(iditem);
    $("#spom_istrabajoadicional2").val(isadic);
    $("#modalIngresarHASSPOM").modal('toggle');
}

function modalIngresarFacturaItemSPOM(iditem,isadic)
{
    $("#spom_idregistroitem3").val(iditem);
    $("#spom_istrabajoadicional3").val(isadic);
    $("#modalIngresarFacturaHASSPOM").modal('toggle');
}

function limpiaPuntoGuion(input){
	var obj;
	obj = document.getElementById(input).value;
	obj = obj.replaceAll("NaN","");
	obj = obj.replaceAll(".","");
	obj = obj.replaceAll(",","");
	obj = obj.replace(/-/,"");
	document.getElementById(input).value = obj;
}

function respuestacotizacionjefecomercial(valor)
{
    if(valor == 2)
    {
        $("#divobservacionesnojefecomercial").css('display','block');
    }else{
        $("#divobservacionesnojefecomercial").css('display','none');
    }
}

function respuestacotizacionjefeoperaciones(valor)
{
    if(valor == 2)
    {
        $("#divobservacionesnojefeoperaciones").css('display','block');
    }else{
        $("#divobservacionesnojefeoperaciones").css('display','none');
    }
}

//PGP
function modalAdjuntarInformeTecnicoItemSPOMPGP(iditem)
{
    $("#spom_idregistrocotizPGP").val(iditem);
    $("#modalAdjuntarInformeTecnicoSPOMPGP").modal('toggle');
}

function modalIngresarHASItemSPOMPGP(iditem)
{
    $("#spom_idregistroitem2PGP").val(iditem);
    $("#modalIngresarHASSPOMPGP").modal('toggle');
}

function modalIngresarFacturaItemSPOMPGP(iditem)
{
    $("#spom_idregistroitem3PGP").val(iditem);
    $("#modalIngresarFacturaHASSPOMPGP").modal('toggle');
}

function volveraevaluarcotizacion(index)
{
    // @ts-ignore
    var formData = new FormData($("#formCotizacionPGP").get(0));
    formData.append('index', index);

    $.ajax({
        url: baseurl+'volver-a-enviar-cotizacion-pgp',
        type: 'post',
        async: false,
        cache:false,
        contentType: false,
        processData: false,
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: formData,
        beforeSend: function () {
            $.notify({icon: "add_alert", message: 'Procesando el registro de la cotización, favor espere'},{type: 'info', timer: 1000})
        },
        success: function(data) {
            if(data.estado == "success"){
                toastr.info("Cotización enviada a evaluación exitosamente");
                location.reload();
            }else{
                toastr.error("Ocurrio un error interno al procesar la solicitud, favor intentar nuevamente");
            }
        }
    });
}

//ingresar informe KPI del servicio
function calcularinformekpiservicio()
{
    var options1 = {style: 'currency', currency: 'clp', minimumFractionDigits: 0, maximumFractionDigits: 0};
    var formatter1 = new Intl.NumberFormat(options1);

    var facturado_total_proyecto = $('#facturado_total_proyecto').val().replaceAll(".", "");
    var costo_mano_obra = $('#costo_mano_obra').val().replaceAll(".", "");
    var costo_directo_obra = $('#costo_directo_obra').val().replaceAll(".", "");

    if(facturado_total_proyecto > 0 && costo_mano_obra > 0 && costo_directo_obra > 0 && facturado_total_proyecto != "" && costo_mano_obra != "" && costo_directo_obra != "" && $.isNumeric(facturado_total_proyecto) && $.isNumeric(costo_mano_obra) && $.isNumeric(costo_directo_obra)){
        //calcular porcentaje costo mano obra
        var getporcentajecostomanoobra = (parseInt(costo_mano_obra) / parseInt(facturado_total_proyecto)) * 100;
        var porcentajecostomanoobra = getporcentajecostomanoobra.toFixed(1);
        $('#porcentajecmo').val(porcentajecostomanoobra);
        $("#labelporcentajecmo").html(porcentajecostomanoobra+"%");

        //calcular porcentaje costo directo obra
        var getporcentajecostodirectoobra = (parseInt(costo_directo_obra) / parseInt(facturado_total_proyecto)) * 100;
        var porcentajecostodirectoobra = getporcentajecostodirectoobra.toFixed(1);
        $('#porcentajecostodirectoobra').val(porcentajecostodirectoobra);
        $("#labelporcentajecostodirectoobra").html(porcentajecostodirectoobra+"%")

        //calcular costo total proyecto
        var costototalproyecto = parseInt(costo_mano_obra) + parseInt(costo_directo_obra);
        var costototalproyecto_invertido = formatter1.format(costototalproyecto);
        $('#costototalproyecto').val(costototalproyecto);
        $("#labelcostototalproyecto").html("$"+costototalproyecto_invertido)

        //calcular porcentaje costo total proyecto
        var getporcentajecostototalproyecto = (parseInt(costototalproyecto) / parseInt(facturado_total_proyecto)) * 100;
        var porcentajecostototalproyecto = getporcentajecostototalproyecto.toFixed(1);
        $('#porcentajecostototalproyecto').val(porcentajecostototalproyecto);
        $("#labelporcentajecostototalproyecto").html(porcentajecostototalproyecto+"%")

    }else{
        $('#porcentajecmo').val(0);
        $('#labelporcentajecmo').html("0%");
        $('#porcentajecostodirectoobra').val(0);
        $('#labelporcentajecostodirectoobra').html("0%");
        $('#costototalproyecto').val(0);
        $('#labelcostototalproyecto').html("$0");
        $('#porcentajecostototalproyecto').val(0);
        $('#labelporcentajecostototalproyecto').html("0%");
    }
}

//configuraciones
function numericosAlCargarConfiguracion()
{
    var jefeoperacionesmenorque = $('#jefeoperacionesmenorque').val().replaceAll(".", "");
    var subgerenteoperacionesentre_inicial = $('#subgerenteoperacionesentre_inicial').val().replaceAll(".", "");
    var subgerenteoperacionesentre_final = $('#subgerenteoperacionesentre_final').val().replaceAll(".", "");
    var subgerentegeneralentre_inicial = $('#subgerentegeneralentre_inicial').val().replaceAll(".", "");
    var subgerentegeneralentre_final = $('#subgerentegeneralentre_final').val().replaceAll(".", "");
    var gerentegeneralmayorque = $('#gerentegeneralmayorque').val().replaceAll(".", "");

    checkValorNumerico(jefeoperacionesmenorque, 'jefeoperacionesmenorque');
    checkValorNumerico(subgerenteoperacionesentre_inicial, 'subgerenteoperacionesentre_inicial');
    checkValorNumerico(subgerenteoperacionesentre_final, 'subgerenteoperacionesentre_final');
    checkValorNumerico(subgerentegeneralentre_inicial, 'subgerentegeneralentre_inicial');
    checkValorNumerico(subgerentegeneralentre_final, 'subgerentegeneralentre_final');
    checkValorNumerico(gerentegeneralmayorque, 'gerentegeneralmayorque');
}

//trabajos adicionales
function limpiaPuntoGuionTrabajosAdicionales(valorarray)
{
    var valoractual = $('#montoitem'+valorarray).val();

    if(valoractual != '' && valoractual != 'NaN'){
        var valornuevo = valoractual.replace(/\,/g, '');
        var valornuevo2 = valornuevo.replace(/\./g, '');
        $('#montoitem'+valorarray).val(valornuevo2);
    }else{
        $('#montoitem'+valorarray).val(0);
    }
}

function checkValorNumericoTrabajoAdicional(valorarray)
{
    var valor = document.getElementById('montoitem'+valorarray).value;
    var options = { style: 'currency', currency: 'clp', minimumFractionDigits: 0, maximumFractionDigits: 0 };
    var formatter = new Intl.NumberFormat(options);
    var invertido = formatter.format(valor);
    document.getElementById('montoitem'+valorarray).value = invertido;
}

//cotizaciones PGP
function limpiaPuntoGuionCotizacionesPGPValorTotal(valorarray)
{
    var valoractual = $('#cot_valor_total'+valorarray).val();

    if(valoractual != '' && valoractual != 'NaN'){
        var valornuevo = valoractual.replace(/\,/g, '');
        var valornuevo2 = valornuevo.replace(/\./g, '');
        $('#cot_valor_total'+valorarray).val(valornuevo2);
    }else{
        $('#cot_valor_total'+valorarray).val(0);
    }
}

function checkValorNumericoCotizacionesPGPValorTotal(valorarray)
{
    var valor = document.getElementById('cot_valor_total'+valorarray).value;
    var options = { style: 'currency', currency: 'clp', minimumFractionDigits: 0, maximumFractionDigits: 0 };
    var formatter = new Intl.NumberFormat(options);
    var invertido = formatter.format(valor);
    document.getElementById('cot_valor_total'+valorarray).value = invertido;
}

function limpiaPuntoGuionCotizacionesPGPMontoPersonal(valorarray)
{
    var valoractual = $('#cot_ic_montopersonal'+valorarray).val();

    if(valoractual != '' && valoractual != 'NaN'){
        var valornuevo = valoractual.replace(/\,/g, '');
        var valornuevo2 = valornuevo.replace(/\./g, '');
        $('#cot_ic_montopersonal'+valorarray).val(valornuevo2);
    }else{
        $('#cot_ic_montopersonal'+valorarray).val(0);
    }
}

function checkValorNumericoCotizacionesPGPMontoPersonal(valorarray)
{
    var valor = document.getElementById('cot_ic_montopersonal'+valorarray).value;
    var options = { style: 'currency', currency: 'clp', minimumFractionDigits: 0, maximumFractionDigits: 0 };
    var formatter = new Intl.NumberFormat(options);
    var invertido = formatter.format(valor);
    document.getElementById('cot_ic_montopersonal'+valorarray).value = invertido;
}

function limpiaPuntoGuionCotizacionesPGPMontoMaterial(valorarray)
{
    var valoractual = $('#cot_ic_montomaterial'+valorarray).val();

    if(valoractual != '' && valoractual != 'NaN'){
        var valornuevo = valoractual.replace(/\,/g, '');
        var valornuevo2 = valornuevo.replace(/\./g, '');
        $('#cot_ic_montomaterial'+valorarray).val(valornuevo2);
    }else{
        $('#cot_ic_montomaterial'+valorarray).val(0);
    }
}

function checkValorNumericoCotizacionesPGPMontoMaterial(valorarray)
{
    var valor = document.getElementById('cot_ic_montomaterial'+valorarray).value;
    var options = { style: 'currency', currency: 'clp', minimumFractionDigits: 0, maximumFractionDigits: 0 };
    var formatter = new Intl.NumberFormat(options);
    var invertido = formatter.format(valor);
    document.getElementById('cot_ic_montomaterial'+valorarray).value = invertido;
}

function limpiaPuntoGuionCotizacionesPGPMontoEquipos(valorarray)
{
    var valoractual = $('#cot_ic_montoequipos'+valorarray).val();

    if(valoractual != '' && valoractual != 'NaN'){
        var valornuevo = valoractual.replace(/\,/g, '');
        var valornuevo2 = valornuevo.replace(/\./g, '');
        $('#cot_ic_montoequipos'+valorarray).val(valornuevo2);
    }else{
        $('#cot_ic_montoequipos'+valorarray).val(0);
    }
}

function checkValorNumericoCotizacionesPGPMontoEquipos(valorarray)
{
    var valor = document.getElementById('cot_ic_montoequipos'+valorarray).value;
    var options = { style: 'currency', currency: 'clp', minimumFractionDigits: 0, maximumFractionDigits: 0 };
    var formatter = new Intl.NumberFormat(options);
    var invertido = formatter.format(valor);
    document.getElementById('cot_ic_montoequipos'+valorarray).value = invertido;
}

//dashboard
function tipoinformedashboard()
{
    var valor = $("#tipoinforme").val();

    if(valor == 1){
        //Adjudicaciones Acumuladas Año
        $("#divanioinforme").css('display','block');
        $("#divmensualinforme").css('display','none');
        $("#divclienteinforme").css('display','none');
        $("#divplantainforme").css('display','none');
    }else if(valor == 2){
        //Adjudicaciones Mes
        $("#divanioinforme").css('display','none');
        $("#divmensualinforme").css('display','block');
        $("#divclienteinforme").css('display','none');
        $("#divplantainforme").css('display','none');
    }else if(valor == 3){
        //Adjudicaciones por Cliente
        $("#divanioinforme").css('display','none');
        $("#divmensualinforme").css('display','none');
        $("#divclienteinforme").css('display','block');
        $("#divplantainforme").css('display','none');
    }else if(valor == 4){
        //Adjudicaciones por Planta
        $("#divanioinforme").css('display','none');
        $("#divmensualinforme").css('display','none');
        $("#divclienteinforme").css('display','none');
        $("#divplantainforme").css('display','block');
    }else{
        $("#divanioinforme").css('display','none');
        $("#divmensualinforme").css('display','none');
        $("#divclienteinforme").css('display','none');
        $("#divplantainforme").css('display','none');
    }
}

function validarfiltrodashboard(){
    var tipoinforme = $("#tipoinforme").val();
    var dashb_anio = $("#dashb_anio").val();
    var dashb_mes = $("#dashb_mes").val();
    var dashb_cliente = $("#dashb_cliente").val();
    var dashb_planta = $("#dashb_planta").val();

    if(tipoinforme == 1){
        //Adjudicaciones Acumuladas Año
        if(dashb_anio != 0){
            dashboard_graficaranio(dashb_anio);
        }else{
            $.notify({icon: "add_alert", message: 'Debe seleccionar el año a gestionar'},{type: 'danger', timer: 1000})
        }
    }else if(tipoinforme == 2){
        //Adjudicaciones Mes
        if(dashb_mes != 0 && dashb_mes != ''){
            dashboard_graficarmes(dashb_mes);
        }else{
            $.notify({icon: "add_alert", message: 'Debe seleccionar el mes a gestionar'},{type: 'danger', timer: 1000})
        }
    }else if(tipoinforme == 3){
        //Adjudicaciones por Cliente
        if(dashb_cliente != 0){
            dashboard_graficarcliente(dashb_cliente);
        }else{
            $.notify({icon: "add_alert", message: 'Debe seleccionar el cliente a gestionar'},{type: 'danger', timer: 1000})
        }
    }else if(tipoinforme == 4){
        //Adjudicaciones por Planta
        if(dashb_planta != 0){
            dashboard_graficarplanta(dashb_planta);
        }else{
            $.notify({icon: "add_alert", message: 'Debe seleccionar la planta a gestionar'},{type: 'danger', timer: 1000})
        }
    }else{
        $.notify({icon: "add_alert", message: 'Debe seleccionar el tipo de informe'},{type: 'danger', timer: 1000})
    }
}

function dashboard_graficaranio(year){
    $.ajax({
        url: baseurl+'dashboard_datos_anio/'+year,
        type: 'get',
        dataType: 'json',
        beforeSend: function () {
            $.notify({icon: "add_alert", message: 'Procesando la búsqueda de registros, favor espere'},{type: 'info', timer: 1000})
        },
        success: function(data) {
            if(data.estado == "success"){
                toastr.info("Información obtenida exitosamente, se procede a graficar");

                var totallicitacionesadjudicadas = data.totallicitacionesadjudicadas;
                var totallicitacionesadjudicadasyejecutadas = data.totallicitacionesadjudicadasyejecutadas;
                var totallicitacionesadjudicadasnoejecutadas = data.totallicitacionesadjudicadasnoejecutadas;
                var totallicitacionesejecutados = data.totallicitacionesejecutados;
                var totallicitacionesejecutadosyfacturadas = data.totallicitacionesejecutadosyfacturadas;
                var totallicitacionesejecutadosnofacturadas = data.totallicitacionesejecutadosnofacturadas;

                graficardashboard(totallicitacionesadjudicadas,totallicitacionesadjudicadasyejecutadas,totallicitacionesadjudicadasnoejecutadas,totallicitacionesejecutados,totallicitacionesejecutadosyfacturadas,totallicitacionesejecutadosnofacturadas);
            }else{
                toastr.error("Ocurrio un error interno al procesar la solicitud, favor intentar nuevamente");
            }
        }
    });
}

function dashboard_graficarmes(mes){
    $.ajax({
        url: baseurl+'dashboard_datos_mes/'+mes,
        type: 'get',
        dataType: 'json',
        beforeSend: function () {
            $.notify({icon: "add_alert", message: 'Procesando la búsqueda de registros, favor espere'},{type: 'info', timer: 1000})
        },
        success: function(data) {
            if(data.estado == "success"){
                toastr.info("Información obtenida exitosamente, se procede a graficar");

                var totallicitacionesadjudicadas = data.totallicitacionesadjudicadas;
                var totallicitacionesadjudicadasyejecutadas = data.totallicitacionesadjudicadasyejecutadas;
                var totallicitacionesadjudicadasnoejecutadas = data.totallicitacionesadjudicadasnoejecutadas;
                var totallicitacionesejecutados = data.totallicitacionesejecutados;
                var totallicitacionesejecutadosyfacturadas = data.totallicitacionesejecutadosyfacturadas;
                var totallicitacionesejecutadosnofacturadas = data.totallicitacionesejecutadosnofacturadas;

                graficardashboard(totallicitacionesadjudicadas,totallicitacionesadjudicadasyejecutadas,totallicitacionesadjudicadasnoejecutadas,totallicitacionesejecutados,totallicitacionesejecutadosyfacturadas,totallicitacionesejecutadosnofacturadas);
            }else{
                toastr.error("Ocurrio un error interno al procesar la solicitud, favor intentar nuevamente");
            }
        }
    });
}

function dashboard_graficarcliente(cliente){
    $.ajax({
        url: baseurl+'dashboard_datos_cliente/'+cliente,
        type: 'get',
        dataType: 'json',
        beforeSend: function () {
            $.notify({icon: "add_alert", message: 'Procesando la búsqueda de registros, favor espere'},{type: 'info', timer: 1000})
        },
        success: function(data) {
            if(data.estado == "success"){
                toastr.info("Información obtenida exitosamente, se procede a graficar");

                var totallicitacionesadjudicadas = data.totallicitacionesadjudicadas;
                var totallicitacionesadjudicadasyejecutadas = data.totallicitacionesadjudicadasyejecutadas;
                var totallicitacionesadjudicadasnoejecutadas = data.totallicitacionesadjudicadasnoejecutadas;
                var totallicitacionesejecutados = data.totallicitacionesejecutados;
                var totallicitacionesejecutadosyfacturadas = data.totallicitacionesejecutadosyfacturadas;
                var totallicitacionesejecutadosnofacturadas = data.totallicitacionesejecutadosnofacturadas;

                graficardashboard(totallicitacionesadjudicadas,totallicitacionesadjudicadasyejecutadas,totallicitacionesadjudicadasnoejecutadas,totallicitacionesejecutados,totallicitacionesejecutadosyfacturadas,totallicitacionesejecutadosnofacturadas);
            }else{
                toastr.error("Ocurrio un error interno al procesar la solicitud, favor intentar nuevamente");
            }
        }
    });
}

function dashboard_graficarplanta(planta){
    $.ajax({
        url: baseurl+'dashboard_datos_planta/'+planta,
        type: 'get',
        dataType: 'json',
        beforeSend: function () {
            $.notify({icon: "add_alert", message: 'Procesando la búsqueda de registros, favor espere'},{type: 'info', timer: 1000})
        },
        success: function(data) {
            if(data.estado == "success"){
                toastr.info("Información obtenida exitosamente, se procede a graficar");

                var totallicitacionesadjudicadas = data.totallicitacionesadjudicadas;
                var totallicitacionesadjudicadasyejecutadas = data.totallicitacionesadjudicadasyejecutadas;
                var totallicitacionesadjudicadasnoejecutadas = data.totallicitacionesadjudicadasnoejecutadas;
                var totallicitacionesejecutados = data.totallicitacionesejecutados;
                var totallicitacionesejecutadosyfacturadas = data.totallicitacionesejecutadosyfacturadas;
                var totallicitacionesejecutadosnofacturadas = data.totallicitacionesejecutadosnofacturadas;

                graficardashboard(totallicitacionesadjudicadas,totallicitacionesadjudicadasyejecutadas,totallicitacionesadjudicadasnoejecutadas,totallicitacionesejecutados,totallicitacionesejecutadosyfacturadas,totallicitacionesejecutadosnofacturadas);
            }else{
                toastr.error("Ocurrio un error interno al procesar la solicitud, favor intentar nuevamente");
            }
        }
    });
}

function graficardashboard(licitadjud,licitadjudyeject,licitadjudnoejecut,licitejecutadas,licitejecutadasyfacturadas,licitejecutadasnofacturadas){
    //Iniciando grafico licitaciones adjudicadas
    var myChart = echarts.init(document.getElementById('grafico_dashboard_licitaciones_adjudicadas'));
    // Specify the configuration items and data for the chart
    option = {
        title: {
            text: 'Licitaciones Adjudicadas',
            left: 'center'
        },
        tooltip: {
            trigger: 'item'
        },
        legend: {
            orient: 'vertical',
            left: 'left'
        },
        series: [
            {
                name: 'Total Adjudicadas '+licitadjud,
                type: 'pie',
                radius: '50%',
                data: [
                    { value: licitadjudyeject, name: 'Ejecutadas' },
                    { value: licitadjudnoejecut, name: 'No Ejecutadas' }
                ],
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };
    myChart.setOption(option);

    //Iniciando grafico licitaciones ejecutadas
    var myChart2 = echarts.init(document.getElementById('grafico_dashboard_licitaciones_ejecutadas'));
    // Specify the configuration items and data for the chart
    option2 = {
        title: {
            text: 'Licitaciones Ejecutadas',
            left: 'center'
        },
        tooltip: {
            trigger: 'item'
        },
        legend: {
            orient: 'vertical',
            left: 'left'
        },
        series: [
            {
                name: 'Total Ejecutadas '+licitejecutadas,
                type: 'pie',
                radius: '50%',
                data: [
                    { value: licitejecutadasyfacturadas, name: 'Facturadas' },
                    { value: licitejecutadasnofacturadas, name: 'No Facturadas' }
                ],
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };
    myChart2.setOption(option2);

}
