@extends('app')

 @section('content')
    <h3>Registrar Horas Hombre</h3>
    <h5>Fecha de Cierre: {!! $horasHombre->fecha_fin !!}</h5>
    @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible fade in" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              {{ Session::get('message') }}
        </div>
    @endif
    <br/>
    <form id="frmRegistrarHorasHombre" action="/horasHombre/update/{!! $horasHombre->id !!}" method="post" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-inline">
            <div class="form-group">
               <label for="month_id">Mes :</label>
               <input type="hidden" id="month_id" name="month_id" value="{!! $horasHombre->month_id !!}">
               <input type="text" class="form-control input-sm" value="{!! $horasHombre->mes->nombre !!}" disabled/>
              </div>
              <div class="form-group">
                <label for="proyecto_id">Proyecto :</label>
                <input type="hidden" id="proyecto_id" name="proyecto_id" value="{!! $horasHombre->contrato->operacion_id !!}">
                <input type="text" class="form-control input-sm" value="{!! $horasHombre->contrato->operacion->nombre_operacion !!}" disabled/>
              </div>
              <div class="form-group">
                <label for="contrato_id">Contrato :</label>
                <input type="hidden" id="contrato_id" name="contrato_id" value="{!! $horasHombre->contrato_id !!}">
                <input type="text" class="form-control input-sm" value="{!! $horasHombre->contrato->nombre_contrato !!}" disabled/>
              </div>
        </div>
        <br/>
        <div class="col-sm-10">
            <div  class="table-responsive">
                <table id="detalle" class="table table-striped table-hover table-condensed">
                    <thead>
                        <th>#</th>
                        <th>Trabajador</th>
                        <th>Cargo</th>
                        <th>Horas/Mes</th>
                    </thead>
                    <tbody>
                    @foreach($trabajadores as $key => $row)
                        <tr>
                            <td><b>{!! $key + 1 !!}</b></td>
                            <td>{!! $row->trabajador !!}</td>
                            <td>{!! $row->cargo !!}</td>
                            <td>
                                <input type="hidden" id="detalle[]" name="detalle[]" value="{!! $row->id !!}"/>
                                <input type="hidden" id="trabajador[]" name="trabajador[]" value="{!! $row->trabajador_id !!}"/>
                                <input type="text" name="horas[]"
                                class="form-control input-sm horasHombre"
                                style="width: 10em;"
                                data-toggle="horas" value="{!! $row->horas !!}"/>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <button type="submit" id="btnRegistrar" class="btn btn-success">Registrar Horas Hombre</button>
                 <a href="/horasHombre" class="btn btn-danger">Cancelar</a>
            </div>
        </div>
    </form>
 @endsection

 @section('styles')
     <link rel="stylesheet" href="/css/bootstrap-select.min.css">
     <link rel="stylesheet" href="/css/formValidation.min.css">
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
 <script src="/js/formvalidation/formValidation.min.js"></script>
 <script src="/js/formvalidation/framework/bootstrap.min.js"></script>
 <script src="/js/bootstrap-dialog.min.js"></script>
 {!! Minify::javascript('/js/app/horasHombre.edit.js') !!}

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