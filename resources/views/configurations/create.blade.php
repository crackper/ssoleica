@extends('app')

 @section('pageheader')
    Registrar Configuración
 @endsection

@section('breadcrumb')
    <li>Administracion</li>
    <li><a href="/configurations">Configuraciones</a></li>
    <li class="active">Registrar</li>
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
    <link rel="stylesheet" href="/css/plugins/codemirror/codemirror.css">
@endsection

@section('scripts')
    {!! Rapyd::scripts() !!}
    <script src="/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="/js/plugins/codemirror/codemirror.js"></script>
    <script type='text/javascript' src="/js/plugins/codemirror/mode/javascript/javascript.js"></script>
    <script>
        $(function(){
            $('select').selectpicker({
            		size: 7
            });

            $(':checkbox').removeClass('form-control input-sm checkbox');

            var editor = CodeMirror.fromTextArea(document.getElementById("value"), {
                    lineNumbers: true,
                    matchBrackets: true,
                    autoCloseBrackets: true,
                    mode: "application/ld+json",
                    lineWrapping: true
                  });
        });

    </script>
@endsection