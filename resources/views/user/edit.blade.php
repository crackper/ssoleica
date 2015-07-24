@extends('app')

 @section('pageheader')
    {!! $text !!}
 @endsection

 @section('breadcrumb')
     <li>Administración</li>
     <li><a href="/user">Usuarios</a></li>
     <li class="active">Edit</li>
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

					<form class="form-horizontal" id="frmCreateUser" role="form" method="POST" action="{{ url('/user/update/'. $user->id) }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-2 control-label">Nombre</label>
							<div class="col-md-6">
                                <input type="text" class="form-control input-sm" name="name" id="name" value="{{ old('name')?old('name'):$user->name }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">E-Mail</label>
							<div class="col-md-6">
							    <p class="form-control-static">{{ old('email')? old('email'):$user->email }}</p>
								<input type="hidden" class="form-control input-sm" id="email" name="email" value="{{ old('email')? old('email'):$user->email }}">
							</div>
						</div>

                        <div class="form-group">
							<label class="col-md-2 control-label">Roles</label>
							<div class="col-md-6">
							    @foreach($roles as $rol)
								    <label class="checkbox-inline">
								        {!! Form::checkbox('roles[]', $rol->id, $rol->to_user )  !!}
								         {{ $rol->name }}
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
                                    {!! Form::select('pais_id',$paises,old('pais_id')?old('pais_id'):$user->pais_id ,array('class' => 'form-control','data-toggle' => 'select')) !!}
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
    <link rel="stylesheet" href="/css/formValidation.min.css">
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
 <script src="/js/formvalidation/formValidation.min.js"></script>
 <script src="/js/formvalidation/framework/bootstrap.min.js"></script>
{!! Minify::javascript('/js/app/user.edit.js') !!}

@endsection
