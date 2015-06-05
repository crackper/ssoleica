 <div class="row">
    <div class="col-md-12">
         <button id="addExamenMedico"  type="button"
            data-url="/trabajador/addexamen/{!! $trabajador_id!!}/{!! $operacion_id !!}/{!! $proyecto !!}"
            class="btn btn-warning btn-sm">
            <span class="glyphicon glyphicon-th-list"></span>
            Agregar Examen Médico
         </button>
    </div>
 </div>
<br/>
<div class="row">
    <div class="col-md-6 mensaje">

    </div>
</div>
<div class="row">
    <div class="col-md-10">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Proyecto: {!! $proyecto !!}</h3>
            </div>
            <div class="table-responsive">
                <table id="gridExamenes" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Exámen Médico</th>
                        <th>Fecha Vencimiento</th>
                        <th>Caduca</th>
                        <th>Comentario</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $key => $row)
                    <tr>
                        <td class="text-center">{!! $key+1 !!}</td>
                        <td>{!! $row->examen_medico !!}</td>
                        <td class="text-center">
                        <div>
                            <input type="text" value="{!!$row->fecha_vencimiento !!}" data-toggle="date" class="form-control input-sm date" style="width: 7em;" />
                        </div>
                        </td>
                        <td class="text-center">{!! Form::checkbox('caduca', 1, $row->caduca == 1 ? true : false ,array('class'=>'form-control input-sm checkbox')); !!}</td>
                        <td><input type="text" class="form-control input-sm obs" value="{!! $row->observaciones !!}"></td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm update-examen" data-loading-text="Actualizando..."  data-examen="{!! $row->id !!}" >
                                <span class="glyphicon glyphicon-calendar"></span> Actualizar
                            </button>
                        </td>
                    </tr>
                @endforeach
                    <tr class="hide">
                        <td class="text-center">0</td>
                        <td>Examen 0</td>
                        <td class="text-center">
                        <div>
                            <input type="text" data-toggle="date" class="form-control input-sm date" style="width: 7em;" />
                        </div>
                        </td>
                        <td class="text-center">
                            <input type="checkbox" class="form-control input-sm checkbox"/>
                        </td>
                        <td><input type="text" class="form-control input-sm obs"></td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm update-examen" data-loading-text="Actualizando..."  data-examen="0" >
                                <span class="glyphicon glyphicon-calendar"></span> Actualizar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>