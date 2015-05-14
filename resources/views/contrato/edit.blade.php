@extends('app')

@section('content')


    <div class="col-md-10">
        <h3>Información del Contrato</h3>
        {!! $form !!}
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
        });

    </script>
@endsection