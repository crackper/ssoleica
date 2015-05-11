@extends('app')

@section('content')

     {!! Rapyd::styles() !!}
    {!! $edit !!}
    {!! Rapyd::scripts() !!}
    {!! Rapyd::head() !!}
@endsection