@extends('app')

  @section('pageheader')
     Registrar Estadisticas de Seguridad
     <small>Fecha de Cierre: {!! SSOLeica\Core\Helpers\Timezone::toLocal($std->fecha_fin,Session::get('timezone'),"d/m/Y h:i:s") !!}</small>
  @endsection

 @section('breadcrumb')
     <li>Estadisticas Seguridad</li>
     <li><a href="/estadisticas">Estadisticas</a></li>
     <li class="active">Editar</li>
 @endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body" >
                @if (Session::has('message'))
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                          {{ Session::get('message') }}
                    </div>
                @endif
                <br/>
                    <form id="frmRegistrarEstadisticas" action="/estadisticas/update/{!! $std->id !!}" method="post" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="" class="col-md-2 control-label">Proyecto</label>
                    <div class="col-md-4">
                        <input type="hidden" name="proyecto_id" id="proyecto_id" value="{!! $std->contrato->operacion_id !!}" />
                        <input type="text" name="proyecto" id="proyecto" class="form-control input-sm" value="{!! $std->contrato->operacion->nombre_operacion !!}" disabled  />
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-md-2 control-label">Contrato</label>
                    <div class="col-md-4">
                        <input type="hidden" name="contrato_id" id="contrato_id" value="{!! $std->contrato_id !!}"/>
                        <input type="text" name="contrato" id="contrato" class="form-control input-sm" value="{!! $std->contrato->nombre_contrato !!}" disabled/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-md-2 control-label">Mes</label>
                    <div class="col-md-4">
                        <input type="hidden" name="month_id" id="month_id" value="{!! $std->month_id !!}"/>
                        <input type="text" name="month" id="month" class="form-control input-sm" value="{!! $std->mes->nombre !!}" disabled />
                    </div>
                </div>
                 <div class="form-group">
                     <label for="dotacion" class="col-md-2 control-label">Dotación</label>
                     <div class="col-md-4">
                        <input type="text" id="dotacion" name="dotacion" class="form-control input-sm" data-toggle="dotacion" value="{!! (int)$std->dotacion !!}"/>
                     </div>
                 </div>
                <div class="form-group">
                    <label for="cantDiasPerdidos" class="col-md-2 control-label">Cant. Dias Perdidos</label>
                    <div class="col-md-4">
                        <input type="text" id="cantDiasPerdidos" name="cantDiasPerdidos" class="form-control input-sm" data-toggle="perdidos" value="{!! $std->dias_perdidos !!}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="stp" class="col-md-2 control-label">Incidentes STP</label>
                    <div class="col-md-4">
                        <input type="text" id="stp" name="stp" class="form-control input-sm" data-toggle="incidente" value="{!! $std->inc_stp !!}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ctp" class="col-md-2 control-label">Incidentes CTP</label>
                    <div class="col-md-4">
                        <input type="text" id="ctp" name="ctp" class="form-control input-sm" data-toggle="incidente" value="{!! $std->inc_ctp !!}"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4">
                        <button type="submit" id="btnRegistrar" class="btn btn-primary">Registrar</button>
                        <a href="/estadisticas" class="btn btn-primary">Cancelar</a>
                    </div>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
   

@endsection

@section('styles')
     <link rel="stylesheet" href="{{ url('/css/formValidation.min.css') }}">
     <link rel="stylesheet" href="/css/bootstrap-dialog.min.css"/>
     <style type="text/css">
     #frmRegistrarHorasHombre .selectContainer .form-control-feedback {
         /* Adjust feedback icon position */
         right: -15px;
     }
     .has-error .form-control-feedback {
        color: #E74C3C;
     }
     .has-success .form-control-feedback {
        color: #18BCA0;
     }
     </style>
@endsection

@section('scripts')
 <script src="/js/jquery.mask.min.js"></script>
{!! HTML::script('/js/plugins/formValidation.min.js') !!}
 {!! HTML::script('/js/plugins/bootstrap.min.js') !!}
 <script src="/js/bootstrap-dialog.min.js"></script>
 {!! Minify::javascript('/js/app/estadisticasSeg.edit.js') !!}
  @if (Session::has('message'))
      <script>
          $(function(){
              BootstrapDialog.alert({
                  title:'SSO Leica Geosystems',
                  message: '{{ Session::get('message') }}'
              });
          });
      </script>
 @endif>
 @endsection
