<div id="modalAddAccionShow" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Agregar {!! $title !!} </h4>
      </div>
      <div class="modal-body">
           <form id="formAddAccion" method="post" action="/incidente/add-accion/{{ $type }}/{{ $incidente }}" role="form">
                <div class="form-group">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <label for="descripcion" class="control-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" cols="30" rows="8" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="fecComprometida" class="control-label">Fecha Comprometida</label>
                    <input type="text" id="fecComprometida" name="fecComprometida" class="form-control input-sm date" data-toggle="date" required/>
                </div>
                <div class="form-group">
                    <label for="responsables" class="control-label">Responsable(s):</label>
                     <input type="text" id="resp" name="resp" placeholder="Apellidos o Nombres ..." class="form-control autocompleter" required/>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" id="btnSaveAccion" class="btn btn-primary" data-add="accion" >Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>