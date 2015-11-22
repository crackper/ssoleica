 @extends('app')

 @section('pageheader')
    {!! $text !!}
 @endsection

 @section('breadcrumb')
     <li>Administración</li>
     <li><a href="/user">Usuarios</a></li>
     <li class="active">Create</li>
 @endsection

@section('content')
<div class="container-fluid">
	<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body" >
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" id="frmCreateUser" role="form" method="POST" action="{{ url('/user/create') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-2 control-label">Nombre</label>
							<div class="col-md-6">

							    <input type="text" class="form-control input-sm autocompleter" id="trabajador_id" name="trabajador_id"  value="{{ old('trabajador_id') }}">
								<input type="hidden" class="form-control input-sm autocompleter " name="name" id="name" value="{{ old('name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">E-Mail</label>
							<div class="col-md-6">
								<input type="email" class="form-control input-sm" id="email" name="email" value="{{ old('email') }}">
							</div>
						</div>

                        <div class="form-group">
							<label class="col-md-2 control-label">Roles</label>
							<div class="col-md-6">
							    @foreach($roles as $key => $rol)
								    <label class="checkbox-inline">
                                        {!! Form::checkbox('roles[]', $key,   false )  !!} {{ $rol }}
                                    </label>
                                @endforeach
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control input-sm" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">Confirmar Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control input-sm" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
                                {!! Form::label('pais_id', 'Pais por defecto', array('class' => 'col-md-2 control-label')) !!}
                                <div class="col-md-6">
                                    {!! Form::select('pais_id',$paises,old('pais_id'),array('class' => 'form-control','data-toggle' => 'select')) !!}
                                </div>
                        </div>

                        <div class="form-group">
							<label class="col-md-2 control-label">Estado</label>
							<div class="col-md-6">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="active" id="active" value="1" checked>
                                    Activo
                                  </label>
                                </div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6">
								<button type="submit" class="btn btn-primary">
									Registrar
								</button>
								<a href="/user" class="btn btn-primary">Cancelar</a>
							</div>
						</div>
					</form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('styles')
    <link href="{{  url('/css/plugins/iCheck/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{ url('/css/formValidation.min.css') }}">
    <link rel="stylesheet" href="{{ url('/packages/zofe/rapyd/assets/autocomplete/autocomplete.css') }}"/>
    <link rel="stylesheet" href="{{ url('/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}"/>
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
 {!! HTML::script('/js/plugins/formValidation.min.js') !!}
  {!! HTML::script('/js/plugins/bootstrap.min.js') !!}

 <script src="{{ url('/packages/zofe/rapyd/assets/autocomplete/typeahead.bundle.min.js') }}"> </script>
 <script src="{{ url('/packages/zofe/rapyd/assets/template/handlebars.js') }}"></script>
  <script src="{{ url('/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
  {!! Minify::javascript('/js/app/user.create.js') !!}
 <script src="{{ url('/js/plugins/icheck.min.js') }}" type="text/javascript"></script>



    @if(old('name') && old('trabajador_id'))
        <script>
          $(function () {
           $('#trabajador_id').tagsinput('add', {"id":"{{ old('trabajador_id')  }}","name":"{{ old('name') }}"});
          });
        </script>
    @endif
@endsection
