/**
 * Created by Samuel on 4/08/15.
 */
$(function(){

    Handlebars.setDelimiter('[!','!]');

    $('select').selectpicker({
        size: 7
    });

    $('#fecha').datetimepicker({
        sideBySide:true,
        locale: 'en',
        format: 'YYYY-MM-D HH:mm'
    }).on('dp.change',function(){
        $('#frmIncidente').formValidation('updateStatus', 'fecha', 'NOT_VALIDATED');
        $('#frmIncidente').formValidation('validateField', 'fecha');
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
                            var d = moment(value, 'YYYY-MM-DD HH:mm');

                            console.log(d);
                            console.log(d.isValid());

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
            },
            responsables: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione el Jefe Responsable'
                    }
                }
            },
            dias_perdidos:{
                validators: {
                    notEmpty: {
                        message: 'Ingrese la cantidad de Días perdidos, si los hubieron ingresar cero'
                    },
                    numeric:{
                        message: 'Ingrese la cantidad de Días perdidos, si los hubieron ingresar cero'
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

        $('#frmIncidente').formValidation('updateStatus', 'fecha', 'NOT_VALIDATED');
        $('#frmIncidente').formValidation('validateField', 'fecha');
        //$(".twitter-typeahead").css('display', 'inline');
    });

    $('#btnAddAfectado').on('click',function(){
        if($('#trbAfectados').val() != '' && $('#fecha').val() != '' ){

            $('#fecha_i').val($('#fecha').val());
            $("#fecha").attr('readonly', 'readonly');

            var trabajadores = $('#trbAfectados').val().split(',');

            trabajadores.forEach(function(val){
                $.ajax({
                    url: $('#listAfectados').data('url') + val + '/'+ $('#fecha').val() ,
                    type: 'GET',
                    beforeSend: function(xhr){
                        $('#btnAddAfectado').button('loading');
                    }
                }).done(function(data) {
                    if(data.status == true)
                    {
                        var source   = $("#afectado-template").html();
                        var li = Handlebars.compile(source);
                        var html = li(data);

                        $(html).appendTo('#ulAfectados').fadeOut().fadeIn('slow');
                        $("#trbAfectados").tagsinput('removeAll');
                        $("#trbAfectados").tagsinput('focus');
                    }
                    $('#btnAddAfectado').button('reset');
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
                        $('input[name="trbAfectado[]"]').each(function() {
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

    /**
     * Trabajadores Invlucrados
     * */

    $('#trbInvolucrados').tagsinput({
        itemValue: 'id',
        itemText: 'name',
        maxTags: 5,
        tagClass:'label label-primary'
    });

    $('#trbInvolucrados').tagsinput('input').typeahead(null, {
        name: 'name',
        displayKey: 'name',
        highlight: true,
        minLength: 2,
        source: blod_name.ttAdapter()
    }).bind('typeahead:selected', $.proxy(function (obj, data) {
        this.tagsinput('add', data);
        this.tagsinput('input').typeahead('val', '');
    }, $('#trbInvolucrados')));

    $('#trbInvolucrados').on('itemAdded', function(event) {

        console.log(event.item.id);

        $('input[name="trbInvolucrado[]"]').each(function() {
            if($(this).val() == event.item.id)
            {
                console.log('remove: ' + event.item.id);
                $('#trbInvolucrados').tagsinput('remove', {id : event.item.id});
                $('#trbInvolucrados').tagsinput('refresh');
            }
        });

        $('#frmIncidente').formValidation('updateStatus', 'fecha', 'NOT_VALIDATED');
        $('#frmIncidente').formValidation('validateField', 'fecha');

    });

    $('#btnAddInvolucrado').on('click',function(){
        $('#fecha_i').val($('#fecha').val());
        $("#fecha").attr('readonly', 'readonly');

        if($('#trbInvolucrados').val() != '' && $('#fecha').val() != '' ){
            var trabajadores = $('#trbInvolucrados').val().split(',');

            trabajadores.forEach(function(val){
                $.ajax({
                    url: $('#listInvolucrados').data('url') + val + '/'+ $('#fecha').val() ,
                    type: 'GET',
                    beforeSend: function(xhr){
                        $('#btnAddInvolucrado').button('loading');
                    }
                }).done(function(data) {
                    if(data.status == true)
                    {
                        var source   = $("#involucrado-template").html();
                        var li = Handlebars.compile(source);
                        var html = li(data);

                        //$('#ulAfectados').append(html);
                        $(html).appendTo('#ulInvolucrados').fadeOut().fadeIn('slow');
                        $("#trbInvolucrados").tagsinput('removeAll');
                        $("#trbInvolucrados").tagsinput('focus');
                    }
                    $('#btnAddInvolucrado').button('reset');
                });
            });
        }
        else{
            $('#frmIncidente').formValidation('validateField', 'fecha');
        }
    });

    $('#btnRemoveInvolucrados').on('click',function(){

        console.log('click remove remove');

        var checkboxValues = new Array();
        $('input[name="removeInvolucrado[]"]:checked').each(function() {
            checkboxValues.push($(this).val());
        });

        if(checkboxValues.length > 0)
        {
            BootstrapDialog.confirm('Desea quitar los trabajadores seleccionados', function(result){
                if(result) {
                    checkboxValues.forEach(function(val){
                        $('input[name="trbInvolucrado[]"]').each(function() {
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
