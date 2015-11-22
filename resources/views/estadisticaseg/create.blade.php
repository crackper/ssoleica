@extends('app')

  @section('pageheader')
     Registrar Estadisticas de Seguridad
  @endsection

 @section('breadcrumb')
     <li>Estadisticas Seguridad</li>
     <li><a href="/estadisticas">Estadisticas</a></li>
     <li class="active">Registrar</li>
 @endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body" >
                    <form id="frmRegistrarEstadisticas" action="/estadisticas/create" method="post" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="" class="col-md-2 control-label">Proyecto</label>
                    <div class="col-md-4">
                        {!! Form::select('proyecto_id',$proyectos,null,array('id'=> 'proyecto_id', 'class' => 'form-control input-sm','data-toggle' => 'select')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-md-2 control-label">Contrato</label>
                    <div class="col-md-4">
                        <select class="form-control input-sm" data-toggle="select" id="contrato_id" name="contrato_id" data-header="Selecciona un Contrato">
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-md-2 control-label">Mes</label>
                    <div class="col-md-4">
                    <select class="form-control input-sm" data-toggle="select" id="month_id" name="month_id" data-header="Selecciona un Mes"></select>
                    </div>
                </div>
                 <div class="form-group">
                     <label for="dotacion" class="col-md-2 control-label">Dotación</label>
                     <div class="col-md-4">
                        <input type="text" id="dotacion" name="dotacion" class="form-control input-sm" data-toggle="dotacion"/>
                     </div>
                 </div>
                <div class="form-group">
                    <label for="cantDiasPerdidos" class="col-md-2 control-label">Cant. Dias Perdidos</label>
                    <div class="col-md-4">
                        <input type="text" id="cantDiasPerdidos" name="cantDiasPerdidos" class="form-control input-sm" data-toggle="perdidos"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="stp" class="col-md-2 control-label">Incidentes STP</label>
                    <div class="col-md-4">
                        <input type="text" id="stp" name="stp" class="form-control input-sm" data-toggle="incidente" value="0"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ctp" class="col-md-2 control-label">Incidentes CTP</label>
                    <div class="col-md-4">
                        <input type="text" id="ctp" name="ctp" class="form-control input-sm" data-toggle="incidente" value="0"/>
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
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
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
 <script src="/js/bootstrap-select.min.js"></script>
 <script src="/js/jquery.mask.min.js"></script>
 {!! HTML::script('/js/plugins/formValidation.min.js') !!}
 {!! HTML::script('/js/plugins/bootstrap.min.js') !!}
 <script src="/js/bootstrap-dialog.min.js"></script>
 {!! Minify::javascript('/js/app/estadisticasSeg.create.js') !!}
 <script>

 </script>
@endsection