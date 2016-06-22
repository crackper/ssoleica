/**
 * Created by Samuel on 24/05/16.
 */
$(function(){

    /*
     * mostar popup para agregar acciones por tipo
     * */
    $(document).on('click','a.update-accion',function(e){
        e.preventDefault();
        var btn = $(this);
        var accion = $(btn).data('accion');


        $.ajax({
            url: '/incidente/edit-accion/' + accion,
            type: 'GET'
        })
            .done(function(data) {
                $('#modalView').append(data);
                $('#modalEditAccionShow').modal('show');
                $('#modalEditAccionShow').on('hidden.bs.modal', function (e) {
                    $(this).remove();
                });
            });
    });

    $(document).on('show.bs.modal','#modalEditAccionShow',function(event){

        $('#formEditAccion').formValidation({
            framework: 'bootstrap',
            excluded: ':disabled',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                descripcion:{
                    validators:{
                        notEmpty:{
                            message: 'Ingresa la Descripcion'
                        },
                        stringLength: {
                            min: 25,
                            message: 'La descripcion mínima es de 25 caracteres'
                        }
                    }
                },
                resp:{
                    validators:{
                        notEmpty:{
                            message: 'Ingrese el o los responsable(s)'
                        }
                    }
                },
                fecComprometida: {
                    validators: {
                        notEmpty: {
                            message: 'La fecha comprometida es requerida'
                        },
                        date: {
                            format: 'DD/MM/YYYY',
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
                    console.log(data);
                    var style = data.success ? 'info':'danger';

                    var alerta = '<div class="alert alert-'+ style +' alert-dismissable">';
                    alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    alerta += data.data;
                    alerta += '</div>';


                    if(data.success)
                    {
                        $('#tabIncidente a[href="#medidas"]').trigger('click');
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
        });

        $('#descripcion').redactor({
            buttonsHide: ['image', 'file', 'link']
        });

        var blod_name = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: '/incidente/trabajador/%QUERY'
        });

        blod_name.initialize();

        $('#resp').tagsinput({
            itemValue: 'id',
            itemText: 'name',
            maxTags: 20,
            tagClass:'label label-warning',
            allowDuplicates: false,
            placeholderText:'Apellidos o Nombres....'
        });


        $('#resp').tagsinput('input').typeahead(null, {
            name: 'name',
            displayKey: 'name',
            highlight: true,
            minLength: 2,
            source: blod_name.ttAdapter()
        }).bind('typeahead:selected', $.proxy(function (obj, data) {
            this.tagsinput('add', data);
            this.tagsinput('input').typeahead('val', '');
        }, $('#resp')));


        var obj = jQuery.parseJSON($('#data-tags').val());

        $.each(obj,function(index, row){
            $('#resp').tagsinput('add', { "id": row.value , "name": row.text });
        });


        $('#resp').on('itemAdded', function(event) {
            $('#formEditAccion').formValidation('revalidateField', 'descripcion');
            $('#formEditAccion').formValidation('revalidateField', 'fecComprometida');
            $('#formEditAccion').formValidation('revalidateField', 'resp');
            $(".twitter-typeahead").css('display', 'inline');
        }).on('itemRemoved', function(event) {
            $('#formEditAccion').formValidation('revalidateField', 'descripcion');
            $('#formEditAccion').formValidation('revalidateField', 'fecComprometida');
            $('#formEditAccion').formValidation('revalidateField', 'resp');
        });

    });

    /*
     * Submit del trabajador en el nuevo contrato
     * */
    $(document).on('click','#btnSaveAccion',function(e){
        e.preventDefault();

       $('#formEditAccion').formValidation('revalidateField', 'descripcion');
        $('#formEditAccion').formValidation('revalidateField', 'fecComprometida');
        $('#formEditAccion').formValidation('revalidateField', 'resp');
        console.log("click en save");
        $('#formEditAccion').submit();

    });

});