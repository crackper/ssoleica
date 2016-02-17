@extends('app')

@section('pageheader')
    {!! $text !!}
@endsection

 @section('breadcrumb')
     <li>Proyectos</li>
     <li><a href="/contrato">Contratos</a></li>
     <li class="active">Ampliaciones Pendientes</li>
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
                <div class="table-responsive">
                     {!! $grid !!}
                </div>
            </div>
        </div>
     </div>
</div>
 @endsection

@section('styles')
     <link rel="stylesheet" href="/css/bootstrap-select.min.css">
     <link rel="stylesheet" href="/css/bootstrap-dialog.min.css"/>
 @endsection

 @section('scripts')
 <script src="/js/bootstrap-select.min.js"></script>
 <script src="/js/bootstrap-dialog.min.js"></script>
 <script>
 $(function(){
     $('select').selectpicker({
         size: 7
     });

          $('.grids-control-records-per-page ').width('70px');

          $('.pagination').first().remove();

          $('table').addClass('table-condensed');
 });
 </script>
  @endsection
