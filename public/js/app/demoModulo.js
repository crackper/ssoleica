/**
 * Created by Samuel on 17/10/15.
 */
$(function(){
    var modulo = function(){

        function init(){
            $("#proyecto_id").change(CambiarContrato());
        }

        function CambiarContrato(){
            $("#contrato_id").empty();

            $.getJSON("/estadisticas/contratos/" + $("#proyecto_id").val(), function(data) {
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
                    $("#btnRegistrar").hide();
                }

                $("#contrato_id").selectpicker('refresh');

            });
        }

        return{
            init:init
        }
    }

    modulo.init();
});