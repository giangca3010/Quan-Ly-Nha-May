<li class="treeview">
<a href="#">
  <i class="fa fa-table"></i> <span>{{$list->name}}</span>
  <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
</a>
<ul class="treeview-menu">
  <li><a href="{{asset('lenh')}}"><i class="fa fa-circle-o"></i> Kế Hoạch</a></li>
  @can($duyet)
  <li><a href="{{asset('dukien')}}"><i class="fa fa-circle-o"></i> Kế Hoạch Dự Kiến </a></li>
  <li><a href="{{asset('hoanthien')}}"><i class="fa fa-circle-o"></i> Hoàn Thiện </a></li>
  <li><a href="{{asset('item?menu_id=')}}{{$list->id}}"><i class="fa fa-circle-o"></i> Item </a></li>
  <li><a href="{{asset('kien?menu_id=')}}{{$list->id}}"><i class="fa fa-circle-o"></i> Kiện </a></li>
  <li><a href="{{asset('boom?menu_id=')}}{{$list->id}}"><i class="fa fa-circle-o"></i> Boom </a></li>
  <li><a href="{{asset('quyngaynew')}}"><i class="fa fa-circle-o"></i> Qũy Ngày Mới</a></li>
  @endcan
</ul>
</li>