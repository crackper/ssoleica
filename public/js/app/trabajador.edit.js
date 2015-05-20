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
            url: '/trabajador/proyectos/1',
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

});