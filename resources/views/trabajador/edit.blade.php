@extends('app')

@section('content')
{!! Rapyd::styles() !!}
{!! $edit->header !!}
<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">Información General</a></li>
    <li role="presentation"><a href="#adicional" aria-controls="adicional" role="tab" data-toggle="tab">Información Adicional</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="general">
        <div class="row" style="padding: 15px 0px 0px 0px;">
            <div class="form-group @if($edit->field('dni')->has_error) has-error @endif">
                <label for="dni" class="col-sm-2 control-label required">Dni</label>
                <div class="col-md-5">
                    {!! $edit->field('dni')!!}
                </div>
                @if($edit->field('dni')->has_error)
                    <span class="help-block">
                        <span class="glyphicon glyphicon-warning-sign"></span>
                        {!! $edit->field('dni')->message !!}
                    </span>
                @endif
            </div>
            <div class="form-group @if($edit->field('nombre')->has_error) has-error @endif">
               <label for="nombre" class="col-md-2 control-label required">Nombre</label>
                <div class="col-sm-5">
                  {!! $edit->field('nombre') !!}
                </div>
                @if($edit->field('nombre')->has_error)
                    <span class="help-block">
                        <span class="glyphicon glyphicon-warning-sign"></span>
                        {!! $edit->field('nombre')->message !!}
                    </span>
                @endif
              </div>
            <div class="form-group @if($edit->field('app_paterno')->has_error) has-error @endif">
                <label for="app_materno" class="col-md-2 control-label required">Apellido Paterno</label>
                <div class="col-sm-5">
                    {!! $edit->field('app_paterno') !!}
                </div>
                @if($edit->field('app_paterno')->has_error)
                    <span class="help-block">
                        <span class="glyphicon glyphicon-warning-sign"></span>
                        {!! $edit->field('app_paterno')->message !!}
                    </span>
                @endif
            </div>
            <div class="form-group @if($edit->field('app_materno')->has_error) has-error @endif">
               <label for="app_materno" class="col-md-2 control-label required">Apellido Materno</label>
                <div class="col-sm-5">
                  {!! $edit->field('app_materno') !!}
                </div>
                @if($edit->field('app_materno')->has_error)
                    <span class="help-block">
                        <span class="glyphicon glyphicon-warning-sign"></span>
                        {!! $edit->field('app_materno')->message !!}
                    </span>
                @endif
            </div>
            <div class="form-group">
               <label for="sexo" class="col-md-2 control-label required">Sexo</label>
                <div class="col-sm-5">
                  {!! $edit->field('sexo') !!}
                </div>
              </div>
            <div class="form-group @if($edit->field('fecha_nacimiento')->has_error) has-error @endif">
               <label for="fecha_nacimiento" class="col-md-2 control-label required">Fecha de Nacimiento</label>
                <div class="col-sm-5">
                  {!! $edit->field('fecha_nacimiento') !!}
                </div>
                @if($edit->field('fecha_nacimiento')->has_error)
                    <span class="help-block">
                        <span class="glyphicon glyphicon-warning-sign"></span>
                        {!! $edit->field('fecha_nacimiento')->message !!}
                    </span>
                @endif
             </div>
            <div class="form-group">
               <label for="estad0_civil" class="col-md-2 control-label required">Estado Civil</label>
                <div class="col-sm-5">
                  {!! $edit->field('estado_civil') !!}
                </div>
             </div>
            <div class="form-group">
               <label for="direccion" class="col-md-2 control-label required">Dirección</label>
                <div class="col-sm-5">
                  {!! $edit->field('direccion') !!}
                </div>
             </div>
            <div class="form-group">
               <label for="nro_telefono" class="col-md-2 control-label required">Nro de Telefono</label>
                <div class="col-sm-5">
                  {!! $edit->field('nro_telefono') !!}
                </div>
             </div>
            <div class="form-group">
               <label for="fecha_ingreso" class="col-md-2 control-label required">Fecha de Ingreso</label>
                <div class="col-sm-5">
                  {!! $edit->field('fecha_ingreso') !!}
                </div>
             </div>
            <div class="form-group">
               <label for="profesion_id" class="col-md-2 control-label required">Profesión</label>
                <div class="col-sm-5">
                  {!! $edit->field('profesion_id') !!}
                </div>
             </div>
            <div class="form-group">
               <label for="cargo_id" class="col-md-2 control-label required">Cargo</label>
                <div class="col-sm-5">
                  {!! $edit->field('cargo_id') !!}
                </div>
             </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="adicional">
        <div class="row" style="padding: 15px 0px 0px 0px;">
            <div class="form-group">
               <label for="foto" class="col-md-2 control-label required">Foto</label>
                <div class="col-sm-5">
                  {!! $edit->field('foto') !!}
                </div>
             </div>
            <div class="form-group">
               <label for="grupo_sanguineo" class="col-md-2 control-label required">Grupo Sanguineo</label>
                <div class="col-sm-5">
                  {!! $edit->field('grupo_saguineo') !!}
                </div>
             </div>
            <div class="form-group">
               <label for="lic_conducir" class="col-md-2 control-label required">Lic. de Conducir</label>
                <div class="col-sm-5">
                  {!! $edit->field('lic_conducir') !!}
                </div>
             </div>
             <div class="form-group">
                <label for="email" class="col-md-2 control-label required">E-mail</label>
                 <div class="col-sm-5">
                   {!! $edit->field('email') !!}
                 </div>
              </div>
            <fielset>
                <legend>En caso de emergencia</legend>
                    <div class="form-group">
                        <label for="em_nombres" class="col-md-2 control-label required">Contactar a</label>
                        <div class="col-sm-5">
                        {!! $edit->field('em_nombres') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="em_telef_fijo" class="col-md-2 control-label required">Telefono Fijo</label>
                        <div class="col-sm-5">
                        {!! $edit->field('em_telef_fijo') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="em_telef_celular" class="col-md-2 control-label required">Felefono Celular</label>
                        <div class="col-sm-5">
                        {!! $edit->field('em_telef_celular') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="em_parentesco" class="col-md-2 control-label required">Parentesco</label>
                        <div class="col-sm-5">
                        {!! $edit->field('em_parentesco') !!}
                        </div>
                    </div>
                      <div class="form-group">
                          <label for="em_direccion" class="col-md-2 control-label required">Dirección</label>
                          <div class="col-sm-5">
                          {!! $edit->field('em_direccion') !!}
                          </div>
                      </div>
            </fielset>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="messages">...</div>
    <div role="tabpanel" class="tab-pane" id="settings">...</div>
  </div>

</div>
 {!! $edit->footer !!}

 {!! Rapyd::scripts() !!}
 {!! Rapyd::head() !!}
@endsection