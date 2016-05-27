/**
 * Created by Samuel on 24/05/16.
 */
$(function(){

    /*
     * Inicializacion para los datepicker
     * */
    $(document).on('focus','*[data-toggle="date"]', function(event) {
        event.preventDefault();

        $(this).mask("00/00/0000", {placeholder: "dia/mes/año"});

        $(this).datepicker({
            format: 'd/mm/yyyy',
            language: 'es',
            autoclose: true
        });
    });

    $(document).on('focus','#resp',function(event){
        console.log('no sale on focus');
    });

    /*
     * mostar popup para agregar acciones por tipo
     * */
    $(document).on('click','button.add-accion',function(e){
        e.preventDefault();
        var btn = $(this);
        var token = $('input[name = _token]').val();
        var incidente = $(btn).data('incidente');
        var type = $(btn).data("type");

        $('#modalAddAccionShow').modal('show');

        $.ajax({
            url: '/incidente/add-accion',
            type: 'GET',
            data: {'_token': token, 'incidente':incidente,'type': type }
        })
            .done(function(data) {
                $('#modalView').append(data);
                $('#modalAddAccionShow').modal('show');
                $('#modalAddAccionShow').on('hidden.bs.modal', function (e) {
                    $(this).remove();
                });
                console.log("mostrando vista para agregar acciones");
            });
    });

    $(document).on('shown.bs.modal','#modalAddAccionShow',function(event){

        $('#formAddAccion').formValidation({
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
                        $('#modalAddAccionShow').modal('hide');
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

        console.log(blod_name.ttAdapter().toString());
        console.log("agregando taginput");

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


        $('#resp').on('itemAdded', function(event) {
            // event.item: contains the item
            $('#name').val(event.item.name);
            $('#email').val(event.item.email);

            $('#formAddAccion').formValidation('revalidateField', 'descripcion');
            $('#formAddAccion').formValidation('revalidateField', 'fecComprometida');
            $('#formAddAccion').formValidation('revalidateField', 'resp');
            $(".twitter-typeahead").css('display', 'inline');
        }).on('itemRemoved', function(event) {
            $('#formAddAccion').formValidation('revalidateField', 'descripcion');
            $('#formAddAccion').formValidation('revalidateField', 'fecComprometida');
            $('#formAddAccion').formValidation('revalidateField', 'resp');
        });

    });

    /*
     * Submit del trabajador en el nuevo contrato
     * */
    $(document).on('click','#btnSaveAccion',function(e){
        e.preventDefault();

        $('#formAddAccion').formValidation('revalidateField', 'descripcion');
        $('#formAddAccion').formValidation('revalidateField', 'fecComprometida');
        $('#formAddAccion').formValidation('revalidateField', 'resp');

        $('#formAddAccion').submit();
    });
});