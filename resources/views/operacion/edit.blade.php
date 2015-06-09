@extends('app')

@section('content')

    <div class="col-md-10">
        <h3>Información del Proyecto</h3>
        @if (Session::has('message'))
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  {{ Session::get('message') }}
            </div>
        @endif
        {!! $form !!}
    </div>

@endsection

@section('styles')
    {!! Rapyd::styles() !!}
    <link rel="stylesheet" href="/css/bootstrap-dialog.min.css"/>
@endsection

@section('scripts')
    {!! Rapyd::scripts() !!}
    {!! Rapyd::head() !!}
    <script src="/js/bootstrap-dialog.min.js"></script>

    <script>
        $(function(){
            $('.btn-toolbar').first().hide();

            @if (Session::has('message'))
                BootstrapDialog.alert({
                    title:'SSO Leica Geosystems',
                    message: '{{ Session::get('message') }}'
                 });
            @endif
        });
    </script>
@endsection