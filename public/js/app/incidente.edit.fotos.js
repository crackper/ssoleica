/**
 * Created by Samuel on 31/03/16.
 */
$(document).ready(function () {
    'use strict';

    $('#des_situacion').redactor();
    $('#cons_posibles').redactor();
    $('#danios_mat').redactor();
    $('#desc_danios_mat').redactor();
    $('#danios_amb').redactor();
    $('#desc_danios_amb').redactor();
    $('.least-gallery').least({random: false});
    $('body').on('click','button.delete',function(){

        var ok = confirm('Desea Eliminar esta Imagen');

        if(ok)
        {
            var id = $(this).data('id');
            var url = $(this).data('url');

            $.getJSON(url, function(data) {

                if(data.success)
                {
                    $(".least-preview").slideToggle("slow");
                    $('#'+id).slideToggle("slow").remove();
                }
            });
        }
    });

    $('#foto').fileupload({
        url: $(this).data('url'),
        dataType: 'json',
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 4000000,
        previewMaxWidth: 70,
        previewMaxHeight: 70
    })
        .on('fileuploaddone', function (e, data) {

            //$('<p/>').text(data.result.fotos.fullPath).appendTo('#files');

            var li = $('<li id="'+ data.result.id +'"/>');
            var img = $('<img/>')
                .attr('src','/' + data.result.fotos.fullPathTumb)
                .attr('alt','SSOLeica');
            var caption="<button type='button' class='btn btn-primary delete' data-url='/incidente/delete-image/" + data.result.id + "' data-id='" + data.result.id + "' ><span class='fa fa-trash-o'/> Eliminar</button>";
            var a = $('<a class="" data-subtitle="Ver Imagen" data-caption="'+ caption +'"/>')
                .attr('href','/'+ data.result.fotos.fullPath)
                .attr('title','SSOLeica');

            $('.least-gallery').append(li.append(a.append(img)));

            $('.least-gallery').least({random: false});

            $('#progress .progress-bar').css('width','0%');

        })
        .on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        })
        .on('fileuploadadd', function (e, data) {
            data.context = $('<div/>').appendTo('#files');
            var node = $('<p/>');
            node.appendTo(data.context);
        })
        .on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                file = data.files[index],
                node = $(data.context.children()[index]);
            if (file.error) {
                node
                    .prepend(file.preview)
                    .append($('<span class="text-danger"/>').text(' ' + file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button')
                    .text('Upload')
                    .prop('disabled', !!data.files.error);
            }
        })
        .prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

});