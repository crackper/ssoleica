@extends('app')

 @section('pageheader')
    Editar Permiso
 @endsection

@section('breadcrumb')
    <li>Administración</li>
    <li><a href="/permisos">Permisos</a></li>
    <li class="active">Editar</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        @if (Session::has('message'))
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                {{ Session::get('message') }}
            </div>
        @endif

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
    <link rel="stylesheet" href="/css/bootstrap-dialog.min.css"/>
@endsection

@section('scripts')
    {!! Rapyd::scripts() !!}
    <script src="/js/bootstrap-select.min.js"></script>
    <script src="/js/bootstrap-dialog.min.js"></script>
    <script>
        $(function(){
            $('select').selectpicker({
            		size: 7
            });

            $(':checkbox').removeClass('form-control input-sm checkbox');

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