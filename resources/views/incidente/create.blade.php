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
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
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
                            <select class="form-control input-sm" data-toggle="select" id="tipo_informe" name="tipo_informe">
                             </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipo_incidente" class="form-label col-sm-4">Tipo Incidente</label>
                        <div class="col-sm-8">
                            <select class="form-control input-sm" data-toggle="select" id="tipo_incidente" name="tipo_incidente">
                             </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fecha" class="form-label col-sm-4">Fecha y Hora</label>
                        <div class="col-sm-8">
                            <input type="text" id="fecha" name="fecha" class="form-control input-sm"/>
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
                            <select class="form-control input-sm" data-toggle="select" id="responsable" name="responsable">
                             </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-danger">
                  <div class="box-header with-border">
                    <h3 class="box-title">Trabajadores Afectados</h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button id="btnAddAfectado" class="btn btn-box-tool" data-toggle="tooltip" title="Agregar Trabajador" data-widget="chat-pane-toggle"><i class="fa fa-user-plus"></i></button>
                    </div>
                  </div><!-- /.box-header -->
                  <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="#" data-toggle="collapse" data-target="#masInfo" aria-expanded="false" aria-controls="masInfo"><i class="fa fa-caret-right"></i> Sent
                            <button class="label btn btn-box-tool pull-right" data-toggle="tooltip" title="Quitar Trabajador" data-widget="chat-pane-toggle"><i class="fa fa-user-times"></i> </button></a>
                            <div class="collapse" id="masInfo">
                              <div class="" style="padding: 5px 5px 0px 5px;">
                                    <ul class="list-group">
                                      <li class="list-group-item">RUT/DNI: 10123456</li>
                                      <li class="list-group-item">Antiguedad Cargo: 10/10/2010</li>
                                      <li class="list-group-item">Antiguedad Empresa: 15/10/2011</li>
                                    </ul>
                              </div>
                            </div>
                        </li>
                        <li><a href="#"><i class="fa fa-caret-right"></i> Sent <button class="label btn btn-box-tool pull-right" data-toggle="tooltip" title="Quitar Trabajador" data-widget="chat-pane-toggle"><i class="fa fa-user-times"></i> </button></a></li>
                        <li><a href="#"><i class="fa fa-caret-right"></i> Sent <button class="label btn btn-box-tool pull-right" data-toggle="tooltip" title="Quitar Trabajador" data-widget="chat-pane-toggle"><i class="fa fa-user-times"></i> </button></a></li>
                    </ul>
                  </div>
                </div>
                <div class="box box-warning">
                  <div class="box-header with-border">
                    <h3 class="box-title">Trabajadores Involucradros</h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button id="btnAddInvolucrado" class="btn btn-box-tool" data-toggle="tooltip" title="Agregar Trabajador" data-widget="chat-pane-toggle"><i class="fa fa-user-plus"></i></button>
                    </div>
                  </div><!-- /.box-header -->
                  <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="#" data-toggle="collapse" data-target="#masInfo2" aria-expanded="false" aria-controls="masInfo2"><i class="fa fa-caret-right"></i> Sent
                            <button class="label btn btn-box-tool pull-right" data-toggle="tooltip" title="Quitar Trabajador" data-widget="chat-pane-toggle"><i class="fa fa-user-times"></i> </button></a>
                            <div class="collapse" id="masInfo2">
                              <div class="" style="padding: 5px 5px 0px 5px;">
                                    <ul class="list-group">
                                      <li class="list-group-item">Antiguedad Cargo: 10/10/2010</li>
                                      <li class="list-group-item">Antiguedad Empresa: 15/10/2011</li>
                                    </ul>
                              </div>
                            </div>
                        </li>
                        <li><a href="#"><i class="fa fa-caret-right"></i> Sent <button class="label btn btn-box-tool pull-right" data-toggle="tooltip" title="Quitar Trabajador" data-widget="chat-pane-toggle"><i class="fa fa-user-times"></i> </button></a></li>
                        <li><a href="#"><i class="fa fa-caret-right"></i> Sent <button class="label btn btn-box-tool pull-right" data-toggle="tooltip" title="Quitar Trabajador" data-widget="chat-pane-toggle"><i class="fa fa-user-times"></i> </button></a></li>
                    </ul>
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
  </form>
</div>
<div id="modalView"></div>

@endsection

@section('styles')
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
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

<script src="/js/bootstrap-select.min.js"></script>
<script src="/js/jquery.mask.min.js"></script>
<script>
$(function(){
    $('select').selectpicker({
        size: 7
    });
});
</script>
@endsection