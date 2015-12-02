 @extends('app')

 @section('pageheader')
  <h3>
  <i class="fa fa-calendar-o"></i> Alertas de Vencimientos</h3>
 @endsection

 @section('breadcrumb')
     <li class="active">Alertas</li>
 @endsection

 @section('content')

@if(count($data_f))

<h4><a name="fotochecks">Fotochecks</a></h4>
<!-- Custom Tabs -->
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        @foreach($data_f as $key => $row)
            <li  class = "@if(  $key == 0) active @endif" >
                <a aria-expanded="true" href="#tab_{!! $key !!}" data-toggle="tab">
                    {!! $row["proyecto"] !!} &nbsp; <span class="badge bg-red pull-right">{!! count($row["fotochecks"])!!}</span>
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content">
         @foreach($data_f as $key => $row)
            <div class="tab-pane @if(  $key == 0) active @endif" id="tab_{!! $key !!}">
                <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <th>#</th>
                        <th>Trabajador</th>
                        <th>Nro. Fotocheck</th>
                        <th>Fecha Vencimiento</th>
                    </thead>
                    <tbody>
                        @foreach($row["fotochecks"] as $k => $f)
                         <tr>
                             <td>{!! $k+1 !!}</td>
                             <td>{!! $f->trabajador !!}</td>
                             <td>{!! $f->fotocheck !!}</td>
                             <td>{!! date_format(new DateTime($f->fecha_vencimiento),'d/m/Y') !!}  - {{ $f->fecha_vencimiento }} </td>
                         </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div><!-- /.tab-pane -->
         @endforeach
    </div><!-- nav-tabs-custom -->
 </div>

@endif

@if(count($data_e))

<h4><a name="examenes">Exámenes Médicos</a></h4>
<!-- Custom Tabs -->
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        @foreach($data_e as $key => $row)
            <li  class = "@if(  $key == 0) active @endif" >
                <a aria-expanded="true" href="#tab_{!! $key !!}" data-toggle="tab">
                    {!! $row["proyecto"] !!} &nbsp; <span class="badge bg-red pull-right">{!! count($row["examenes"])!!}</span>
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content">
         @foreach($data_e as $key => $row)
            <div class="tab-pane @if(  $key == 0) active @endif" id="tab_{!! $key !!}">
                <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <th>#</th>
                        <th>Trabajador</th>
                        <th>Exámen</th>
                        <th>Fecha Vencimiento</th>
                    </thead>
                    <tbody>
                        @foreach($row["examenes"] as $k => $f)
                         <tr>
                             <td>{!! $k+1 !!}</td>
                             <td>{!! $f->trabajador !!}</td>
                             <td>{!! $f->vencimiento !!}</td>
                             <td>{!! date_format(new DateTime($f->fecha_vencimiento),'d/m/Y') !!}  - {{ $f->fecha_vencimiento }}</td>
                         </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div><!-- /.tab-pane -->
         @endforeach
    </div><!-- nav-tabs-custom -->
 </div>

@endif

@if(count($data_d))

<h4><a name="documentos">Documentos</a></h4>
<!-- Custom Tabs -->
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        @foreach($data_d as $key => $row)
            <li  class = "@if(  $key == 0) active @endif" >
                <a aria-expanded="true" href="#tab_{!! $key !!}" data-toggle="tab">
                    {!! $row["proyecto"] !!} &nbsp; <span class="badge bg-red pull-right">{!! count($row["documentos"])!!}  - {{ $f->fecha_vencimiento }} </span>
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content">
         @foreach($data_d as $key => $row)
            <div class="tab-pane @if(  $key == 0) active @endif" id="tab_{!! $key !!}">
                <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <th>#</th>
                        <th>Trabajador</th>
                        <th>Documento</th>
                        <th>Fecha Vencimiento</th>
                    </thead>
                    <tbody>
                        @foreach($row["documentos"] as $k => $f)
                         <tr>
                             <td>{!! $k+1 !!}</td>
                             <td>{!! $f->trabajador !!}</td>
                             <td>{!! $f->vencimiento !!}</td>
                             <td>{!! date_format(new DateTime($f->fecha_vencimiento),'d/m/Y') !!} - {{ $f->fecha_vencimiento }}</td>
                         </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div><!-- /.tab-pane -->
         @endforeach
    </div><!-- nav-tabs-custom -->
 </div>

@endif

@endsection

@section('styles')

 @endsection

 @section('scripts')
 <script>
 $(function(){

 });
 </script>
 @endsection