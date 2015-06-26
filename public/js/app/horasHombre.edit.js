/**
 * Created by Samuel on 26/06/15.
 */

$(function(){

    $('*[data-toggle="horas"]').mask("000.00",{reverse: true,selectOnFocus: true,placeholder: "000.00"});

    $('#frmRegistrarHorasHombre').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh',
            required: 'fa fa-asterisk'
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
                row: 'td',
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
});