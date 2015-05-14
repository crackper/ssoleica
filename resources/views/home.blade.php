@extends('app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h3>
                <img src="/images/logoHexagon.png" alt="Hexagon Mining"/>
                <img src="/images/logoLeicaGeosystem.gif" alt="Leica Geosystems" width="69"/>
                SSO Leica
                <small>
                    Geosystems
                    @if(Session::has('pais_name'))
                        {!! Session::get('pais_name') !!}
                    @endif
                </small>
            </h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">General</h3>
            </div>
            <div class="panel-body">
                <a href="#">Registrar Nuevo Trabajador</a><br/>
               {!! link_to('trabajador/index','Información de Trabajadores') !!}<br/>

            </div>
        </div>
    </div>
        <div class="col-md-12">
         <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title text-inverse">Programa Mensual SSO</h3>
            </div>
            <div class="panel-body">
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
    <div class="col-md-3">
    <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title text-inverse">Seguridad</h3>
                    </div>
                    <div class="panel-body">
                        <a href="#">Registar Incidentes</a><br/>
                        <a href="#">Archivo Incidentes</a><br/>
                    </div>
                </div>
            </div>
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title text-inverse">Estadisticas Seguridad</h3>
                </div>
                <div class="panel-body">
                    <a href="#"> Registar Hombre (HHT)</a><br/>
                    <a href="#">Horas Hombre Trabajadas (HHT)</a><br/>
                    <a href="#">Registar Estadisticas</a><br/>
                    <a href="#">Historial Estadisticas</a><br/>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-3">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-inverse">Proyectos</h3>
                </div>
                <div class="panel-body">
                    <a href="/operacion/create">Registrar Proyecto</a><br/>
                    <a href="/contrato/create">Registrar Contrato</a><br/>
                    <a href="/operacion">Información de Proyectos</a><br/>
                    <a href="/contrato">Información de Contratos</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title text-inverse">Repositorio General de Archivos</h3>
                    </div>
                    <div class="panel-body">
                        {!! link_to('filemanager/repository','Repositorio') !!}

                    </div>
                </div>
            </div>
    </div>
    <div class="col-md-3">
        <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title text-inverse">Administracion</h3>
                        </div>
                        <div class="panel-body">
                            <a href="#">Agregar Usuario</a><br/>
                            <a href="#">Gestionar Usuarios</a><br/>
                            <a href="#">Gestionar Meses</a>
                        </div>
                    </div>
                </div>
    </div>

</div>
@endsection
