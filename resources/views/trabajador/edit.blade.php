@extends('app')

@section('pageheader')
    {!! $text !!}
@endsection

@section('breadcrumb')
    <li>General</li>
    <li><a href="/trabajador">Trabajadores</a></li>
    <li class="active">Editar</li>
@endsection

@section('content')

@if (Session::has('message'))
    <div class="alert alert-success alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          {{ Session::get('message') }}
    </div>
@endif
<div id="tabTrabajador" role="tabpanel" class="nav-tabs-custom" data-url="/trabajador/proyectos/{!! $id !!}">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">Información General</a></li>
    <li role="presentation"><a href="#adicional" aria-controls="adicional" role="tab" data-toggle="tab">Información Adicional</a></li>
    <li role="presentation"><a href="#contrato" aria-controls="contrato" role="tab" data-toggle="tab">Operación/Contrato</a></li>
    <li role="presentation" class="dropdown">
        <a aria-expanded="false" href="#" id="examenesMedicos" data-url="/trabajador/proyectostrabajador/{!! $id !!}"  data-trabajador="{!! $id !!}" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents">Exámenes Medicos <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
        </ul>
      </li>
    <li role="presentation"><a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab"
        data-url="/trabajador/documentos/{!! $id !!}">Otros Documentos</a></li>
    <li class="pull-right"><a href="/trabajador/ficha/{{ $id }}" class="text-muted" data-toggle='tooltip' data-placement='top' title='Imprimir Ficha'><i class="fa fa-print"></i></a></li>

  </ul>
{!! $edit->header !!}
  <!-- Tab panes -->
  <div class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="general">
        <div class="row" style="padding: 0px 10px 0px 10px;">
            <div class="col-sm-12">
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
                <div class="form-group @if($edit->field('sexo')->has_error) has-error @endif">
                   <label for="sexo" class="col-md-2 control-label required">Sexo</label>
                    <div class="col-sm-5">
                      {!! $edit->field('sexo') !!}
                    </div>
                    @if($edit->field('sexo')->has_error)
                         <span class="help-block">
                             <span class="glyphicon glyphicon-warning-sign"></span>
                             {!! $edit->field('sexo')->message !!}
                         </span>
                     @endif
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
                <div class="form-group @if($edit->field('fecha_ingreso')->has_error) has-error @endif">
                   <label for="fecha_ingreso" class="col-md-2 control-label required">Fecha de Ingreso</label>
                    <div class="col-sm-5">
                      {!! $edit->field('fecha_ingreso') !!}
                    </div>
                    @if($edit->field('fecha_ingreso')->has_error)
                        <span class="help-block">
                            <span class="glyphicon glyphicon-warning-sign"></span>
                            {!! $edit->field('fecha_ingreso')->message !!}
                        </span>
                    @endif
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
                <div class="form-group @if($edit->field('fecha_ini_cargo')->has_error) has-error @endif">
                   <label for="fecha_ini_cargo" class="col-md-2 control-label required">Fecha Inicio Cargo</label>
                    <div class="col-sm-5">
                      {!! $edit->field('fecha_ini_cargo') !!}
                    </div>
                    @if($edit->field('fecha_ini_cargo')->has_error)
                        <span class="help-block">
                            <span class="glyphicon glyphicon-warning-sign"></span>
                            {!! $edit->field('fecha_ini_cargo')->message !!}
                        </span>
                    @endif
                 </div>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="adicional">
        <div class="row" style="padding: 0px 10px 0px 10px;">
            <div class="col-sm-12">
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
                   <label for="lic_categoria_id" class="col-md-2 control-label required">Tipo Lic. Conducir</label>
                    <div class="col-sm-5">
                      {!! $edit->field('lic_categoria_id') !!}
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
                <fileset>
                    <legend>Información de Salud</legend>
                          <div class="form-group">
                              <label for="Enfermedades" class="col-md-2 control-label required">Enfermedades</label>
                              <div class="col-sm-5">
                                {!! $edit->field('Enfermedades') !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="Medicamentos" class="col-md-2 control-label required">Medicamentos</label>
                              <div class="col-sm-5">
                                {!! $edit->field('Medicamentos') !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="Alergias" class="col-md-2 control-label required">Alergias</label>
                              <div class="col-sm-5">
                                {!! $edit->field('Alergias') !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="Accidentes" class="col-md-2 control-label required">Accidentes</label>
                              <div class="col-sm-5">
                                {!! $edit->field('Accidentes') !!}
                              </div>
                          </div>
                </fileset>
                <fieldset>
                    <legend>Otros Datos</legend>
                    <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label for="TCamisa" class="col-md-6 control-label required">Talla Camisa</label>
                              <div class="col-sm-6">
                                {!! $edit->field('TCamisa') !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="TZapatos" class="col-md-6 control-label required">Talla Zapatos</label>
                              <div class="col-sm-6">
                                {!! $edit->field('TZapatos') !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="TPolo" class="col-md-6 control-label required">Talla Polo</label>
                              <div class="col-sm-6">
                                {!! $edit->field('TPolo') !!}
                              </div>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label for="TCasaca" class="col-md-6 control-label required">Talla Casaca</label>
                              <div class="col-sm-6">
                                {!! $edit->field('TCasaca') !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="TChaleco" class="col-md-6 control-label required">Talla Chaleco</label>
                              <div class="col-sm-6">
                                {!! $edit->field('TChaleco') !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="TPantalon" class="col-md-6 control-label required">Talla Pantalon</label>
                              <div class="col-sm-6">
                                {!! $edit->field('TPantalon') !!}
                              </div>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label for="TGuantes" class="col-md-6 control-label required">Talla Guantes</label>
                              <div class="col-sm-6">
                                {!! $edit->field('TGuantes') !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="TRespirador" class="col-md-6 control-label required">Talla Respirador</label>
                              <div class="col-sm-6">
                                {!! $edit->field('TRespirador') !!}
                              </div>
                          </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="contrato">...</div>
    <div role="tabpanel" class="tab-pane fade" id="examenes"><h1>Examenes Medicos</h1></div>
    <div role="tabpanel" class="tab-pane fade" id="documentos">...</div>
    <div class="row">
        <div class="col-sm-12" style="padding: 0px 10px 0px 30px;">
            {!! $edit->footer !!}
        </div>
      </div>
  </div>
</div>
<div id="modalView"></div>

@endsection

@section('styles')
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{ url('/css/formValidation.min.css') }}">
    <link rel="stylesheet" href="/css/bootstrap-dialog.min.css"/>
<style type="text/css">
.has-error .form-control-feedback {
    color: #E74C3C;
}
.has-success .form-control-feedback {
    color: #18BCA0;
}
</style>
@endsection

@section('scripts')

    {!! Rapyd::head() !!}
<script src="/js/bootstrap-select.min.js"></script>
<script src="/js/jquery.mask.min.js"></script>
{!! HTML::script('/js/plugins/formValidation.min.js') !!}
 {!! HTML::script('/js/plugins/bootstrap.min.js') !!}
<script src="/js/bootstrap-dialog.min.js"></script>
{!! Minify::javascript('/js/plugins/formValidation.es_ES.js') !!}
{!! Minify::javascript('/js/app/trabajador.edit.js') !!}
@if (Session::has('message'))
    <script>
        $(function(){
            BootstrapDialog.alert({
                title:'SSO Leica Geosystems',
                message: '{{ Session::get('message') }}'
            });
        });
    </script>
@endif

@endsection