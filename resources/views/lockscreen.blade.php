<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>SSL Leicageosystems</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    {!! Minify::stylesheet('/css/bootstrap.css') !!}
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    {!! Minify::stylesheet('/css/hexagon.admin.css') !!}

    @yield('styles')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="lockscreen">
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
      <div class="lockscreen-logo">
        <a href="/"><b>SSO</b>Leica</a>
      </div>
      <!-- User name -->
      <div class="lockscreen-name"></div>

      <!-- START LOCK SCREEN ITEM -->
      <div class="lockscreen-item">
        <!-- lockscreen credentials (contains the form) -->
        @yield('content')
        <!-- /.lockscreen credentials -->
      </div><!-- /.lockscreen-item -->
      <div class="help-block text-center">
        Seleccione un Pais para cargar las configuraciones necesarias
      </div>
      <div class="text-center">
        <a href="login.html"></a>
      </div>
      <div class="lockscreen-footer text-center">
        Copyright &copy; 2015 <b>Leica Geosystems</b><br/>
        All rights reserved
      </div>
    </div><!-- /.center -->

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.1.0.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    @yield('scripts')
  </body>
</html>
