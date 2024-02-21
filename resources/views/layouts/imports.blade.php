<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Culinary Game</title>
    
  <link rel="stylesheet" href="{{asset('adminlte/css.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300i,400">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/select2/css/select2.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminlte/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">

  {{-- Выбор цвета --}}
  <link rel="stylesheet" href="{{asset('adminlte/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}"> 
  {{-- Опубликован товар --}}
  <link rel="stylesheet" href="{{asset('adminlte/plugins/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css')}}">

   {{-- DataTables --}}
   <link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
   <link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-select/css/select.bootstrap4.min.css')}}">

   {{-- Charts --}}
   <link rel="stylesheet" href="{{asset('adminlte/plugins/chart.js/Chart.min.css')}}">

    {{-- Sweetalert2 --}}
    <link rel="stylesheet" href="{{asset('adminlte/plugins/sweetalert2/sweetalert2.min.css')}}">
   
   <link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-searchpanes/css/searchPanes.bootstrap4.min.css')}}">
   <link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-searchbuilder/css/searchBuilder.bootstrap4.min.css')}}">

   {{-- Иконки --}}
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

</head>
<body>


    
    @yield('content')

    
    
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- overlayScrollbars -->
<script src="{{asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>

<!-- colorPicker -->
<script src="{{asset('adminlte/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>

<!-- switch -->
<script src="{{asset('adminlte/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>


<!-- DataTables -->
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

<script src="{{asset('adminlte/plugins/datatables-searchpanes/js/searchPanes.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

{{-- Charts --}}
<script src="{{asset('adminlte/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/chart.js/Chart.min.js')}}"></script>


{{-- Charts --}}
<script src="{{asset('adminlte/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>


<!-- DataTablesSelect -->
<script src="{{asset('adminlte/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.min.js"></script>


<!-- AdminLTE App -->
<script src="{{asset('adminlte/dist/js/adminlte.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script>
</body>
</html>