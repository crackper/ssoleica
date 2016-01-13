@extends('app')

 @section('pageheader')
    {!! $text !!}
 @endsection

 @section('breadcrumb')
     <li class="active">Perfil Usuario </li>
 @endsection

@section('content')
<div class="container-fluid">
	<div class="row">
    <div class="col-md-12">
        @if (Session::has('message'))
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                {{ Session::get('message') }}
            </div>
        @endif
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

					<form class="form-horizontal" id="frmProfileUser" role="form" method="POST" action="{{ url('/user/profile/'. $user->id) }}">
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
							</div>
						</div>

                        <div class="form-group">
							<label class="col-md-2 control-label">Roles</label>
							<div class="col-md-6">
							    @foreach($user->roles as $rol)
							        <span class="label label-primary">{{ $rol->name }}</span>
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
							<div class="col-md-6">
								<button type="submit" class="btn btn-primary">
									Registrar
								</button>
								<a href="/home" class="btn btn-primary">Cancelar</a>
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
 {!! HTML::script('/js/plugins/formValidation.min.js') !!}
   {!! HTML::script('/js/plugins/bootstrap.min.js') !!}
 <script src="/js/bootstrap-dialog.min.js"></script>
{!! Minify::javascript('/js/app/user.profile.js') !!}
    <script>
        $(function(){
            $('.btn-toolbar').first().hide();

            @if (Session::has('message'))
                BootstrapDialog.alert({
                    title:'SSO Leica Geosystems',
                    message: '{{ Session::get('message') }}'
                 });
            @endif
        });
    </script>

@endsection
