@extends('app')

@section('content')

        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Espacio de Trabajao</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-3 col-md-6">
                        {!! Form::open(array('route' => 'pais.workspace', 'class' => 'form-inline')) !!}
                                     <div class="form-group">
                                        {!! Form::label('pais_id', 'Seleccione un Pais', array('class' => 'control-label')) !!}
                                        {!! Form::select('pais_id',$paises,null,array('class' => 'form-control','style'=>'width: 12em','data-toggle' => 'select')) !!}
                                     </div>
                                     <button type="submit" class="btn btn-primary" style="width: 10em; margin: auto;">Continuar <span class="glyphicon glyphicon-chevron-right"></span></button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

@endsection