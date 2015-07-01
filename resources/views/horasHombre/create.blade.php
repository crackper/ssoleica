 @extends('app')

 @section('content')
    <h3>Registrar Horas Hombre</h3>
    <br/>
    <form id="frmRegistrarHorasHombre" action="/horasHombre/create" method="post" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-inline">
              <div class="form-group">
                <label for="proyecto_id">Proyecto</label>
                <input type="hidden" id="proyecto" name="proyecto">
                {!! Form::select('proyecto_id',$proyectos,null,array('id'=> 'proyecto_id', 'class' => 'form-control input-sm','data-toggle' => 'select')) !!}
              </div>
              <div class="form-group">
                <label for="contrato_id">Contrato</label>
                <input type="hidden" id="contrato" name="contrato">
                <select class="form-control input-sm" data-toggle="select" id="contrato_id" name="contrato_id" data-header="Selecciona un Contrato">
                </select>
              </div>
              <div class="form-group">
                <label for="month_id">Mes </label>
                <input type="hidden" id="month" name="month">
                <select class="form-control input-sm" data-toggle="select" id="month_id" name="month_id" data-header="Selecciona un Mes"></select>
               </div>
            <button type="button" id="btnLoadTrabajadores" class="btn btn-primary">Cargar Trabajadores</button>
            <a id="btnCambiar" href="/horasHombre/create" class="btn btn-warning">Cambiar Selección</a>
        </div>
        <br/><br/>
        <div id="gridTrabajadores" class="col-sm-10"></div>
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
 {!! Minify::javascript('/js/app/horasHombre.create.js') !!}
 <script>

 </script>
 @endsection