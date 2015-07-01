/**
 * Created by Samuel on 23/06/15.
 */
$(function(){

    $('select').selectpicker({
        size: 7
    });

    $('#btnLoadTrabajadores').hide();
    $('#btnCambiar').hide();

    console.log('load...!!');

    $('#month_id').change(function(e){
        e.preventDefault();
        console.log($(this).val());
    });

    $("#proyecto_id").change(function() {
        $("#contrato_id").empty();
        $('#gridTrabajadores').html('');

        $.getJSON("/horasHombre/contratos/" + $("#proyecto_id").val(), function(data) {
            $("#contrato_id").empty();

            if(data.length != 0 )
            {
                $.each(data, function(index, value) {
                    $("#contrato_id").append('<option value="'+index+'">' +value+'</option>');
                });

                $("#contrato_id").trigger("change");
                //$('#btnLoadTrabajadores').show('slow');
            }
            else{
                $("#contrato_id").empty();
                //$('#btnLoadTrabajadores').hide('slow');
            }

            $("#contrato_id").selectpicker('refresh');

        });
    });

    $("#contrato_id").change(function() {
        $("#month_id").empty();
        $('#gridTrabajadores').html('');

        $.getJSON("/horasHombre/months/" + $("#contrato_id").val(), function(data) {
            $("#month_id").empty();

            if(data.length != 0 )
            {
                $.each(data, function(index, value) {
                    $("#month_id").append('<option value="'+index+'">' +value+'</option>');
                });

                $("#month_id").trigger("change");
                $('#btnLoadTrabajadores').show('slow');
            }
            else{
                $("#month_id").empty();
                $('#btnLoadTrabajadores').hide('slow');
            }

            $("#month_id").selectpicker('refresh');

        });
    });

    $('#btnLoadTrabajadores').click(function(e){
        e.preventDefault();

        $('#frmRegistrarHorasHombre').data('formValidation').validate();

        if($('#frmRegistrarHorasHombre').data('formValidation').isValid())
        {
            $('#month').val($("#month_id").val());
            $('#proyecto').val($("#proyecto_id").val());
            $('#contrato').val($("#contrato_id").val());

            $.ajax({
                url: '/horasHombre/trabajadorescontrato/' + $("#contrato_id").val(),
                type: 'GET'
            })
                .done(function (data) {

                    var rows = $('#detalle > tbody > tr').length;
                    console.log("rows: " + rows);
                    if (rows != 0) {
                        $('#detalle > tbody tr').each(function () {

                            var $field = $(this).find('[name="horas[]"]');

                            $('#frmRegistrarHorasHombre').formValidation('removeField', $field);
                            $(this).remove();
                            console.log('limpiando -> ' + $field.html())
                        });
                    }

                    $('#gridTrabajadores').html(data);

                    $('#detalle > tbody tr').each(function () {

                        var $field = $(this).find('[name="horas[]"]');
                        $('#frmRegistrarHorasHombre').formValidation('addField', $field);
                    });

                    $('#btnCambiar').show('slow');
                    $('#btnLoadTrabajadores').hide('slow');

                    $('#month_id').attr('disabled','disabled');
                    $('#proyecto_id').attr('disabled','disabled');
                    $('#contrato_id').attr('disabled','disabled');
                });
        }
    });

    /*$('form').submit(function() {
        $(this).find(':input').removeAttr('disabled');
    });*/

    $('#frmRegistrarHorasHombre').formValidation({
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
            'horas[]': {
                row: 'div',
                validators: {
                    notEmpty: {
                        message: 'Ingrese las Horas Hombre'
                    },
                    numeric:{
                        message: 'Ingrese las Horas Hombre',
                        separator:'.'
                    }
                }
            }

        }
    });


    $(document).on('focus','*[data-toggle="horas"]', function(event) {
        event.preventDefault();

        $(this).mask("000.00",{reverse: true,selectOnFocus: true,placeholder: "000.00"});//, {reverse: true,selectOnFocus: true}
    });
});