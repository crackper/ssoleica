 <div class="row">
    <div class="col-md-12">
         <button id="asignarContrato" data-trabajador-id="{!! $trabajador_id !!}"  type="button" class="btn btn-warning btn-sm">
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
                            <td><div data-toggle="{!! $row->id !!}">{!! $row->contrato->nombre_contrato !!}</div></td>
                            <td>{!! $row->nro_fotocheck !!}</td>
                            <td>
                                <div>
                                    <input type="text" id="{!! $row->contrato_id!!}"  class="form-control input-sm date" style="width: 7em;" value="{!! date('Y-m-d',strtotime($row->fecha_vencimiento)) !!}" data-toggle="date"></td>
                                </div>
                            <td><input type="text" class="form-control input-sm obs" value="{!! $row->observaciones !!}"></td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm update" data-loading-text="Actualizando..."  data-contrato="{!! $row->id !!}" >
                                    <span class="glyphicon glyphicon-calendar"></span> Actualizar
                                </button>
                                <button type="button" class="btn btn-info btn-sm change"
                                        data-proyecto="{!! $row->contrato->operacion->nombre_operacion !!}"
                                        data-proyecto-id = "{!! $row->contrato->operacion->id!!}"
                                        data-contrato = "{!! $row->contrato->nombre_contrato !!}"
                                        data-contrato-id="{!! $row->contrato->id !!}"
                                        data-contrato-trabajador ="{!! $row->id!!}">
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