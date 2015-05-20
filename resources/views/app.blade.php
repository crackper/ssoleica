<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SSO Leica</title>

	<!--link href="/css/bootstrap.min.css" rel="stylesheet"-->
    <!--link href="/css/bootstrap-theme.min.css" rel="stylesheet" -->


    <link href="/css/hexagon.theme.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/hexagon.min.css"/>
    <!--link href="http://fonts.googleapis.com/css?family=Bitter" rel="stylesheet" type="text/css" /-->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

	@yield('styles')
	<!-- Fonts -->
	<!--link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'-->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="/js/app/hexagon.js"></script>
    @yield('scripts')

</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/ ">
				    SSO Leica
				    @if(Session::has('pais_name'))
				        {!! Session::get('pais_name') !!}
				    @endif
				</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">General <span class="caret"></span></a>
                         <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Registrar Nuevo Trabajador</a></li>
                            <li>{!! link_to('/trabajador/index','Información de Trabajadores') !!}</li>
                            <!--li class="divider"></li-->

                         </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Programa Mensual SSO <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Registar EHSE Anual</a></li>
                            <li><a href="#">Registar Cumplimiento EHSE</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Reporte Mensual</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Seguridad <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li> <a href="#">Registar Incidentes</a></li>
                            <li><a href="#">Archivo Incidentes</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Estadisticas Seguridad <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#"> Registar Hombre (HHT)</a></li>
                            <li> <a href="#">Horas Hombre Trabajadas (HHT)</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Registar Estadisticas</a></li>
                            <li><a href="#">Historial Estadisticas</a></li>
                        </ul>
                    </li>
                   <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Proyectos <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/operacion/create">Registrar Proyecto</a></li>
                            <li> <a href="/contrato/create">Registrar Contrato</a></li>
                            <li class="divider"></li>
                            <li><a href="/operacion">Información de Proyectos</a></li>
                            <li><a href="/contrato">Información de Contratos</a></li>
                        </ul>
                    </li>
                    @if (!Auth::guest())
                    	<li>  {!! link_to('filemanager/repository','Repositorio') !!}</li>
                    @endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="/auth/login">Login</a></li>
						<li><a href="/auth/register">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/pais">Cambiar Pais</a></li>
								<li><a href="/auth/logout">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
	@yield('content')
	<div>
</body>
</html>

