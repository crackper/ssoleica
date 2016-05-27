
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="table-responsive">
                <table class="table table-striped table-condensed" data-toogle="acinmediata">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Acciones Inmediatas</th>
                        <th>Fecha Comprometida</th>
                        <th>Responsable(s)</th>
                        <th class="text-right">
                             <button type="button" class="btn btn-info btn-sm add-accion" data-type="inmediata" data-incidente="{{$incidente_id}}">
                                 <span class="fa fa-file"></span> Agregar Acción Inmediata
                             </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inmediatas as $key => $row )
                    <tr>
                        <td class="text-left">{{ $key + 1  }}</td>
                        <td>{!! html_entity_decode($row->accion) !!}</td>
                        <td class="text-center">{{ SSOLeica\Core\Helpers\Timezone::toLocal($row->fecha_comprometida,$timezone,'d/m/Y') }}</td>
                        <td class="text-left">{{ $row->responsablesLbl }}</td>
                        <td class="text-right">
                            <button type="button" class="btn btn-success btn-sm update-acinmediata" data-accion="0">
                                <span class="fa fa-edit"></span> Modificar
                            </button>
                            <button type="button" class="btn btn-danger btn-sm remove-acinmediata" data-accion="0" >
                                <span class="fa fa-trash"></span> Quitar
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    <tr class="hide">
                        <td class="text-center">0</td>
                        <td>Accion 0</td>
                        <td class="text-center">fecha 0</td>
                        <td class="text-center">Responsable 0</td>
                        <td class="text-right">
                            <button type="button" class="btn btn-success btn-sm update-acinmediata" data-accion="0">
                                <span class="fa fa-edit"></span> Modificar
                            </button>
                            <button type="button" class="btn btn-danger btn-sm remove-acinmediata" data-accion="0" >
                                <span class="fa fa-trash"></span> Quitar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="table-responsive">
                <table class="table table-striped table-condensed" data-toogle="acinmediata">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Acciones Inmediatas</th>
                        <th>Fecha Comprometida</th>
                        <th>Responsable(s)</th>
                        <th class="text-right">
                             <button type="button" class="btn btn-primary btn-sm add-accion" data-type="correctiva" data-incidente="{{$incidente_id}}">
                                 <span class="fa fa-file"></span> Agregar Acción Correctiva
                             </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">0</td>
                        <td>Accion 0</td>
                        <td class="text-center">fecha 0</td>
                        <td class="text-center">Responsable 0</td>
                        <td class="text-right">
                            <button type="button" class="btn btn-success btn-sm update-acinmediata" data-accion="0">
                                <span class="fa fa-edit"></span> Modificar
                            </button>
                            <button type="button" class="btn btn-danger btn-sm remove-acinmediata" data-accion="0" >
                                <span class="fa fa-trash"></span> Quitar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="table-responsive">
                <table class="table table-striped table-condensed" data-toogle="acinmediata">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Acciones Preventivas</th>
                        <th>Fecha Comprometida</th>
                        <th>Responsable(s)</th>
                        <th class="text-right">
                             <button type="button" class="btn btn-warning btn-sm add-accion" data-type="preventiva" data-incidente="{{$incidente_id}}">
                                 <span class="fa fa-file"></span> Agregar Acción Preventiva
                             </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">0</td>
                        <td>Accion 0</td>
                        <td class="text-center">fecha 0</td>
                        <td class="text-center">Responsable 0</td>
                        <td class="text-right">
                            <button type="button" class="btn btn-success btn-sm update-acinmediata" data-accion="0">
                                <span class="fa fa-edit"></span> Modificar
                            </button>
                            <button type="button" class="btn btn-danger btn-sm remove-acinmediata" data-accion="0" >
                                <span class="fa fa-trash"></span> Quitar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>