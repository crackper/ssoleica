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
                                            <td><input type="text" id="{!! $row->contrato_id!!}" class="form-control input-sm date" style="width: 7em;" value="{!! date('d/m/Y',strtotime($row->fecha_vencimiento)) !!}"></td>
                                            <td><input type="text" class="form-control input-sm" value="{!! $row->comentario !!}"></td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm">
                                                  <span class="glyphicon glyphicon-calendar"></span>
                                                  Actualizar
                                                </button>
                                                <button type="button" class="btn btn-info btn-sm">
                                                    <span class="glyphicon glyphicon-random"></span>
                                                        Cambiar Proyecto
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
        format: 'dd/mm/yyyy',
        language: 'es',
        autoclose: true
     });
    </script>