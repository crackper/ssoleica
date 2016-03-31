/**
 * Created by Samuel on 15/07/15.
 */
$(function(){
    $('#frmLogin').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            email:{
                validators:{
                    notEmpty:{
                        message: 'Ingrese su E-mail'
                    },
                    emailAddress:{
                        message: 'Ingrese su E-mail'
                    }
                }
            },
            password:{
                validators:{
                    notEmpty:{
                        message: 'Ingrese su password'
                    }
                }
            }
        }
    });
});
