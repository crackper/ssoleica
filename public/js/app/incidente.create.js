/**
 * Created by Samuel on 4/08/15.
 */
$(function(){

    Handlebars.setDelimiter('[!','!]');

    $('select').selectpicker({
        size: 7
    });

    $('#datetimepicker1').datetimepicker({
        sideBySide:true,
        locale: 'es',
        format: 'YYYY-MM-d HH:mm'
    });

    $("#proyecto_id").change(function() {
        $("#contrato_id").empty();

        $.getJSON("/incidente/contratos/" + $("#proyecto_id").val(), function(data) {
            $("#contrato_id").empty();

            if(data.length != 0 )
            {
                $.each(data, function(index, value) {
                    $("#contrato_id").append('<option value="'+index+'">' +value+'</option>');
                });

                $("#contrato_id").trigger("change");
            }
            else{
                $("#contrato_id").empty();
            }

            $("#contrato_id").selectpicker('refresh');

        });
    });

    $('#frmIncidente').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
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
            tipo_informe: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione el tipo de Informe'
                    }
                }
            },
            tipo_incidente: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione el tipo de Incidente'
                    }
                }
            },
            fecha: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione la fecha y hora del incidente'
                    },
                    callback: {
                        message: 'Ingrese una fecha y hora válida',
                        callback: function (value, validator) {
                            var d = new moment(value, 'YYYY-MM-d HH:mm', true);
                            return d.isValid()
                        }
                    }
                }
            },
            lugar:{
                validators:{
                    notEmpty: {
                        message: 'Ingrese el lugar del Incidente'
                    }
                }
            }
        }
    }).on('change', '[name=fecha]', function(e) {
        console.log('validando');
        $('#frmIncidente').formValidation('validateField', 'fecha');
     });

    var blod_name = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: '/incidente/trabajador/%QUERY'
    });

    blod_name.initialize();

    $('#trbAfectados').tagsinput({
        itemValue: 'id',
        itemText: 'name',
        maxTags: 5,
        tagClass:'label label-primary'
    });

    $('#trbAfectados').tagsinput('input').typeahead(null, {
        name: 'name',
        displayKey: 'name',
        highlight: true,
        minLength: 2,
        source: blod_name.ttAdapter()
    }).bind('typeahead:selected', $.proxy(function (obj, data) {
        this.tagsinput('add', data);
        this.tagsinput('input').typeahead('val', '');
    }, $('#trbAfectados')));

    $('#trbAfectados').on('itemAdded', function(event) {

        console.log(event.item.id);

        $('input[name="trbAfectado[]"]').each(function() {
            if($(this).val() == event.item.id)
            {
                console.log('remove: ' + event.item.id);
                $('#trbAfectados').tagsinput('remove', {id : event.item.id});
                $('#trbAfectados').tagsinput('refresh');
            }
        });

        $('#frmIncidente').formValidation('validateField', 'fecha');
        //$(".twitter-typeahead").css('display', 'inline');
    });

    $('#btnAddAfectado').on('click',function(){
        if($('#trbAfectados').val() != '' && $('#fecha').val() != '' ){
            var trabajadores = $('#trbAfectados').val().split(',');

            trabajadores.forEach(function(val){
                $.ajax({
                    url: $('#listAfectados').data('url') + val + '/'+ $('#fecha').val() ,
                    type: 'GET'
                }).done(function(data) {
                    if(data.status == true)
                    {
                        var source   = $("#afectado-template").html();
                        var li = Handlebars.compile(source);
                        var html = li(data);

                        $('#ulAfectados').append(html).hide().fadeIn('slow');
                        $("#trbAfectados").tagsinput('removeAll');
                        $("#trbAfectados").tagsinput('focus');
                    }
                    console.log(data);
                    console.log("success");
                });
            });
        }
        else{
            $('#frmIncidente').formValidation('validateField', 'fecha');
        }
    });

    $('#btnRemoveAfectados').on('click',function(){
        var checkboxValues = new Array();
        $('input[name="removeAfectado[]"]:checked').each(function() {
            checkboxValues.push($(this).val());
        });

        if(checkboxValues.length > 0)
        {
            BootstrapDialog.confirm('Desea quitar los trabajadores seleccionados', function(result){
                if(result) {
                    checkboxValues.forEach(function(val){
                        $('input[name="trAfeCargo[]"]').each(function() {
                            if($(this).val() == val)
                            {
                                console.log('quitando: ' + val);
                                $(this).closest('li').fadeOut('slow',function(){ $(this).remove(); });
                            }
                        });
                    });
                }
            });
        }
    });
});
