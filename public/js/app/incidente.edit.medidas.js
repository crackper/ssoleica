/**
 * Created by Samuel on 1/04/16.
 */
$(function(){
    $('#tabIncidente a[href="#medidas"]').click(function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).data('url'),
            type: 'GET',
            success: function(data){
                $('#medidas').html(data);
            }
        })
    });

    $(document).on('click','a.remove-accion',function(event){
        event.preventDefault();
        accion = $(this).data('accion');
        tr = $(this).closest('tr');
        text = $(tr).find('td').eq(1).html();

        BootstrapDialog.confirm({
            title: '<b>SSO Leica</b>',
            message: '<b>Desea eliminar esta Acción?</b>' + text,
            type: BootstrapDialog.TYPE_WARNING, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            btnCancelLabel: 'No', // <-- Default value is 'Cancel',
            btnOKLabel: 'Si', // <-- Default value is 'OK',
            btnOKClass: 'btn-warning', // <-- If you didn't specify it, dialog type will be used,
            callback: function(result) {
                if(result) {

                    $.ajax({
                        url: '/incidente/delete-accion/' + accion,
                        type: 'GET',
                        success: function(data) {
                            console.log(data);
                            var style = data.success ? 'info':'danger';

                            var alerta = '<div class="alert alert-'+ style +' alert-dismissable">';
                            alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                            alerta += data.data;
                            alerta += '</div>';


                            if(data.success)
                            {
                                //$('#tabIncidente a[href="#medidas"]').trigger('click');
                                $(tr).fadeOut('slow',function(){ $(this).remove(); });
                                $('#modalEditAccionShow').modal('hide');
                            }

                            BootstrapDialog.alert({
                                title:'SSO Leica Geosystems',
                                message: data.data
                            });


                            $('.mensaje').find('.alert').remove();
                            $('.mensaje').append(alerta);
                        }
                    });
                }
            }
        });
    });
});
