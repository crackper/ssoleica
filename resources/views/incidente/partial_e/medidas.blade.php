
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="table-responsive">
                <table class="table table-striped table-condensed table-hover" data-toogle="acinmediata">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            Acciones Inmediatas
                        </th>
                        <th>Comprometido</th>
                        <th>Responsable(s)</th>
                        <th class="text-right">
                            <button type="button" class="btn btn-info btn-xs add-accion" data-type="inmediata" data-incidente="{{$incidente_id}}">
                                <span class="fa fa-file"></span> Agregar Acción
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inmediatas as $key => $row )
                    <tr>
                        <td class="text-left">{{ $key + 1  }}</td>
                        <td class="">{!! html_entity_decode($row->accion) !!}</td>
                        <td class="text-center">{{ Helper::to_timezone($row->fecha_comprometida,$timezone,'d/m/Y') }}</td>
                        <td class="text-left">{{ $row->responsablesLbl }}</td>
                        <td class="text-center">
                            <a href="#" class="update-accion" data-accion="{{ $row->id }}" data-original-title="Modificar Acción" data-toggle="tooltip" data-placement="left"><span class="fa fa-edit"></span></a>
                            <a href="#" class="remove-accion" data-accion="{{ $row->id }}" data-original-title="Quitar Acción" data-toggle="tooltip" data-placement="left"><span class="fa fa-trash"></span></a>
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
                <table class="table table-striped table-condensed table-hover" data-toogle="acinmediata">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Acciones correctivas</th>
                        <th>Comprometido</th>
                        <th>Responsable(s)</th>
                        <th class="text-right">
                             <button type="button" class="btn btn-primary btn-xs add-accion" data-type="correctiva" data-incidente="{{$incidente_id}}">
                                 <span class="fa fa-file"></span> Agregar Acción
                             </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($correctivas as $key => $row )
                    <tr>
                        <td class="text-left">{{ $key + 1  }}</td>
                        <td class="">{!! html_entity_decode($row->accion) !!}</td>
                        <td class="text-center">{{ Helper::to_timezone($row->fecha_comprometida,$timezone,'d/m/Y') }}</td>
                        <td class="text-left">{{ $row->responsablesLbl }}</td>
                        <td class="text-center">
                            <a href="#" class="update-accion" data-accion="{{ $row->id }}" data-original-title="Modificar Acción" data-toggle="tooltip" data-placement="left"><span class="fa fa-edit"></span></a>
                            <a href="#" class="remove-accion" data-accion="{{ $row->id }}" data-original-title="Quitar Acción" data-toggle="tooltip" data-placement="left"><span class="fa fa-trash"></span></a>
                        </td>
                    </tr>
                    @endforeach
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
                <table class="table table-striped table-condensed table-hover" data-toogle="acinmediata">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Acciones Preventivas</th>
                        <th>Comprometido</th>
                        <th>Responsable(s)</th>
                        <th class="text-right">
                             <button type="button" class="btn btn-warning btn-xs add-accion" data-type="preventiva" data-incidente="{{$incidente_id}}">
                                 <span class="fa fa-file"></span> Agregar Acción
                             </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($preventivas as $key => $row )
                    <tr>
                        <td class="text-left">{{ $key + 1  }}</td>
                        <td class="">{!! html_entity_decode($row->accion) !!}</td>
                        <td class="text-center">{{ Helper::to_timezone($row->fecha_comprometida,$timezone,'d/m/Y') }}</td>
                        <td class="text-left">{{ $row->responsablesLbl }}</td>
                        <td class="text-center">
                            <a href="#" class="update-accion" data-accion="{{ $row->id }}" data-original-title="Modificar Acción" data-toggle="tooltip" data-placement="left"><span class="fa fa-edit"></span></a>
                            <a href="#" class="remove-accion" data-accion="{{ $row->id }}" data-original-title="Quitar Acción" data-toggle="tooltip" data-placement="left"><span class="fa fa-trash"></span></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>