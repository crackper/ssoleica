/**
 * Created by Samuel on 14/07/15.
 */
$(function(){

    $('*[data-toggle="perdidos"]').mask("00.00",{reverse: true,selectOnFocus: true,placeholder: "00.00"});
    $('*[data-toggle="dotacion"]').mask("###",{reverse: true,selectOnFocus: true,placeholder: "0"});
    $('*[data-toggle="incidente"]').mask("00",{reverse: true,selectOnFocus: true,placeholder: "00"});


    $('#frmRegistrarEstadisticas').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
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
            dotacion:{
                validators:{
                    notEmpty:{
                        message: 'Ingrese la dotación'
                    },
                    integer:{
                        message: 'Ingres un número entero para la dotación'
                    }
                }
            },
            cantDiasPerdidos:{
                validators:{
                    notEmpty:{
                        message: 'Ingrese la cantidad de dias perdidos'
                    },
                    numeric:{
                        message: 'Ingrese la cantidad de dias perdidos'
                    }
                }
            },
            stp:{
                validators:{
                    notEmpty:{
                        message: 'Ingrese la cantidad de incidentes STP'
                    },
                    integer:{
                        message: 'Ingrese la cantidad de incidentes STP'
                    }
                }
            },
            ctp:{
                validators:{
                    notEmpty:{
                        message: 'Ingrese la cantidad de incidentes CTP'
                    },
                    integer:{
                        message: 'Ingrese la cantidad de incidentes CTP'
                    }
                }
            }
        }
    });

});