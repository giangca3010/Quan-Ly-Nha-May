<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{$user->avatar}}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        @if(isset($user))
        <p>{{$user->name}}</p>
        @endif
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header"></li>
      <li>
      	<a href="{{asset('/')}}">
      		<i class="fa fa-dashboard"></i>
      		<span>Dashboard</span>
      	</a>
      </li>
      @foreach($data as $ds)
        @if($ds->id == 1)
          @include('admin.list-menu', ['list' => $ds,'duyet' => 'duyet-tomoc'])
        @endif
      @endforeach
      @can('user-list')
      <li class="treeview ">
        <a href="#">
          <i class="fa fa-users"></i> <span>Manager</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{asset('user')}}"><i class="fa fa-circle-o"></i> User </a></li>
          <li><a href="{{asset('role')}}"><i class="fa fa-circle-o"></i> Roles</a></li>
          <li><a href="{{asset('')}}"><i class="fa fa-circle-o"></i> Permission </a></li>
          <li><a href="{{asset('')}}"><i class="fa fa-circle-o"></i> Log </a></li>
        </ul>
      </li>
      @endcan
      <li class="treeview">
        <a href="#">
          <i class="fa fa-check-circle-o"></i> <span>QC</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{asset('maloi')}}"><i class="fa fa-circle-o"></i> Mã Lỗi </a></li>
          <li><a href="{{asset('nguyennhan')}}"><i class="fa fa-circle-o"></i> Nguyên Nhân </a></li>
          <li><a href="{{asset('kiemtra')}}"><i class="fa fa-circle-o"></i> Kiểm Tra </a></li>
          <li><a href="{{asset('suachua')}}"><i class="fa fa-circle-o"></i> Sửa Chữa </a></li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-book"></i> <span>Quy Định</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{asset('xinNghi')}}"><i class="fa fa-circle-o"></i> Xin Nghỉ </a></li>
          <li><a href="{{asset('viPham')}}"><i class="fa fa-circle-o"></i> Vi Phạm </a></li>
          <li><a href="{{asset('cheTai')}}"><i class="fa fa-circle-o"></i> Chế Tài </a></li>
          <li><a href="{{asset('quyTrinh')}}"><i class="fa fa-circle-o"></i> Quy Trình </a></li>
          <li><a href="{{asset('quyDinh')}}"><i class="fa fa-circle-o"></i> Quy Định </a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-book"></i> <span>Chi Phí</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{asset('chiphi')}}"><i class="fa fa-circle-o"></i> Danh Sách </a></li>
          <li><a href="{{asset('loaichiphi')}}"><i class="fa fa-circle-o"></i> Loại Chi Phí </a></li>
          <li><a href="{{asset('vatlieu')}}"><i class="fa fa-circle-o"></i> Nguyên Vật Liệu </a></li>
          <li><a href="{{asset('chiphinew')}}"><i class="fa fa-circle-o"></i> Chi Phí New </a></li>
          <li><a href="{{asset('kehoachmua')}}"><i class="fa fa-circle-o"></i> Kế Hoạch Mua Hàng </a></li>
          <li><a href="/target?p=3"><i class="fa fa-circle-o"></i> Định Mức </a></li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>