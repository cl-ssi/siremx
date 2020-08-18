<!DOCTYPE html>
<html>
  @include('sections.head')
  <body class="hold-transition sidebar-mini text-sm">
    <div class="wrapper" id="app">
    @if(Auth::check())
      <App ruta="{{route('basepath')}}"></App>
    @else
      <Auth ruta="{{route('basepath')}}"></Auth>
    @endif
    </div>
    @include('sections.script')
  </body>
</html>
