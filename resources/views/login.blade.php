<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Nội Thất Zip | Nhà Máy</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/css/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/css/AdminLTE.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('js/iCheck/square/blue.css')}}">

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <span><b>ZIP </b>Nhà Máy</span>
  </div>
  <div class="login-box-body">
    <!-- <p class="login-box-msg">Sign in to start your session</p> -->
    @if(count($errors) >0)
      <div class="alert alert-danger">
          @foreach($errors->all() as $err)
          {{$err}}<br>
          @endforeach
      </div>
    @endif

    @if(session('thongbao'))
      <div class="alert alert-danger">
      {{session('thongbao')}}
      </div>
    @endif

    <form action="{{asset('login')}}" method="post">
      <input type="hidden" name="_token" value="{{csrf_token()}}"/>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="login" placeholder="Email hoặc Username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Nhớ
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng Nhập</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

<!--     <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div> -->

    <a href="#">Quên Mật Khẩu</a><br>
    <!-- <a href="register.html" class="text-center">Đăng Ký Tài Khoản</a> -->

  </div>
</div>
<script src="{{asset('js/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/iCheck/icheck.min.js')}}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
