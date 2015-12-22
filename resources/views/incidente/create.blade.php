@extends('app')

@section('pageheader')
    Registar Nuevo Incidente
@endsection

@section('breadcrumb')
    <li>Seguridad</li>
    <li><a href="/incidentes">Incidentes</a></li>
    <li class="active">Registrar</li>
@endsection

@section('content')
<div id="tabIncidente" role="tabpanel" class="nav-tabs-custom">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">Información General</a></li>
    <li role="presentation"><a href="#circunstancias" aria-controls="circunstancias" role="tab" data-toggle="tab">Circunstancias/Descripción</a></li>
    <li role="presentation"><a href="#perdida" aria-controls="perdida" role="tab" data-toggle="tab">Perdidas</a></li>
    <li role="presentation"><a href="#danios" aria-controls="danios" role="tab" data-toggle="tab">Daños</a></li>
  </ul>
  <!-- Tab panes -->
  <form id="frmIncidente" action="/incidente/create" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="general">
        <div class="row" style="padding: 15px 15px 10px 15px;">
            <div class="col-sm-6">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="proyecto_id" class="form-label col-sm-4">Proyecto</label>
                        <div class="col-sm-8">
                        {!! Form::select('proyecto_id',$proyectos,null,array('id'=> 'proyecto_id', 'class' => 'form-control input-sm','data-toggle' => 'select')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contrato_id" class="form-label col-sm-4">Contrato</label>
                        <div class="col-sm-8">
                            <select class="form-control input-sm" data-toggle="select" id="contrato_id" name="contrato_id" data-header="Selecciona un Contrato">
                             </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipo_informe" class="form-label col-sm-4">Tipo Informe</label>
                        <div class="col-sm-8">
                            {!! Form::select('tipo_informe',$tipo_informe,null,array('id'=> 'tipo_informe', 'class' => 'form-control input-sm','data-toggle' => 'select')) !!}
                            </div>

                    </div>
                    <div class="form-group">
                        <label for="tipo_incidente" class="form-label col-sm-4">Tipo Incidente</label>
                        <div class="col-sm-8">
                            {!! Form::select('tipo_incidente',$tipo_incidente,null,array('id'=> 'tipo_incidente', 'class' => 'form-control input-sm','data-toggle' => 'select')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fecha" class="form-label col-sm-4">Fecha y Hora</label>
                        <div class="col-sm-8">
                            <input type="hidden" id="fecha_i" name="fecha_i"/>
                            <input type='text' class="form-control input-sm" id='fecha' name="fecha" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fecha" class="form-label col-sm-4">Lugar del Suceso</label>
                        <div class="col-sm-8">
                            <input type="text" id="lugar" name="lugar" class="form-control input-sm"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="punto" class="form-label col-sm-4">Punto Especifico</label>
                        <div class="col-sm-8">
                            <input type="text" id="punto" name="punto" class="form-control input-sm"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="equipos" class="form-label col-sm-4">Equipo(s) Afectado(s)</label>
                        <div class="col-sm-8">
                            <input type="text" id="equipos" name="equipos" class="form-control input-sm"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="parte" class="form-label col-sm-4">Parte</label>
                        <div class="col-sm-8">
                            <input type="text" id="parte" name="parte" class="form-control input-sm"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sector" class="form-label col-sm-4">Sector</label>
                        <div class="col-sm-8">
                            <input type="text" id="sector" name="sector" class="form-control input-sm"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="responsable" class="form-label col-sm-4">Jefe Responsable</label>
                        <div class="col-sm-8">
                            {!! Form::select('responsables',$trabajadores,null,array('id'=> 'responsables', 'class' => 'form-control input-sm','data-live-search'=>'true','data-toggle' => 'select')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-danger">
                  <div class="box-header with-border">
                    <h3 class="box-title" id="listAfectados" data-url="/incidente/trabajadorcargo/">Trabajadores Afectados</h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button type="button" id="btnRemoveAfectados" class="btn btn-box-tool" data-toggle="tooltip" title="Quitar Trabajadores" data-widget="chat-pane-toggle"><i class="fa fa-user-times"></i></button>
                    </div>
                  </div><!-- /.box-header -->
                  <div class="box-body no-padding">
                    <ul id="ulAfectados" class="nav nav-pills nav-stacked">
                    </ul>
                  </div>
                  <div class="box-footer">
                    <div class="form-horizontal">
                        <div class="input-group">
                          <div class="col-sm-10">
                            <input id="trbAfectados" placeholder="Apellidos o Nombres ..." class="form-control autocompleter" type="text">
                          </div>
                          <button type="button" id="btnAddAfectado" class="btn btn-danger btn-flat" data-loading-text="Agregando...">Agregar</button>
                        </div>
                    </div>
                  </div><!-- /.box-footer-->
                </div>
                <div class="box box-warning">
                   <div class="box-header with-border">
                    <h3 class="box-title" id="listInvolucrados" data-url="/incidente/trabajadorcargo/">Trabajadores Involucrados</h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button type="button" id="btnRemoveInvolucrados" class="btn btn-box-tool" data-toggle="tooltip" title="Quitar Trabajadores" data-widget="chat-pane-toggle"><i class="fa fa-user-times"></i></button>
                    </div>
                  </div><!-- /.box-header -->
                  <div class="box-body no-padding">
                    <ul id="ulInvolucrados" class="nav nav-pills nav-stacked">
                    </ul>
                  </div>
                  <div class="box-footer">
                    <div class="form-horizontal">
                        <div class="input-group">
                          <div class="col-sm-10">
                            <input id="trbInvolucrados" placeholder="Apellidos o Nombres ..." class="form-control autocompleter" type="text">
                          </div>
                          <button type="button" id="btnAddInvolucrado" class="btn btn-warning btn-flat" data-loading-text="Agregando...">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="circunstancias">
        <div class="row" style="padding: 0px 10px 0px 10px;">
            <div class="col-sm-12"></div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="pedidas">
        <div class="row" style="padding: 0px 10px 0px 10px;">
            <div class="col-sm-12"></div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="danios">
        <div class="row" style="padding: 0px 10px 0px 10px;">
            <div class="col-sm-12"></div>
        </div>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Guardar</button>
  </form>
</div>
<div id="modalView"></div>

@endsection

@section('styles')

    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="/css/formValidation.min.css">
     <link rel="stylesheet" href="/plugins/datetimepicker/css/bootstrap-datetimepicker.css">
     <link rel="stylesheet" href="/css/bootstrap-dialog.min.css"/>
<link rel="stylesheet" href="{{ url('/packages/zofe/rapyd/assets/autocomplete/autocomplete.css') }}"/>
    <link rel="stylesheet" href="{{ url('/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}"/>

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
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="/js/bootstrap-select.min.js"></script>
<script src="/js/jquery.mask.min.js"></script>
{!! HTML::script('/js/plugins/formValidation.min.js') !!}
 {!! HTML::script('/js/plugins/bootstrap.min.js') !!}
<script type="text/javascript" src="/plugins/datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="{{ url('/packages/zofe/rapyd/assets/autocomplete/typeahead.bundle.min.js') }}"> </script>
<script src="{{ url('/packages/zofe/rapyd/assets/template/handlebars.js') }}"></script>
<script src="{{ url('/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ url('/js/plugins/handlebars-v4.0.5.js') }}"></script>
<script src="/js/bootstrap-dialog.min.js"></script>
{!! Minify::javascript('/js/app/incidente.create.js') !!}

@include('incidente.afectados')

@endsection