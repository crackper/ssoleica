<div id="modalCambiarContratoShow" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Cambiar de Contrato</h4>
      </div>
      <div class="modal-body">
            <form id="formUpdateContrato" method="post" action="/trabajador/savecontratotrabajador/{!! $data['contratoTrabajador'] !!}" role="form" data-contract="{!! $data['contratoTrabajador'] !!}">
                <div class="form-group">
                    <label for="proyecto" class="control-label">Proyecto</label>
                    <input type="text" class="form-control input-sm" id="proyecto" value="{!! $data['proyecto'] !!}" disabled>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
                <div class="form-group">
                      <label for="contratoActual" class="control-label">Contrato actual</label>
                      <input type="text" class="form-control input-sm date" id="proyecto" value="{!! $data['contrato'] !!}" disabled>
                </div>
                <div class="form-group">
                    <label for="fecFinActual" class="control-label">Fecha Fin:</label>
                    <input type="text" id="fecFinActual" name="fecFinActual" class="form-control input-sm" data-toggle="date" required>
                </div>
                <div class="form-group">
                    {!! Form::label('contrato_id', 'Asignar a', array('class' => 'control-label')) !!}
                    @if( $data['existContratos'])
                    {!! Form::select('contrato_id',$data['contratos'],null,array('class' => 'form-control input-sm','data-toggle' => 'select')) !!}
                    @else
                        <input type="text" class="form-control input-sm" value="No existen contratos disponibles" disabled>
                    @endif
                </div>
                <div class="form-group">
                    <label for="fecIniCambio" class="control-label">Fecha Inicio en Contrato:</label>
                    <input type="text" id="fecIniCambio" name="fecIniCambio" class="form-control input-sm date" data-toggle="date" required>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
         @if( $data['existContratos'])
        <button type="button" class="btn btn-primary" data-update="contrato" data-url="/trabajador/savecontratotrabajador/{!! $data['contratoTrabajador'] !!}" >Guardar Cambios</button>
        @endif
      </div>
    </div>
  </div>
</div>