 @extends('app')

 @section('pageheader')
    Registrar nuevo Proyecto
 @endsection
            
@section('breadcrumb')
    <li>Proyectos</li>
    <li><a href="/operacion">Proyectos</a></li>
    <li class="active">Registrar</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10">
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
@endsection

@section('scripts')
    {!! Rapyd::scripts() !!}
    {!! Rapyd::head() !!}
@endsection