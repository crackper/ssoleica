<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>SSO Leica | Log in</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {!! Minify::stylesheet('/css/bootstrap.css') !!}
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    {!! Minify::stylesheet('/css/hexagon.admin.css') !!}
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('/css/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ url('/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ url('/css/formValidation.min.css') }}">
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <b>SSO</b>Leica
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Inicia sesión para empezar</p>
       @if (count($errors) > 0)
	    <div class="alert alert-danger">
	        <strong>Whoops!</strong> hay problemas conn tus datos.<br><br>
		        <ul>
				    @foreach ($errors->all() as $error)
					    <li>{{ $error }}</li>
					@endforeach
				</ul>
		</div>
		@endif

        <form id="frmLogin" action="{{ url('/auth/login') }}" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group has-feedback">
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" name="remember" id="remember" value="true" > Recuerdame
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Acceder</button>

            </div><!-- /.col -->
          </div>
        </form>
        <a href="{{ url('/password/email') }}">Recuperar mi password</a><br>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    {!! HTML::script('/js/plugins/formValidation.min.js') !!}
    {!! HTML::script('/js/plugins/bootstrap.min.js') !!}
    {!! Minify::javascript('/js/app/login.js') !!}
    {!! HTML::script('/js/plugins/icheck.min.js') !!}
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
