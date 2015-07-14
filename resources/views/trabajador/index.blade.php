 @extends('app')

 @section('pageheader')
    {!! $text !!}
 @endsection

 @section('breadcrumb')
     <li>General</li>
     <li class="active">Trabajadores</li>
 @endsection

 @section('content')

<div class="box box-primary">
    <div class="box-body" >
        <div class="table-responsive">
             {!! $grid !!}
        </div>
    </div>
</div>



 @endsection

@section('styles')
     <link rel="stylesheet" href="/css/bootstrap-select.min.css">
 @endsection

 @section('scripts')
 <script src="/js/bootstrap-select.min.js"></script>
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