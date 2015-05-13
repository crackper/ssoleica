@extends('app')

@section('content')

    <div class="col-md-10">
        <h3>Registrar nuevo Proyecto</h3>
        {!! $form !!}
    </div>

@endsection

@section('styles')
    {!! Rapyd::styles() !!}
@endsection

@section('scripts')
    {!! Rapyd::scripts() !!}
    {!! Rapyd::head() !!}
@endsection