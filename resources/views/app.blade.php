<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Zip Nhà Máy</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/css/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/css/skins/_all-skins.min.css')}}">
  <script src="{{asset('js/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('js/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  
  @yield('css')

</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
  
  @include('layouts.header')
  @include('layouts.menu')

  <div class="content-wrapper">
    @include('layouts.breadcrumb')
    <section class="content">
      @yield('content')
    </section>
  </div>
  @include('layouts.footer')

  <div class="control-sidebar-bg"></div>
</div>

<script src="{{asset('js/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('js/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('js/fastclick/lib/fastclick.js')}}"></script>
<script src="{{asset('js/adminlte.min.js')}}"></script>
<script src="{{asset('js/jquery-ui.min_1.js')}}"></script>
<script src="{{asset('js/jquery.bootstrap-growl.min.js')}}"></script>
<script>
  var activeurl = window.location;
  $('.treeview-menu a[href="'+activeurl+'"]').parent('li').addClass('active');

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(function () {
    $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
  
    $('.delete_images').click(function () {
        var del = '{{ route("delete.images") }}';
        $.ajax({
            data: {
                link : $(this).data('id'),
                type : $(this).data('type'),
            },
            url: del,
            type: 'POST',
            success: function(data) {
                if(data.status === true) {
                    $.bootstrapGrowl(data.message, { type: 'success' });
                    setTimeout(function(){
                       window.location.reload(); 
                    }, 200); 
                }
            },
        });
    });
</script>

 @yield('js')
</body>
</html>
