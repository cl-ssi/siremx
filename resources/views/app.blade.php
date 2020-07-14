<!DOCTYPE html>
<html>
  @include('sections.head')
  <body class="hold-transition sidebar-mini text-sm">
    <div class="wrapper" id="app">
        <App ruta="{{route('basepath')}}"></App>
    </div>
    @include('sections.script')
  </body>
</html>
