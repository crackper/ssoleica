 @extends('app')

   @section('pageheader')
      {!! $text !!}
   @endsection

  @section('breadcrumb')
      <li>Ayuda</li>
      @if($breadcrumb != "")
        <li class="active">{{ $breadcrumb }}</li>
      @endif
  @endsection

 @section('content')
<div class="box box-primary">
    <div class="box-body" >
        <div class="table-responsive">
            <ul style="list-style-type: none">
                <li><i class="fa fa-comments-o"></i> <a href="{{ url('/help/introduccion') }}">Introducción</a></li>
                <li><i class="fa fa-comments-o"></i> <a href="{{ url('/help/repository') }}">Repositorio de Archivos</a></li>
                <li><i class="fa fa-comments-o"></i> <a href="{{ url('/help/proyectos') }}">Proyectos y Contratos</a></li>
                <li><i class="fa fa-comments-o"></i> <a href="{{ url('/help/admin-trabajadores') }}">Administración de trabajadores</a></li>
                <li><i class="fa fa-comments-o"></i> <a href="{{ url('/help/admin-trabajador-proyecto') }}">Trabajador Asignar a proyecto</a></li>
            </ul>
        </div>
    </div>
</div>


 @endsection

 @section('styles')

 @endsection

 @section('scripts')

 @endsection