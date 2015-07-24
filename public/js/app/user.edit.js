/**
 * Created by Samuel on 24/07/15.
 */
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
    });

});