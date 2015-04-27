@extends('app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h3>
                <img src="/images/logoHexagon.png" alt="Hexagon Mining"/>
                <img src="/images/logoLeicaGeosystem.gif" alt="Leica Geosystems" width="69"/>
                SSO Leica
                <small>Geosystems</small>
            </h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">General</h3>
            </div>
            <div class="panel-body">
                <a href="#">Registrar Nuevo Trabajador</a><br/>
                <a href="#">Información de Trabajadores</a><br/>
                <a href="#">Horas Hombre Trabajadas (HHT)</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
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
    <div class="col-md-3">
         <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title text-inverse">Programa Mesnsual SSO</h3>
            </div>
            <div class="panel-body">
                <a href="#">Registar EHSE Anual</a><br/>
                <a href="#">Registar Cumplimiento EHSE</a><br/>
                <a href="#">Reporte Mensual</a><br/>
            </div>
         </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title text-inverse">Monitoreo de Agentes</h3>
            </div>
            <div class="panel-body">
                <a href="#">Monitoreos Reaizados</a>
            </div>
        </div>
    </div>
</div>
@endsection
