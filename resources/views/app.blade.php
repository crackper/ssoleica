<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>SSO Leicageosystems</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    {!! Minify::stylesheet('/css/bootstrap.css') !!}
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    {!! Minify::stylesheet('/css/hexagon.admin.css') !!}
    {!! Minify::stylesheet('/css/skins/skin-blue.css') !!}

    @yield('styles')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- REQUIRED JS SCRIPTS -->

        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <script src="/js/jquery.slimscroll.min.js"></script>
        {!! Minify::javascript('/js/app/app.js') !!}
         @yield('scripts')
  </head>

  <body class="skin-blue fixed sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="/" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>SSO</b>L</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>SSO Leica</b>
            @if(Session::has('pais_name'))
                {!! Session::get('pais_name') !!}
          	@endif
          </span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
             <!-- Messages: style can be found in dropdown.less-->
             @if(Auth::user()->hasRole(['admin']))
              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                    @if(Session::get('cant_pr') > 0)
                      <span class="label label-success">{!! Session::get('cant_pr') !!}</span>
                    @endif
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Tienes {!! Session::get('cant_pr') !!} cosas pendientes</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <!-- start message -->
                        @if(Session::has('cant_pr') && Session::get('cant_pr') > 0)
                       <li>
                         <a href="{!! url('/contrato/ampliacion-pendiente')!!}">
                             <i class="fa fa-folder-open text-aqua"></i> <b>{!! Session::get('cant_pr') !!}</b> <small> ampliaciones  de contrato que aprobar</small>
                         </a>
                       </li>
                       @endif
                      <!-- end message -->
                    </ul>
                  </li>
                  <!--li class="footer"><a href="#">See All Messages</a></li-->
                </ul>
              </li>
              @endif
              <!-- Notifications Menu -->
              <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  @if(Session::get('total_n') > 0)
                    <span class="label label-warning">{!! Session::get('total_n') !!}</span>
                  @endif
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Tienes {!! Session::get('total_n') !!} Alertas</li>
                  <li>
                    <!-- Inner Menu: contains the notifications -->
                    <ul class="menu">
                      <!-- start notification -->
                      @if(Session::has('cant_f') && Session::get('cant_f') > 0)
                      <li>
                        <a href="{!! url('/alertas#fotochecks')!!}">
                            <i class="fa fa-check text-aqua"></i> <b>{!! Session::get('cant_f') !!}</b> <small>Fotocheck(s) vence(n) este mes</small>
                        </a>
                      </li>
                      @endif
                      @if(Session::has('cant_e') && Session::get('cant_e') > 0)
                      <li>
                        <a href="{!! url('/alertas#examenes')!!}">
                            <i class="fa fa-check text-aqua"></i> <b>{!! Session::get('cant_e') !!}</b> <small>Exam. Medico(s) vence(n) este mes</small>
                        </a>
                      </li>
                       @endif
                      @if(Session::has('cant_d') && Session::get('cant_d') > 0)
                      <li>
                        <a href="{!! url('/alertas#documentos')!!}">
                            <i class="fa fa-check text-aqua"></i> <b>{!! Session::get('cant_d') !!}</b> <small>Otro(s) documento(s) vence(n) este mes</small>
                        </a>
                      </li>
                      @endif
                      <!-- proximo mes -->
                      @if(Session::has('cant_f_nxm') && Session::get('cant_f_nxm') > 0)
                      <li>
                        <a href="{!! url('/alertas/next-mes#fotochecks')!!}">
                            <i class="fa fa-reply-all text-aqua"></i> <b>{!! Session::get('cant_f_nxm') !!}</b> <small>Fotocheck(s) vence(n) el próximo mes</small>
                        </a>
                      </li>
                      @endif
                      @if(Session::has('cant_e_nxm') && Session::get('cant_e_nxm') > 0)
                      <li>
                        <a href="{!! url('/alertas/next-mes#examenes')!!}">
                            <i class="fa fa-reply-all text-aqua"></i> <b>{!! Session::get('cant_e_nxm') !!}</b> <small>Exam. Medico(s) vence(n) el próximo mes</small>
                        </a>
                      </li>
                       @endif
                      @if(Session::has('cant_d_nxm') && Session::get('cant_d_nxm') > 0)
                      <li>
                        <a href="{!! url('/alertas/next-mes#documentos')!!}">
                            <i class="fa fa-reply-all text-aqua"></i> <b>{!! Session::get('cant_d_nxm') !!}</b> <small>Otro(s) documento(s) vence(n) el próximo mes</small>
                        </a>
                      </li>
                      @endif
                       <!-- end notification -->
                    </ul>
                  </li>
                  <li class="footer"><a href="{!! url('/alertas') !!}">Ver todo este mes</a></li>
                  <li class="footer"><a href="{!! url('/alertas/next-mes') !!}">Ver todo próximo mes</a></li>
                </ul>
              </li>
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="/images/user_accounts.png" class="user-image" alt="User Image" />
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs">Bienvenido,  {{ Auth::user()->name }} !</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="/images/user_accounts.png" class="img-circle" alt="User Image" />
                    <p>
                      {{ Auth::user()->name }}
                      <small>{{ Auth::user()->email }}</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <!--li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li-->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="/profile" class="btn btn-default btn-flat">Perfil</a>
                    </div>
                    <div class="pull-right">
                      <a href="/auth/logout" class="btn btn-default btn-flat">Cerrar Sesión</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
           <!-- Sidebar user panel (optional) -->
          <!--div class="user-panel" style="height: 3em;">
            <div class="pull-left info">
              <p>
                <span class="glyphicon glyphicon-calendar"></span>
                <span id="fecha">04/07/2105</span>
                <span id="hora">15:00:00</span>
              </p>
              <!-- Status -->
            <!--/div>
          </div->
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">Menu</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="/"><i class="fa fa-home"></i> <span>{{ trans('home.home') }}</span></a></li>
            @if(Auth::user()->hasRole(['admin','apr']))
            <li class="treeview">
              <a href="#"><i class="fa fa-cube"></i> <span>{{ trans('home.general') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="/trabajador"><i class="fa fa-list-alt"></i>{{ trans('home.trabajadores') }}</a></li>
                <li><a href="/trabajador/create"><i class="fa fa-plus-circle"></i>{{ trans('home.trabajadores_create') }}</a></li>
              </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-database"></i> <span>{{ trans('home.proyectos_title') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                 <ul class="treeview-menu">
                   <li><a href="/operacion"><i class="fa fa-list-alt"></i>{{ trans('home.proyectos') }}</a></li>
                   <li><a href="/contrato"><i class="fa fa-list-alt"></i>{{ trans('home.contratos') }}</a></li>
                   <li><a href="/operacion/create"><i class="fa fa-plus-circle"></i>{{ trans('home.proyectos_create') }}</a></li>
                   <li><a href="/contrato/create"><i class="fa fa-plus-circle"></i>{{ trans('home.contratos_create') }}</a></li>
                 </ul>
            </li>
            <li class="treeview">
                 <a href="#"><i class="fa fa-rebel"></i> <span>{{ trans('home.seguridad_title') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="/incidente"><i class="fa fa-list-alt"></i>{{ trans('home.seguridad_view') }}</a></li>
                    <li><a href="/incidente/create"><i class="fa fa-plus-circle"></i>{{ trans('home.seguridad_create') }}</a></li>
                  </ul>
             </li>
            <li class="treeview">
                 <a href="#"><i class="fa fa-pie-chart"></i> <span>{{ trans('home.estadisticas_title') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="/horasHombre"><i class="fa fa-list-alt"></i>{{ trans('home.horashombre_view') }}</a></li>
                    <li><a href="/horasHombre/create"><i class="fa fa-plus-circle"></i>{{ trans('home.horashombre_create') }}</a></li>
                    <li><a href="/estadisticas/create"><i class="fa fa-plus-circle"></i>{{ trans('home.estadisticas_create') }}</a></li>
                    <li><a href="/estadisticas"><i class="fa fa-list-alt"></i>{{ trans('home.estadisticas_view') }}</a></li>
                  </ul>
             </li>
            @endif
            <li><a href="{!! env('URL_FILEMANAGER', '/repository') !!}"><i class="fa fa-archive"></i> <span>{{ trans('home.repositorio_view') }}</span></a></li>
            <li><a href="{!! url('/help') !!}"><i class="fa fa-question-circle"></i> <span>{{ trans('home.help_view') }}</span></a></li>
            @if(Auth::user()->hasRole('admin'))
            <li class="header">{{ trans('home.administracion_title') }}</li>
            <li class="treeview">
                 <a href="#"><i class="fa fa-cubes"></i> <span>{{ trans('home.user_title') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="/user/create"><i class="fa fa-plus-circle"></i>{{ trans('home.user_create') }}</a></li>
                    <li><a href="/user"><i class="fa fa-list-alt"></i>{{ trans('home.user_view') }}</a></li>
                  </ul>
             </li>
            <li class="treeview">
                 <a href="#"><i class="fa fa-list"></i> <span>{{ trans('home.enum_title') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="/enums/create"><i class="fa fa-plus-circle"></i>{{ trans('home.enum_create') }}</a></li>
                    <li><a href="/enums"><i class="fa fa-list-alt"></i>{{ trans('home.enum_view') }}</a></li>
                  </ul>
             </li>
            <li class="treeview">
                 <a href="#"><i class="fa fa-unlock"></i> <span>{{ trans('home.permiso_title') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="/permisos/create"><i class="fa fa-plus-circle"></i>{{ trans('home.permiso_create') }}</a></li>
                    <li><a href="/permisos"><i class="fa fa-list-alt"></i>{{ trans('home.permiso_view') }}</a></li>
                  </ul>
             </li>
             @endif
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            @yield('pageheader')
          </h1>
          <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
            @yield('breadcrumb')
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          @yield('content')

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          Version <b>1.0.0</b>
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2015 <a href="#">Leica Geosystems</a>.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Otras Actividades</h3>
            <ul class="control-sidebar-menu">
              <li>
                <!--a href="javascript::;">
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a-->
                <a href="{{ url('/pais') }}"> Cambiar de Pais</a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

            <!--h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>
                </a>
              </li>
            </ul--><!-- /.control-sidebar-menu -->

          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          @if(Auth::user()->hasRole(['admin']))
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">Configuración General</h3>
              <ul class="control-sidebar-menu">
                <li><a href="{{ url('/logs') }}">Monitorear Sistema</a></li>
              </ul>
              <!--div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div--><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
        @endif
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->
  </body>
</html>
