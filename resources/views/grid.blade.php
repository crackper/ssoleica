@extends('app')

@section('content')
    <h2>Información Trabajadores</h2>
     <?= $grid ?>

     <a href="{{ route('trabajador.index') }}"><span class='glyphicon glyphicon-pencil'></span>&nbsp;</a>

      {!! Form::file('image') !!}
      {!! Form::select('animal', array(
              'Cats' => array('leopard' => 'Leopard'),
              'Dogs' => array('spaniel' => 'Spaniel'),
          )) !!}

@endsection