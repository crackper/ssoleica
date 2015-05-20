<div id="modalCambiarContratoShow" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Cambiar de Contrato</h4>
      </div>
      <div class="modal-body">
            <div>
            <form role="form">
                <div class="form-group">
                    <label for="proyecto" class="control-label">Proyecto</label>
                    <input type="text" class="form-control input-sm" id="proyecto" value="{!! $data['proyecto'] !!}" disabled>
                </div>
                <div class="form-group">
                      <label for="contratoActual" class="control-label">Contrato actual</label>
                      <input type="text" class="form-control input-sm date" id="proyecto" value="{!! $data['contrato'] !!}" disabled>
                </div>
                <div class="form-group">
                    <label for="fecFinActual" class="control-label">Fecha Fin:</label>
                    <input type="text" id="fecFinActual" class="form-control input-sm" data-toggle="date">
                </div>
                <div class="form-group">
                    {!! Form::label('contrato_id', 'Asignar a', array('class' => 'control-label')) !!}
                    {!! Form::select('contrato_id',$data['contratos'],null,array('class' => 'form-control input-sm','data-toggle' => 'select')) !!}
                </div>
                <div class="form-group">
                    <label for="fecIniCambio" class="control-label">Fecha Inicio:</label>
                    <input type="text" id="fecIniCambio" class="form-control input-sm date" data-toggle="date">
                </div>
            </form>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-update="contrato" data-url="/trabajador/updatecontrato/{!! $data['contratoTrabajador'] !!}" >Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>