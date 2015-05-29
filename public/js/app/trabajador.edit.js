/**
 * Created by Samuel on 19/05/15.
 */
$(function(){

    $('select').selectpicker({
        size: 7
    });


    $(document).on('focus','*[data-toggle="date"]', function(event) {
        event.preventDefault();

        console.log('select datepicker');

        $(this).mask("0000-00-00", {placeholder: "yyyy-m-d"});

        $(this).datepicker({
            format: 'yyyy-m-d',
            language: 'es',
            autoclose: true
        });

        console.log('value: ' + $(this).val());
    });

    $('#tabTrabajador a[href="#contrato"]').click(function (e) {
        e.preventDefault();

        $.ajax({
            url: $('#tabTrabajador').data('url'),
            type: 'GET'
        })
            .done(function(data) {
                $('#contrato').html(data);
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });

        $(this).tab('show')
    });

    $(document).on('click','button.update',function(e){
        e.preventDefault();

        var btn = $(this);
        var contrato = $(btn).data('contrato');

        var fecha = $(btn).closest('tr').find('input.date').val();
        var obs = $(btn).closest('tr').find('input.obs').val();
        var token = $('input[name = _token]').val();

        if(fecha == '')
        {
            var alerta = '<div class="alert alert-danger alert-dismissable">';
            alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            alerta += 'Ingresa una fecha valida';
            alerta += '</div>';

            $(btn).closest('.table-responsive').append(alerta);
            $(btn).closest('tr').find('input.date').closest('div').addClass('has-error');

            return;
        }
        else
        {
            $(btn).closest('.table-responsive').find('.alert').remove();
            $(btn).closest('tr').find('input.date').closest('div').removeClass('has-error');
        }


        $.ajax({
            url: '/trabajador/updatefecha',
            type: 'POST',
            dataType: 'json',
            data: {'contrato': contrato, 'fecha': fecha, 'obs': obs,'_token': token},
            beforeSend: function(xhr){
                $(btn).button('loading');
            },
            success :function(data) {
                console.log('success update fecha vencimiento fotocheck ');

                var style = data.success == 1 ? 'info':'danger';

                var alerta = '<div class="alert alert-'+ style +' alert-dismissable">';
                alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                alerta += data.data;
                alerta += '</div>';

                $(btn).closest('.table-responsive').append(alerta);
                $(btn).button('reset');
            }
        });
    });

    $(document).on('click','button.change',function(e){
        e.preventDefault();
        var btn = $(this);
        var token = $('input[name = _token]').val();
        var proyecto = $(btn).data('proyecto');
        var contrato = $(btn).data('contrato');
        var proyectoId = $(btn).data('proyecto-id');
        var contratoId = $(btn).data('contratoId');
        var contratoTrabajador = $(btn).data('contratoTrabajador');

        $.ajax({
            url: '/trabajador/cambiarcontrato',
            type: 'POST',
            data: {'_token': token, 'proyecto':proyecto,'contrato':contrato, 'proyectoId':proyectoId,'contratoId':contratoId,'contratoTrabajador':contratoTrabajador}
        })
            .done(function(data) {
                $('#modalView').append(data);
                $('#modalCambiarContratoShow').modal('show');
                $('#modalCambiarContratoShow').on('hidden.bs.modal', function (e) {
                    $(this).remove();
                });
                console.log("success");
            });
    });

    $(document).on('shown.bs.modal','#modalCambiarContratoShow',function(){

        $('select').selectpicker({
            size: 7
        });

        $('*[data-toggle="date"]').mask("0000-00-00", {placeholder: "yyyy-m-d"});

        $('#formUpdateContrato').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                fecFinActual: {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de fin de proyecto actual es requerida'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Ingresa una fecha válida.'
                        }
                    }
                },
                fecIniCambio: {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de inicio en el nuevo contrato requerida'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Ingresa una fecha válida.'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();

            var $form = $(e.target),
                fv    = $(e.target).data('formValidation');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function(data) {

                    var style = data.success == 1 ? 'info':'danger';

                    var alerta = '<div class="alert alert-'+ style +' alert-dismissable">';
                    alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    alerta += data.data;
                    alerta += '</div>';

                    var contrat =  $('*[data-toggle="' + $form.data('contract') + '"]');

                    $(contrat).closest('.table-responsive').find('.alert').remove();

                    if(data.success == 1)
                    {
                        var cbContratos = $('#contrato_id option:selected');

                        $(contrat).html($(cbContratos).text());
                        $(contrat).closest('.table-responsive').find('.change').data('contrato-id',$(cbContratos).val());
                        $(contrat).closest('.table-responsive').find('.change').data('contrato',$(cbContratos).text());

                        $(contrat).closest('.table-responsive').append(alerta);
                    }
                    else
                    {
                        $(contrat).closest('.table-responsive').append(alerta);
                    }

                    $('#modalCambiarContratoShow').modal('hide');
                }
            });
        });

    });

    $(document).on('click','*[data-update="contrato"]',function(e){
        e.preventDefault();
        $('#formUpdateContrato').submit();
    });

    $(document).on('click','#asignarContrato',function(e){
        e.preventDefault();
        var btn = $(this);
        var trabajadorId = $(btn).data('trabajador-id');

        $.ajax({
            url: '/trabajador/asignarcontrato/' + trabajadorId,
            type: 'GET'
        })
            .done(function(data) {
                $('#modalView').append(data);
                $('#modalAsignarContratoShow').modal('show');
                $('#modalAsignarContratoShow').on('hidden.bs.modal', function (e) {
                    $(this).remove();
                });
                console.log("success");
            });
    });

    $(document).on('shown.bs.modal','#modalAsignarContratoShow',function(){

        $('#btnAsignarContrato').hide();

       $('select').selectpicker({
            size: 7
        });

        $('*[data-toggle="date"]').mask("0000-00-00", {placeholder: "yyyy-m-d"});

        $("#proyecto_id").change(function() {
            $.getJSON("/trabajador/contratos/" + $("#proyecto_id").val(), function(data) {
                $("#contrato_id").empty();


                $("#contrato_id").closest('div').find('.alert').remove();

                if(data.length != 0 )
                {
                    $.each(data, function(index, value) {
                        $("#contrato_id").append('<option value="'+index+'">' +value+'</option>');
                    });

                    $("#contrato_id").trigger("change");
                    $('#btnAsignarContrato').show();
                }
                else{
                    $('#btnAsignarContrato').hide();

                    var alerta = '<div class="alert alert-danger alert-dismissable">';
                    alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    alerta += 'No hay contratos disponibles en este proyecto';
                    alerta += '</div>';

                    $("#contrato_id").closest('div').append(alerta);
                }

                $("#contrato_id").selectpicker('refresh');


            });
        });

        $('#formAsignarContrato').formValidation({
            framework: 'bootstrap',
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
                fecInicio: {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de inicio en el contrato requerida'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Ingresa una fecha válida.'
                        }
                    }
                },
                fecVencimiento: {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de Vencimiento del Fotocheck es requerida'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Ingresa una fecha válida.'
                        }
                    }
                },
                nroFotocheck: {
                    validators: {
                        notEmpty: {
                            message: 'El Nro de Fotocheck es requerido'
                        },
                        stringLength: {
                            min: 8,
                            message: 'Nro de Fotocheck debe tener 8 caracteres como mínimo'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();

            var $form = $(e.target),
                fv    = $(e.target).data('formValidation');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function(data) {

                    var style = data.success ? 'info':'danger';

                    var alerta = '<div class="alert alert-'+ style +' alert-dismissable">';
                    alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    alerta += data.data;
                    alerta += '</div>';

                    $("#btnAsignarContrato").closest('div').find('.alert').remove();

                    if(data.success == true)
                    {
                        $('#tabTrabajador a[href="#contrato"]').trigger('click');
                    }
                    else
                    {
                        $("#btnAsignarContrato").closest('div').append(alerta);
                    }

                    $('#modalAsignarContratoShow').modal('hide');
                    alert(data.data);

                }
            });
        });
    });

    $(document).on('click','#btnAsignarContrato',function(e){
        e.preventDefault();
        $('#formAsignarContrato').submit();
    });

    $('#examenesMedicos').click(function (e) {
        e.preventDefault();

        var link = $(this);
        var ul = $(link).closest('.dropdown').find('ul');
        var trabajador_id = $(link).data('trabajador');

        $(ul).empty();

        $.getJSON($(link).data('url'), function(data) {

            $.each(data, function(index, value){
                var item = '<li><a href="#examenes" data-examen="true" data-url="/trabajador/examenesmedicos/' + trabajador_id +'/' + index + '/' + value +'" tabindex="-1" role="tab" data-toggle="tab" aria-controls="dropdown1">' + value + '</a></li>';
                $(ul).append(item);
            });
        });
    });

    $(document).on('click','*[data-examen="true"]',function(){
        var link = this;

        $.ajax({
            url: $(link).data('url'),
            type: 'GET',
            success: function(data){
                $('#examenes').html(data);
            }
        })

    });

});