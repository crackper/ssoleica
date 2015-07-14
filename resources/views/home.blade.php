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
    <div class="col-lg-3 col-xs-12">
        <div class="col-md-12">
        <div class="header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">General</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <a href="/trabajador/create">Registrar Nuevo Trabajador</a><br/>
               {!! link_to('/trabajador/index','Información de Trabajadores') !!}<br/>

            </div>
        </div>
        </div>
    </div>
        <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Programa Mensual SSO</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <a href="#">Registar EHSE Anual</a><br/>
                <a href="#">Registar Cumplimiento EHSE</a><br/>
                <a href="#">Registar EHSE Personalizado</a><br/>
                <a href="#">Registar Indicadores de Eficacia</a><br/>
                <a href="#">Registar Indicadores de Eficiencia</a><br/>
                <a href="#">% Cumplimiento EHSE</a><br/>
                <a href="#">Reporte Mensual</a><br/>
            </div>
         </div>
    </div>
    </div>
    <div class="col-lg-3 col-xs-12">
    <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Seguridad</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <a href="#">Registar Incidentes</a><br/>
                        <a href="#">Archivo Incidentes</a><br/>
                    </div>
                </div>
            </div>
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Estadisticas Seguridad</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <a href="/horasHombre/create"> Registar Hombre (HHT)</a><br/>
                    <a href="/horasHombre/">Horas Hombre Trabajadas (HHT)</a><br/>
                    <a href="/estadisticas/create">Registar Estadisticas</a><br/>
                    <a href="/estadisticas/">Historial Estadisticas</a><br/>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-3 col-xs-12">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Proyectos</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <a href="/operacion/create">Registrar Proyecto</a><br/>
                    <a href="/contrato/create">Registrar Contrato</a><br/>
                    <a href="/operacion">Información de Proyectos</a><br/>
                    <a href="/contrato">Información de Contratos</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Repositorio Archivos</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <a href="/filemanager/repository">Repositorio</a><br/>
                    </div>
                </div>
            </div>
    </div>
    <div class="col-lg-3 col-xs-12">
        <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title">Administracion</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <a href="#">Agregar Usuario</a><br/>
                            <a href="#">Gestionar Usuarios</a><br/>
                            <hr/>
                            <a href="#">Gestionar Meses</a>
                        </div>
                    </div>
                </div>
    </div>

</div>
@endsection
