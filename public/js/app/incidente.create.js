/**
 * Created by Samuel on 4/08/15.
 */
$(function(){
    $('select').selectpicker({
        size: 7
    });

    $('#datetimepicker1').datetimepicker({
        sideBySide:true,
        locale: 'es',
        format: 'YYYY-MM-d HH:mm'
    });

    $("#proyecto_id").change(function() {
        $("#contrato_id").empty();

        $.getJSON("/incidente/contratos/" + $("#proyecto_id").val(), function(data) {
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
            }

            $("#contrato_id").selectpicker('refresh');

        });
    });

    $('#frmIncidente').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
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
            tipo_informe: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione el tipo de Informe'
                    }
                }
            },
            tipo_incidente: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione el tipo de Incidente'
                    }
                }
            },
            fecha: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione la fecha y hora del incidente'
                    },
                    callback: {
                        message: 'Ingrese una fecha y hora válida',
                        callback: function (value, validator) {
                            var d = new moment(value, 'YYYY-MM-d HH:mm', true);
                            return d.isValid()
                        }
                    }
                }
            },
            lugar:{
                validators:{
                    notEmpty: {
                        message: 'Ingrese el lugar del Incidente'
                    }
                }
            }
        }
    }).on('change', '[name=fecha]', function(e) {
        console.log('validando');
        $('#frmIncidente').formValidation('validateField', 'fecha');
     });
});
