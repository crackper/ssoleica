<div  class="table-responsive">
    <table id="detalle" class="table table-striped table-hover table-condensed">
        <thead>
            <th>#</th>
            <th>Trabajador</th>
            <th>Cargo</th>
            <th>Horas/Mes</th>
            <th></th>
        </thead>
        <tbody>
        @foreach($trabajadores as $key => $row)
            <tr>
                <td>{!! $key + 1 !!}</td>
                <td>{!! $row->trabajador !!}</td>
                <td>{!! $row->cargo !!}</td>
                <td>
                    <div>
                    <input type="hidden" id="trabajador[]" name="trabajador[]" value="{!! $row->trabajador_id !!}"/>
                    <input type="hidden" id="ingreso[]" name="ingreso[]" value="{!! $row->inicio_contrato !!}"/>
                    <input type="text" name="horas[]"
                    class="form-control input-sm horasHombre"
                    style="width: 6em;"
                    data-toggle="horas" value="0"
                    data-hrsmax ="{!! $row->jorn_max_trabajador !!}" />
                    </div>
                </td>
                <td><small>Max. {!! $row->jorn_max_trabajador !!} Hrs.</small></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if(count($trabajadores) > 0)
        <button type="submit" id="btnRegistrar" class="btn btn-success">Registrar Horas Hombre</button>
    @endif
     <a href="/horasHombre" class="btn btn-danger">Cancelar</a>
</div>