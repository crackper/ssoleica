<div id="modalAddExamenShow" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Agregar Exámen Médico</h4>
      </div>
      <div class="modal-body">
           <form id="formAddExamen" method="post" action="/trabajador/addexamen/{!! $trabajador_id !!}/{!! $operacion_id !!}" role="form">
                <div class="form-group">
                    {!! Form::label('examen_id', 'Examen', array('class' => 'control-label')) !!}
                    {!! Form::select('examen_id',$examenes,null,array('class' => 'form-control input-sm','data-toggle' => 'select')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
                <div class="form-group">
                    <label for="fecVencimiento" class="control-label">Fecha Vencimiento</label>
                    <input type="text" id="fecVencimiento" name="fecVencimiento" class="form-control input-sm date" data-toggle="date" required>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                      <label>
                        <input type="hidden" name="caduca" value="0">
                        {!! Form::checkbox('caduca', '1',array('class'=>'form-control input-sm checkbox')); !!}
                        Caduca
                      </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="observaciones" class="control-label">Observaciones:</label>
                     <textarea class="form-control" rows="3" id="observaciones" name="observaciones"></textarea>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" id="btnAddExamen" class="btn btn-primary" data-add="examen" data-url="/trabajador/asignarcontrato/" >Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>