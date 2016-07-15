@extends('app')

@section('pageheader')
    Editar Incidente
@endsection

@section('breadcrumb')
    <li>Seguridad</li>
    <li><a href="/incidente">Incidentes</a></li>
    <li class="active">Editar</li>
@endsection

@section('content')
<form id="frmIncidente" action="/incidente/edit/{{$incidente->id}}" method="post" enctype="multipart/form-data">
@if (Session::has('message'))
    <div class="alert alert-success alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          {{ Session::get('message') }}
    </div>
@endif
<div class="row" style="padding: 0px 10px 0px 10px;">
            <div class="col-md-12 mensaje">

            </div>
        </div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div id="tabIncidente" role="tabpanel" class="nav-tabs-custom">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">Información General</a></li>
    <li role="presentation"><a href="#circunstancias" aria-controls="circunstancias" role="tab" data-toggle="tab">Circunstancias/Descripción</a></li>
    <li role="presentation"><a href="#perdidas" aria-controls="perdidas" role="tab" data-toggle="tab">Perdidas</a></li>
    <li role="presentation"><a href="#danios" aria-controls="danios" role="tab" data-toggle="tab">Daños</a></li>
    <li role="presentation"><a href="#fotos" aria-controls="fotos" role="tab" data-toggle="tab">Fotografias</a></li>
    <li role="presentation"><a href="#medidas" aria-controls="medidas" role="tab" data-toggle="tab"
            data-url="/incidente/medidas-seguridad/{{ $incidente->id }}">Medidas de Seguridad</a></li>
    <li class="pull-right"><a href="/incidente/report/{{ $incidente->id }}" class="text-muted" data-toggle='tooltip' data-placement='top' title='Imprimir Incidente'><i class="fa fa-print"></i></a></li>
  </ul>
  <!-- Tab panes -->
    <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="general">
        @include('incidente.partial_e.general',$incidente)
    </div>
    <div role="tabpanel" class="tab-pane fade" id="circunstancias">
        @include('incidente.partial_e.circunstancias')
    </div>
    <div role="tabpanel" class="tab-pane fade" id="perdidas">
        @include('incidente.partial_e.perdidas')
    </div>
    <div role="tabpanel" class="tab-pane fade" id="danios">
        <div class="row" style="padding: 0px 10px 0px 10px;">
         @include('incidente.partial_e.danios')
        </div>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="fotos">
        <div class="row" style="padding: 0px 10px 0px 10px;">
         @include('incidente.partial_e.fotos')
        </div>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="medidas">

    </div>
    <div class="row">
        <div class="col-sm-12" style="padding: 0px 10px 0px 30px;">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</div>
</div>
</form>
<div id="modalView"></div>

@endsection

@section('styles')

    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="/css/formValidation.min.css">
     <link rel="stylesheet" href="/plugins/datetimepicker/css/bootstrap-datetimepicker.css">
     <link rel="stylesheet" href="/css/bootstrap-dialog.min.css"/>
<link rel="stylesheet" href="{{ url('/packages/zofe/rapyd/assets/autocomplete/autocomplete.css') }}"/>
    <link rel="stylesheet" href="{{ url('/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}"/>
    <link rel="stylesheet" href="{{ url('/plugins/redactor/redactor.css') }}"/>
    <link rel="stylesheet" href="{{ url('/plugins/fileupload/jquery.fileupload.css') }}"/>
    <link rel="stylesheet" href="{{ url('/plugins/leastjs/least.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('/packages/zofe/rapyd/assets/datepicker/datepicker3.css') }}"/>

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
<script src="{{ url('/plugins/redactor/redactor.min.js') }}"></script>
<script src="{{ url('/plugins/fileupload/vendor/jquery.ui.widget.js') }}"></script>
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="{{ url('/plugins/fileupload/jquery.iframe-transport.js') }}"></script>
<script src="{{ url('/plugins/fileupload/jquery.fileupload.js')}}"></script>
<script src="{{ url('/plugins/fileupload/jquery.fileupload-process.js')}}"></script>
<script src="{{ url('/plugins/fileupload/jquery.fileupload-image.js')}}"></script>
<script src="{{ url('/plugins/fileupload/jquery.fileupload-validate.js')}}"></script>
<script src="{{ url('/plugins/leastjs/least.min.js')}}"></script>
{!! Minify::javascript('/js/app/incidente.edit.js') !!}
{!! Minify::javascript('/js/app/incidente.addAccion.js') !!}
{!! Minify::javascript('/js/app/incidente.editAccion.js') !!}
{!! Minify::javascript('/js/app/incidente.edit.fotos.js') !!}
{!! Minify::javascript('/js/app/incidente.edit.medidas.js') !!}
<script src="{{ url('/packages/zofe/rapyd/assets/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ url('/packages/zofe/rapyd/assets/datepicker/locales/bootstrap-datepicker.it.js')}}"></script>
<script src="{{ url('/packages/zofe/rapyd/assets/datepicker/locales/bootstrap-datepicker.es.js')}}"></script>

<script language="javascript" type="text/javascript">

</script>

@include('incidente.partial_e.afectados')

@endsection