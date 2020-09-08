<td class="text-center off tcd{{\App\Common::url_title($kien->label)}}">
    @if($kien->status_kehoach == 0)
    @can($quyen)
    <a class="infolenh" type="button" data-toggle="modal" data-target="#play" data-status_kehoach="{{$kien->status_kehoach}}" data-parent="{{$kien->parent}}" data-sort="{{$kien->sort}}" data-chinh="{{$kien->status}}" data-dinhmuc="{{$kien->dinhmuc}}" data-tre="{{$kien->tre}}" data-status="1" data-id="{{$kien->id}}">
        <span class="label label-warning">Chờ</span>
    </a>
    @endcan
    @cannot($quyen)
    <span class="label label-warning">Chờ</span>
    @endcan
    @elseif($kien->status_kehoach == 1)
    @can($quyen)
    <a class="infolenh" type="button" data-toggle="modal" data-target="#play" data-status_kehoach="{{$kien->status_kehoach}}" data-parent="{{$kien->parent}}" data-sort="{{$kien->sort}}" data-chinh="{{$kien->status}}" data-dinhmuc="{{$kien->dinhmuc}}" data-tre="{{$kien->tre}}" data-status="2" data-id="{{$kien->id}}">
        <span class="label label-info">Start</span>
    </a>
    @endcan
    @cannot($quyen)
    <span class="label label-info">Start</span>
    @endcan
    @elseif($kien->status_kehoach == 2)
    <span class="label label-success">Finish</span>
    @elseif($kien->status_kehoach == 3)
    <span class="label label-danger">Tạm Dừng</span>
        @if($kien->sl_dsx != null)<br><br>
        <p>{{$kien->sl_dsx}} / {{$item['cat']['so_luong']}}</p>
        @endif
    @endif
    <br><br>
    <a class="note_kien" type="button" data-toggle="modal" data-type="0" data-target="#note_kien" data-parent="{{$item['cat']->parent}}" data-name="{{$item['cat']->name}}" data-item="{{$item['cat']->item}}" data-soluong="{{$item['cat']->so_luong}}" data-id="{{$kien->id}}" data-lenh="{{$item['cat']->lenh}}" data-sort="{{$kien->sort}}"><i class="fa fa-pencil"></i></a>
    <a class="note_content" type="button" data-toggle="modal" data-type="0" data-target="#note_content" data-name="{{$item['cat']->name}}" data-item="{{$item['cat']->item}}" data-soluong="{{$item['cat']->so_luong}}" data-parent="{{$kien->parent}}" data-content="{{$kien->content}}" data-lenh="{{$item['cat']->lenh}}" data-sort="{{$kien->sort}}"><i class="fa fa-file-text-o"></i></a>
</td>
<td class="text-center off stcd{{\App\Common::url_title($kien->label)}}">
    {{date('H:i',strtotime($kien->start_time))}} - {{date('H:i',strtotime($kien->end_time))}} <br>
    {{date('d/m',strtotime($kien->start_date))}} - {{date('d/m',strtotime($kien->end_date))}}
</td>
<td class="text-center bg {{$kien->status ==  1 ? 'bg-success' : ''  }}  off ticd{{\App\Common::url_title($kien->label)}}">
    {{$kien->dinhmuc}}</br>
    @if($kien->status_kehoach == 1)
    {{(\App\Common::targetS($kien->dinhmuc,$kien->start_time,$kien->start_date,$kien->label))[0]}}<br>    
    {{(\App\Common::targetS($kien->dinhmuc,$kien->start_time,$kien->start_date,$kien->label))[1]}}%
    @endif
    @if($kien->status_kehoach == 2)
    {{(\App\Common::targetF($kien->dinhmuc,$kien->start_time,$kien->start_date,$kien->end_time,$kien->end_date,$kien->label))[0]}}<br>
        @if(\App\Common::format_number((\App\Common::targetF($kien->dinhmuc,$kien->start_time,$kien->start_date,$kien->end_time,$kien->end_date,$kien->label))[1]) > 100)
        <span class="bg bg-danger">{{(\App\Common::targetF($kien->dinhmuc,$kien->start_time,$kien->start_date,$kien->end_time,$kien->end_date,$kien->label))[1]}}%</span>
        @elseif(\App\Common::format_number((\App\Common::targetF($kien->dinhmuc,$kien->start_time,$kien->start_date,$kien->end_time,$kien->end_date,$kien->label))[1]) <= 100)
        {{(\App\Common::targetF($kien->dinhmuc,$kien->start_time,$kien->start_date,$kien->end_time,$kien->end_date,$kien->label))[1]}}%
        @endif
    @endif
</td>
<td class="text-center off qcd{{\App\Common::url_title($kien->label)}}">
    @if($kien->qc_start == null and $kien->qc_end == null)
    @can('leader-tomoc')
    <a class="qc_leader" type="button" data-toggle="modal" data-target="#qc_leader" data-status_qc="1" data-parent="{{$kien->parent}}" data-sort="{{$kien->sort}}">
        <span class="label label-warning">Chờ</span>
    </a>
    @endcan
    @cannot('leader-tomoc')
    <span class="label label-warning">Chờ</span>
    @endcan
    @elseif($kien->qc_start != null and $kien->qc_end == null)
    @can('leader-tomoc')
    <a class="qc_leader" type="button" data-toggle="modal" data-target="#qc_leader" data-status_qc="2" data-parent="{{$kien->parent}}" data-sort="{{$kien->sort}}">
        <span class="label label-info">Start</span>
    </a>
    @endcan
    @cannot('leader-tomoc')
    <span class="label label-info">Start</span>
    @endcan
    @elseif($kien->qc_start != null and $kien->qc_end != null)
    <span class="label label-default">Finish</span>
    @endif
    <br><br>
    <a class="note_kien" type="button" data-toggle="modal" data-target="#note_kien" data-parent="{{$item['cat']->parent}}" data-name="{{$item['cat']->name}}" data-item="{{$item['cat']->item}}" data-soluong="{{$item['cat']->so_luong}}" data-type="1" data-id="{{$kien->id}}" data-lenh="{{$item['cat']->lenh}}" data-sort="{{$kien->sort}}"><i class="fa fa-pencil"></i></a>
    <a class="note_content" type="button" data-toggle="modal" data-target="#note_content" data-name="{{$item['cat']->name}}" data-item="{{$item['cat']->item}}" data-soluong="{{$item['cat']->so_luong}}" data-parent="{{$kien->parent}}" data-type="1" data-content="{{$kien->content}}" data-lenh="{{$item['cat']->lenh}}" data-sort="{{$kien->sort}}"><i class="fa fa-file-text-o"></i></a>
</td>
