 <div class="row">
    <div class="col-md-12">
         <button type="button" class="btn btn-warning btn-sm">
            <span class="glyphicon glyphicon-link"></span>
            Asignar a nuevo Proyecto
         </button>
    </div>
 </div>
<br/>
@foreach($data as $key => $row)

<div class="row">
    <div class="col-md-10">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Proyecto: {!! $row->contrato->operacion->nombre_operacion !!}</h3>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Contrato</th>
                            <th>Nro Fotocheck</th>
                            <th>Vencimiento</th>
                            <th>Observaciones</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{!! $row->contrato->nombre_contrato !!}</td>
                            <td>{!! $row->nro_fotocheck !!}</td>
                            <td>
                                <div>
                                    <input type="text" id="{!! $row->contrato_id!!}"  class="form-control input-sm date" style="width: 7em;" value="{!! date('Y-m-d',strtotime($row->fecha_vencimiento)) !!}"></td>
                                </div>
                            <td><input type="text" class="form-control input-sm obs" value="{!! $row->observaciones !!}"></td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm update" data-loading-text="Actualizando..."  data-contrato="{!! $row->id !!}" >
                                    <span class="glyphicon glyphicon-calendar"></span> Actualizar
                                </button>
                                <button type="button" class="btn btn-info btn-sm"  data-contrato="{!! $row->id !!}">
                                    <span class="glyphicon glyphicon-random"></span> Cambiar Proyecto
                                </button>

                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endforeach

<script>
    $('.date').datepicker({
        format: 'yyyy-m-d',
        language: 'es',
        autoclose: true
    });

    $('.update').on('click',function(e){
        e.preventDefault();

        var contrato = $(this).data('contrato');

        var fecha = $(this).closest('tr').find('input.date').val();
        var obs = $(this).closest('tr').find('input.obs').val();
        var token = $('input[name = _token]').val();

        var btn = $(this);

        //var validate = (fecha).match(/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/);

        if(fecha == '')
        {
            var alerta = '<div class="alert alert-danger alert-dismissable">';
                alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                alerta += 'Ingresa una fecha valida';
                alerta += '</div>';

             $(btn).closest('.table-responsive').append(alerta);
             $(btn).closest('tr').find('input.date').closest('div').addClass('has-error');

             return;
        }
        else
        {
             $(btn).closest('.table-responsive').find('.alert').remove();
             $(btn).closest('tr').find('input.date').closest('div').removeClass('has-error');
        }


        $.ajax({
            url: '/trabajador/updatefecha',
            type: 'POST',
            dataType: 'json',
            data: {'contrato': contrato, 'fecha': fecha, 'obs': obs,'_token': token},
            beforeSend: function(xhr){
                $(btn).button('loading');
            },
            success :function(data) {
                console.log('success update fecha vencimiento fotocheck ');

                var style = data.success == 1 ? 'info':'danger';

                var alerta = '<div class="alert alert-'+ style +' alert-dismissable">';
                    alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    alerta += data.data;
                    alerta += '</div>';

                $(btn).closest('.table-responsive').append(alerta);


                $(btn).button('reset');
            }
        });
    });
</script>