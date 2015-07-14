/**
 * Created by Samuel on 10/07/15.
 */
$(function(){
    $('select').selectpicker({
        size: 7
    });

    $('#btnRegistrar').hide();

    $('*[data-toggle="perdidos"]').mask("00.00",{reverse: true,selectOnFocus: true,placeholder: "00.00"});
    $('*[data-toggle="dotacion"]').mask("000",{reverse: true,selectOnFocus: true,placeholder: "000"});
    $('*[data-toggle="incidente"]').mask("00",{reverse: true,selectOnFocus: true,placeholder: "00"});


    $("#proyecto_id").change(function() {
        $("#contrato_id").empty();

        $.getJSON("/estadisticas/contratos/" + $("#proyecto_id").val(), function(data) {
            $("#contrato_id").empty();

            if(data.length != 0 )
            {
                $.each(data, function(index, value) {
                    $("#contrato_id").append('<option value="'+index+'">' +value+'</option>');
                });

                $("#contrato_id").trigger("change");
            }
            else{
                $("#contrato_id").empty();
                $("#btnRegistrar").hide();
            }

            $("#contrato_id").selectpicker('refresh');

        });
    });

    $("#contrato_id").change(function() {
        $("#month_id").empty();

        $.getJSON("/estadisticas/months/" + $("#contrato_id").val(), function(data) {
            $("#month_id").empty();

            if(data.length != 0 )
            {
                $.each(data, function(index, value) {
                    $("#month_id").append('<option value="'+index+'">' +value+'</option>');
                });

                $("#month_id").trigger("change");
                $("#btnRegistrar").show();
            }
            else{
                $("#month_id").empty();
                $("#btnRegistrar").hide();
            }

            $("#month_id").selectpicker('refresh');

        });
    });

    $('#frmRegistrarEstadisticas').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            month_id: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione un Mes'
                    }
                }
            },
            proyecto_id: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione un Proyecto'
                    }
                }
            },
            contrato_id: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione un contrato'
                    }
                }
            },
            dotacion:{
                validators:{
                    notEmpty:{
                        message: 'Ingrese la dotación'
                    },
                    integer:{
                        message: 'Ingres un número entero para la dotación'
                    }
                }
            },
            cantDiasPerdidos:{
                validators:{
                    notEmpty:{
                        message: 'Ingrese la cantidad de dias perdidos'
                    },
                    numeric:{
                        message: 'Ingrese la cantidad de dias perdidos'
                    }
                }
            },
            stp:{
                validators:{
                    notEmpty:{
                        message: 'Ingrese la cantidad de incidentes STP'
                    },
                    integer:{
                        message: 'Ingrese la cantidad de incidentes STP'
                    }
                }
            },
            ctp:{
                validators:{
                    notEmpty:{
                        message: 'Ingrese la cantidad de incidentes CTP'
                    },
                    integer:{
                        message: 'Ingrese la cantidad de incidentes CTP'
                    }
                }
            }
        }
    });

});