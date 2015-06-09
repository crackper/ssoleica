/**
 * Created by Samuel on 19/05/15.
 */
$(function(){
    $('select').selectpicker({
        size: 7
    });

    $('.btn-toolbar').first().hide();

    /*
    * Inicializacion para los datepicker
    * */
    $(document).on('focus','*[data-toggle="date"]', function(event) {
        event.preventDefault();

        $(this).mask("0000-00-00", {placeholder: "yyyy-m-d"});

        $(this).datepicker({
            format: 'yyyy-m-d',
            language: 'es',
            autoclose: true
        });
    });

    $('#tabTrabajador a[href="#general"]').click(function (e) {
        e.preventDefault();
        $('.btn-toolbar').last().show();
    });

    $('#tabTrabajador a[href="#adicional"]').click(function (e) {
        e.preventDefault();
        $('.btn-toolbar').last().show();
    });

    /*
    * Cargar el Tab de Contratos
    * */
    $('#tabTrabajador a[href="#contrato"]').click(function (e) {
        e.preventDefault();
        $('.btn-toolbar').hide();

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

    /*
    * actualizar fecha de vencimiento de los contratos
    * */
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

    /*
    * mostar popup que permite cambiar de contrato a un trabajador
    * */
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

    /*
    * Logica para asigar para cambiar de contrato a un trabajador
    * */
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

    /*
    * Submit a la información del trabajador y contrato cambiado
    * */
    $(document).on('click','*[data-update="contrato"]',function(e){
        e.preventDefault();
        $('#formUpdateContrato').submit();
    });

    /*
    * Muestar popup que permite asignar un trabajador a un contrato
    * */
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

    /*
    * Logica para asignar un trabajor a un contrato
    * */
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

                    BootstrapDialog.alert({
                        title:'SSO Leica Geosystems',
                        message: data.data
                    });
                }
            });
        });
    });

    /*
    * Submit del trabajador en el nuevo contrato
    * */
    $(document).on('click','#btnAsignarContrato',function(e){
        e.preventDefault();
        $('#formAsignarContrato').submit();
    });

    /*
    * Mostar sub menu de proyectos en la pestaña Examenes médicos
    * */
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

    /*
     * Mostar examenes medicos segun el proyecto seleccionado del sub menu anterior
     * */
    $(document).on('click','*[data-examen="true"]',function(){
        $('.btn-toolbar').hide();
        var link = this;

        $.ajax({
            url: $(link).data('url'),
            type: 'GET',
            success: function(data){
                $('#examenes').html(data);
            }
        })

    });

    /*
    * Actualizar fecha de vencimiento ya sea de un exemen medico o un documetno
    * */
    $(document).on('click','button.update-vencimiento', function () {
        var btn = $(this);
        var vencimiento = $(btn).data('vencimiento');
        var tr = $(btn).closest('tr');
        var fecha = $(tr).find('td').eq(2).find('input').val();
        var caduca = $(tr).find('td').eq(3).find('input[type=checkbox]').is(":checked") ? 1 : 0;
        var obs = $(tr).find('td').eq(4).find('input').val();
        var token = $('input[name = _token]').val();

        if(fecha == '')
        {
            var alerta = '<div class="alert alert-danger alert-dismissable">';
            alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            alerta += 'Ingresa una fecha valida';
            alerta += '</div>';

            $(tr).find('td').eq('1').append(alerta);
            $(tr).find('td').eq('2').find('input.date').closest('div').addClass('has-error');

            return;
        }
        else
        {
            $(tr).find('td').eq('1').find('.alert').remove();
            $(tr).find('td').eq('2').find('input.date').closest('div').removeClass('has-error');
        }

       $.ajax({
            url: '/trabajador/updatevencimiento',
            type: 'POST',
            dataType: 'json',
            data: {'vencimiento': vencimiento, 'fecha': fecha, 'obs': obs,'caduca':caduca,'_token': token},
            beforeSend: function(xhr){
                $(btn).button('loading');
            },
            success :function(data) {

                var style = data.success == 1 ? 'info':'danger';

                var alerta = '<div class="alert alert-'+ style +' alert-dismissable">';
                alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                alerta += data.data;
                alerta += '</div>';

                $(tr).find('td').eq('1').append(alerta);

                $(btn).button('reset');
            }
        });
    });

    /*
    * Mostar popup para agregr un nuevo vencimento ya sea examen medico o documento
    * */
    $(document).on('click','.addVencimiento',function(){
        var link = this;

        $.ajax({
            url: $(link).data('url'),
            type: 'GET',
            success: function(data){
                $('#modalView').append(data);
                $('#modalAddVencimientoShow').modal('show');
                $('#modalAddVencimientoShow').on('hidden.bs.modal', function (e) {
                    $(this).remove();
                });
            }
        })
    });

    /*
    * Submit de la información del nuevo vencimiento
    * */
    $(document).on('click','#btnSaveVencimiento',function(e){
        e.preventDefault();
        $('#formAddVencimiento').submit();
    });

    /*
    * logica para guardar un nuevo vencimiento, examen medico o documento
    * */
    $(document).on('shown.bs.modal','#modalAddVencimientoShow',function(){

        $('#btnSaveVencimiento').hide();

        if($('#vencimiento_id option').size() == 1 )
        {
            $(this).find('option[value=""]').text('NO HAY ASIGNACIONES DISPONIBLES');
            $('#vencimiento_id').attr('disabled', 'disabled');
        }

        $('select').selectpicker({
            size: 7
        });

        $('*[data-toggle="date"]').mask("0000-00-00", {placeholder: "yyyy-m-d"});

        $('#formAddVencimiento').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                vencimiento_id: {
                    validators: {
                        integer: {
                            message: 'Seleccione un Examen'
                        }
                    }
                },
                fecVencimiento: {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de Vencimiento es requerida'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Ingresa una fecha válida.'
                        }
                    }
                }
            }
        })
            .on('change', '#vencimiento_id', function(e) {
                $('#vencimiento_id').formValidation('revalidateField', 'vencimiento_id');

                if($(this).val() > 0)
                {
                    $('#btnSaveVencimiento').show();
                }
                else
                {
                    $('#btnSaveVencimiento').hide();
                }
            })
            .on('success.form.fv', function(e) {
            e.preventDefault();

            var $form = $(e.target),
                fv    = $(e.target).data('formValidation');

                var vencimiento = $("#vencimiento_id option:selected").text();

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(data) {

                        var style = data.success == 1 ? 'info':'danger';

                        var alerta = '<div class="alert alert-'+ style +' alert-dismissable">';
                        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                        alerta += data.msg;
                        alerta += '</div>';

                        if(data.success == 1)
                        {
                            var rows = $('*[data-toogle="documentos"] > tbody > tr').length;
                            var table = $('*[data-toogle="documentos"] > tbody');

                            var row = $(table).find('tr').last();
                            var newRow = $(row).clone().removeClass('hide').insertBefore(row);

                            $(newRow).find('td').eq(0).html(rows);
                            $(newRow).find('td').eq(1).html(vencimiento);
                            $(newRow).find('td').eq(2).find('input.date').val(data.data.fecha_vencimiento);
                            $(newRow).find('td').eq(4).find('input').val(data.data.observaciones);
                            $(newRow).find('td').eq(5).find('button').attr('data-examen',data.data.id);

                            if(data.data.caduca == 1)
                            {
                                $(newRow).find('td').eq(3).find('input[type=checkbox]').prop('checked',true);
                            }
                        }

                        $('.mensaje').find('.alert').remove();
                        $('.mensaje').append(alerta);

                        $('#modalAddVencimientoShow').modal('hide');
                    }
                });
        });
    });

    /*
    * mostar documentos de un trabajador
    * */
    $('#tabTrabajador a[href="#documentos"]').click(function (e){
        e.preventDefault();
        $('.btn-toolbar').hide();
        var link = this;

        $.ajax({
            url: $(link).data('url'),
            type: 'GET',
            success: function(data){
                $('#documentos').html(data);
            }
        })

    });

});