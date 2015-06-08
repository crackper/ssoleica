<div class="row">
    <div class="col-md-12">
         <button id="addExamenMedico"  type="button"
            data-url="/trabajador/addvencimiento/documento/{!! $trabajador_id!!}/0/"
            data-type="documento"
            class="btn btn-warning btn-sm addVencimiento">
            <span class="glyphicon glyphicon-th-list"></span>
            Agregar Documento
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
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">Documentos</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" data-toogle="documentos">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Documento</th>
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
                        <td>{!! $row->documento !!}</td>
                        <td class="text-center">
                        <div>
                            <input type="text" value="{!!$row->fecha_vencimiento !!}" data-toggle="date" class="form-control input-sm date" style="width: 7em;" />
                        </div>
                        </td>
                        <td class="text-center">{!! Form::checkbox('caduca', 1, $row->caduca == 1 ? true : false ,array('class'=>'form-control input-sm checkbox')); !!}</td>
                        <td><input type="text" class="form-control input-sm obs" value="{!! $row->observaciones !!}"></td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm update-vencimiento" data-loading-text="Actualizando..."  data-vencimiento="{!! $row->id !!}" >
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
                            <button type="button" class="btn btn-danger btn-sm update-vencimiento" data-loading-text="Actualizando..."  data-examen="0" >
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