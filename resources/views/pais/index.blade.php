@extends('lockscreen')

@section('content')
<div style="padding: 5px" class="text-center">


{!! Form::open(array('route' => 'pais.workspace', 'class' => 'form-inline')) !!}
    <div class="form-group">
        {!! Form::label('pais_id', 'Seleccione un Pais', array('class' => 'control-label')) !!}
        {!! Form::select('pais_id',$paises,null,array('class' => 'form-control','style'=>'width: 12em','data-toggle' => 'select')) !!}
    </div>

    <div style="padding: 5px;">
        <button type="submit" class="btn btn-primary" style="width: 10em; margin: auto;">Continuar <span class="glyphicon glyphicon-chevron-right"></span></button>
    </div>
{!! Form::close() !!}
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
});
</script>
@endsection