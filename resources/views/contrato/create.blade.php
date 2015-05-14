@extends('app')

@section('content')


    <div class="col-md-11">
        <h3>Registrar nuevo Contrato</h3>
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
            $('#supervisro_id').attr("data-live-search","true");
            $('select').selectpicker({
            		size: 7
            });
        });

    </script>
@endsection