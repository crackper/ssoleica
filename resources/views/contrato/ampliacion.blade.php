@extends('app')

 @section('pageheader')
    Solicitar Ampliación de Contrato
 @endsection

@section('breadcrumb')
    <li>Proyectos</li>
    <li><a href="/contrato">Contratos</a></li>
    <li class="active">Solicitar Ampliación</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body" >
               {!! $form !!}
            </div>
        </div>

    </div>
</div>
@endsection

@section('styles')
    {!! Rapyd::styles() !!}
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
@endsection

@section('scripts')
    {!! Rapyd::scripts() !!}
    <script src="/js/bootstrap-select.min.js"></script>
    <script>
        $(function(){
            $('select').selectpicker({
            		size: 7
            });

            $(':checkbox').removeClass('form-control input-sm checkbox');
        });

    </script>
@endsection