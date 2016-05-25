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
            type: 'POST',
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

    $(document).on('show.bs.modal','#modalAddAccionShow',function(event){
        //$(document).trigger('ready');
        console.log("no sale-----------------");

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

    });
});