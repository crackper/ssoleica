<div id="modalAsignarContratoShow" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Asignar a nuevo Proyecto</h4>
      </div>
      <div class="modal-body">
           <form id="formAsignarContrato" method="post" action="/trabajador/asignarcontrato/{!! $data['trabajador_id'] !!}" role="form">
                <div class="form-group">
                    {!! Form::label('proyecto_id', 'Proyectos', array('class' => 'control-label')) !!}
                    {!! Form::select('proyecto_id',$data['proyectos'],null,array('class' => 'form-control input-sm','data-toggle' => 'select')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
                <div class="form-group">
                    <label for="contrato_id" class="control-label">Contrato</label>
                    <select class="form-control input-sm" data-toggle="select" id="contrato_id" name="contrato_id" data-header="Selecciona un Contrato">
                    </select>
                </div>
                <div class="form-group">
                    <label for="fecInicio" class="control-label">Fecha Inicio Contrato:</label>
                    <input type="text" id="fecInicio" name="fecInicio" class="form-control input-sm date" data-toggle="date" required>
                </div>
                <div class="form-group">
                    <label for="nroFotocheck" class="control-label">Nro. Fotocheck</label>
                    <input type="text" id="nroFotocheck" name="nroFotocheck" class="form-control input-sm"/>
                </div>
                <div class="form-group">
                    <label for="fecVencimiento" class="control-label">Fecha de Vencimiento Fotocheck:</label>
                    <input type="text" id="fecVencimiento" name="fecVencimiento" class="form-control input-sm date" data-toggle="date" required>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" id="btnAsignarContrato" class="btn btn-primary" data-update="contrato" data-url="/trabajador/asignarcontrato/" >Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>