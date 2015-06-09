 @extends('app')

 @section('content')
    {!! $text !!}

    <div class="table-responsive">
         {!! $grid !!}
    </div>

 @endsection
  @section('scripts')
  <script>
     $(function(){
         $('.pagination').first().remove();
     });
  </script>

  @endsection