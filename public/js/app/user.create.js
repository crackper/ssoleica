/**
 * Created by Samuel on 22/07/15.
 */
$(function(){

    $('select').selectpicker({
        size: 7
    });

    $('#frmCreateUser').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name:{
                validators:{
                    notEmpty:{
                        message: 'Ingresa el nombre del usuario'
                    }
                }
            },
            trabajador_id:{
                validators:{
                    notEmpty:{
                        message: 'Ingresa el nombre del usuario'
                    }
                }
            },
            email:{
                validators:{
                    notEmpty:{
                        message: 'Ingresa el E-mail'
                    },
                    emailAddress:{
                        message: 'Ingresa el E-mail'
                    },
                    regexp: {
                        regexp: /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i,
                        message: 'Ingresa un E-mail correcto'
                    }
                }
            },
            password:{
                validators:{
                    notEmpty:{
                        message: 'Ingresa el password'
                    },
                    identical: {
                        field: 'password_confirmation',
                        message: 'El password y la confirmación son distintos'
                    },
                    stringLength: {
                        min: 6,
                        message: 'El Password debe tener 6 caracteres como mínimo'
                    }
                }
            },
            password_confirmation:{
                validators:{
                    notEmpty:{
                        message: 'Confirma el password'
                    },
                    identical: {
                        field: 'password',
                        message: 'El password y la confirmación son distintos'
                    },
                    stringLength: {
                        min: 6,
                        message: 'El Password debe tener 6 caracteres como mínimo'
                    }
                }
            },
            pais_id: {
                validators: {
                    notEmpty: {
                        message: 'Selecciona un Pais'
                    }
                }
            },
            'roles[]': {
                validators: {
                    notEmpty: {
                        message: 'Seleccione los roles para el usuario'
                    }
                }
            }
        }
    })/*.on('change', '[name=*]', function(e) {
        $('#frmCreateUser').formValidation('validateField', 'trabajador_id');
        $('#frmCreateUser').formValidation('validateField', 'name');

    });*/

    var blod_name = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: '/user/trabajadores/%QUERY'
    });

    blod_name.initialize();

   /* $('#th_name .typeahead').typeahead(null, {
        name: 'name',
        displayKey: 'name',
        highlight: true,
        minLength: 2,
        source: blod_name.ttAdapter(),
        templates: {
            suggestion: Handlebars.compile('{{name}}')
        }
    }).on("typeahead:selected typeahead:autocompleted",
        function (e,data) { $('#trabajador_id').val(data.id);

        }).on("typeahead:closed",
        function (e,data) {
            if ($(this).val() == '') {
                $('#trabajador_id').val('');
            }
        });*/

    $('#trabajador_id').tagsinput({
        itemValue: 'id',
        itemText: 'name',
        maxTags: 1,
        tagClass:'label label-primary'
    });

    $('#trabajador_id').tagsinput('input').typeahead(null, {
        name: 'name',
        displayKey: 'name',
        highlight: true,
        minLength: 2,
        source: blod_name.ttAdapter()
    }).bind('typeahead:selected', $.proxy(function (obj, data) {
        this.tagsinput('add', data);
        this.tagsinput('input').typeahead('val', '');
    }, $('#trabajador_id')));

    $('#trabajador_id').on('itemAdded', function(event) {
        // event.item: contains the item
        $('#name').val(event.item.name);
        $('#email').val(event.item.email);

        $('#frmCreateUser').formValidation('revalidateField', 'trabajador_id');
        $('#frmCreateUser').formValidation('revalidateField', 'name');
        $('#frmCreateUser').formValidation('revalidateField', 'email');
        $(".twitter-typeahead").css('display', 'inline');
    }).on('itemRemoved', function(event) {
        $('#name').val('')
        $('#email').val('')

        $('#frmCreateUser').formValidation('revalidateField', 'trabajador_id');
        $('#frmCreateUser').formValidation('revalidateField', 'name');
        $('#frmCreateUser').formValidation('revalidateField', 'email');
    });

    $(".twitter-typeahead").css('display', 'inline');

});