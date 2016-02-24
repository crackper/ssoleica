@extends('app')

@section('pageheader')
    <img src="/images/logoHexagon.png" alt="Hexagon Mining"/>
    <img src="/images/logoLeicaGeosystem.gif" alt="Leica Geosystems" width="69"/>
    SSO Leica
    <small>
        Geosystems
        @if(Session::has('pais_name'))
            {!! Session::get('pais_name') !!}
        @endif
    </small>
@endsection

@section('content')

<div class="row">
        @if (Session::has('error_timezone'))
           <div class="col-lg-12 col-xs-12">
            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
                <h4>{{ Session::get('error_timezone') }}</h4>
            </div>
            </div>
        @endif

    <div class="col-lg-3 col-xs-12">

    @if(Auth::user()->hasRole(['admin','apr']))
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">General</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><a href="/trabajador"><i class="fa fa-list-alt"></i>{{ trans('home.trabajadores') }}</a></li>
                <li><a href="/trabajador/create"><i class="fa fa-plus-circle"></i>{{ trans('home.trabajadores_create') }}</a></li>
              </ul>
            </div>

        </div>
    @endif


         <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Programa Mensual SSO</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if(Auth::user()->hasRole(['admin','apr']))
                <b>Pendiente</b><br/>
                <a href="#">Registar EHSE Anual</a><br/>
                <a href="#">Registar Cumplimiento EHSE</a><br/>
                <a href="#">Registar EHSE Personalizado</a><br/>
                <a href="#">Registar Indicadores de Eficacia</a><br/>
                <a href="#">Registar Indicadores de Eficiencia</a><br/>
                <a href="#">% Cumplimiento EHSE</a><br/>
                @endif
                @if(Auth::user()->hasRole(['admin','apr','joperaciones','gerente']))
                    <a href="#">Reporte Mensual</a><br/>
                @endif
            </div>
         </div>

    </div>
    @if(Auth::user()->hasRole(['admin','apr']))
    <div class="col-lg-3 col-xs-12">

                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('home.seguridad_title') }}</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                      <ul class="nav nav-pills nav-stacked">
                        <li><a href="#"><i class="fa fa-gears"></i>Pendiente / En Construcción</a></li>
                        <li><a href="/incidente"><i class="fa fa-list-alt"></i>{{ trans('home.seguridad_view') }}</a></li>
                        <li><a href="/incidente/create"><i class="fa fa-plus-circle"></i>{{ trans('home.seguridad_create') }}</a></li>
                      </ul>
                    </div>
                </div>

            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Estadisticas Seguridad</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                    <li><a href="/horasHombre"><i class="fa fa-list-alt"></i>{{ trans('home.horashombre_view') }}</a></li>
                    <li><a href="/horasHombre/create"><i class="fa fa-plus-circle"></i>{{ trans('home.horashombre_create') }}</a></li>
                    <li><a href="/estadisticas/create"><i class="fa fa-plus-circle"></i>{{ trans('home.estadisticas_create') }}</a></li>
                    <li><a href="/estadisticas"><i class="fa fa-list-alt"></i>{{ trans('home.estadisticas_view') }}</a></li>

                    </ul>
                </div>
            </div>


    </div>
    @endif


    <div class="col-lg-3 col-xs-12">
        @if(Auth::user()->hasRole(['admin','apr']))
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Proyectos</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="/operacion/create"><i class="fa fa-plus-circle"></i> {{ trans('home.proyectos_create') }}</a></li>
                        <li><a href="/contrato/create"> <i class="fa fa-plus-circle"></i>{{ trans('home.contratos_create') }}</a></li>
                        <li><a href="/operacion"><i class="fa fa-list-alt"></i>{{ trans('home.proyectos') }}</a></li>
                        <li><a href="/contrato"><i class="fa fa-list-alt"></i>{{ trans('home.contratos') }}</a></li>
                    </ul>

                </div>
            </div>
        @endif
        @if(Auth::user()->hasRole(['admin','apr','joperaciones','gerente']))
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('home.repositorio_view') }}</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="{!! env('URL_FILEMANAGER', '/repository') !!}"><i class="fa fa-archive"></i>Repositorio</a></li>
                        </ul>
                    </div>
                </div>
        @endif
    </div>


    @if(Auth::user()->hasRole('admin'))
    <div class="col-lg-3 col-xs-12">

                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('home.admin_title') }}</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body no-padding">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="/user/create"><i class="fa fa-plus-circle"></i>{{ trans('home.user_create') }}</a></li>
                                <li><a href="/user"><i class="fa fa-list-alt"></i>{{ trans('home.user_view') }}</a></li>
                                <li><a href="/enums/create"> <i class="fa fa-plus-circle"></i> {{ trans('home.enum_create') }}</a></li>
                                <li><a href="/enums"><i class="fa fa-list-alt"></i>{{ trans('home.enum_view') }}</a></li>
                                <li><a href="/permisos/create"> <i class="fa fa-plus-circle"></i> {{ trans('home.permiso_create') }}</a></li>
                                <li><a href="/permisos"><i class="fa fa-list-alt"></i>{{ trans('home.permiso_view') }}</a></li>
                            </ul>
                        </div>
                    </div>

    </div>
    @endif
</div>
@endsection
