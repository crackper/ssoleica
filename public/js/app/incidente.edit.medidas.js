/**
 * Created by Samuel on 1/04/16.
 */
$(function(){
    $('#tabIncidente a[href="#medidas"]').click(function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).data('url'),
            type: 'GET',
            success: function(data){
                $('#medidas').html(data);
            }
        })
    });
});
