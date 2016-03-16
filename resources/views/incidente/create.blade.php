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
<form id="frmIncidente" action="/incidente/create" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div id="tabIncidente" role="tabpanel" class="nav-tabs-custom">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">Información General</a></li>
    <li role="presentation"><a href="#circunstancias" aria-controls="circunstancias" role="tab" data-toggle="tab">Circunstancias/Descripción</a></li>
    <li role="presentation"><a href="#perdidas" aria-controls="perdidas" role="tab" data-toggle="tab">Perdidas</a></li>
    <li role="presentation"><a href="#danios" aria-controls="danios" role="tab" data-toggle="tab">Daños</a></li>
  </ul>
  <!-- Tab panes -->
    <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="general">
        @include('incidente.partial_c.general')
    </div>
    <div role="tabpanel" class="tab-pane fade" id="circunstancias">
        @include('incidente.partial_c.circunstancias')
    </div>
    <div role="tabpanel" class="tab-pane fade" id="perdidas">
        @include('incidente.partial_c.perdidas')
    </div>
    <div role="tabpanel" class="tab-pane fade" id="danios">
        <div class="row" style="padding: 0px 10px 0px 10px;">
         @include('incidente.partial_c.danios')
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" style="padding: 0px 10px 0px 30px;">
            <button type="submit" class="btn btn-primary">Guardar</button>
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
{!! Minify::javascript('/js/app/incidente.create.js') !!}

<script language="javascript" type="text/javascript">
    $(document).ready(function () {

     $('#des_situacion').redactor();
     $('#cons_posibles').redactor();
     $('#danios_mat').redactor();
     $('#desc_danios_mat').redactor();
     $('#danios_amb').redactor();
     $('#desc_danios_amb').redactor();

    });
</script>

@include('incidente.partial_c.afectados')

@endsection