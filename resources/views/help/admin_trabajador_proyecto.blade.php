@extends('app')

@section('pageheader')
{!! $text !!}
@endsection

@section('breadcrumb')
<li><a href=" {{ url('/help') }}">Ayuda</a></li>
@if($breadcrumb != "")
<li class="active">{{$breadcrumb}}</li>
@endif
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-body" >
        <div class="table-responsive">
           <iframe src='https://onedrive.live.com/embed?cid=77A404DF5CAA830E&resid=77A404DF5CAA830E%2110559&authkey=AOkKqIH5nHQrnSo&em=2&wdAr=1.3333333333333333' width='610px' height='481px' frameborder='0'>Esto es un documento de <a target='_blank' href='http://office.com'>Microsoft Office</a> incrustado con tecnología de <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>
        </div>
    </div>
</div>


@endsection

@section('styles')

@endsection

@section('scripts')

@endsection