@extends("app")
@section("css")
<link rel="stylesheet" href="{{asset('js/select2/dist/css/select2.min.css')}}">
<style type="text/css">
	.tableFixHead          { overflow-y: auto; height: 700px; }
	.tableFixHead thead .rowon { position: sticky; top: -1px; }
	.tableFixHead thead .rowdown { position: sticky; top: 17px; }

	table  { border-collapse: collapse; width: 100%; }
	th     { background:#eee; border: 1px solid #abbba4;}

    .offshow {
        display: none;
    }
</style>
@endsection
@section("content")
    <div class="row">       
        <div class="col-md-6">
            <a href="#" onclick="savePos()" class="btn btn-success">Lưu</a>
            <a href="#"  class="btn btn-danger">Hủy</a>
        </div>
        <div class="col-md-6">
            <div class="form-group">
	            <a href="#" onclick="reset()" class="btn btn-default"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                <select class="form-control select2 select2-hidden-accessible" multiple="" style="width: 91%;"  data-placeholder="Chọn Công Đoạn Muốn Xem" id="select-cd">
                    <option></option>
                    <option value="all">Tất Cả</option>
                    @foreach($getCD as $k => $cd)
                        <option value="cd{{$cd->code}}" 
                        	@foreach($select as $s)
	                        	@if($cd->code == $s)
	                        	selected
	                        	@endif 
                        	@endforeach
                        class="congdoan" >{{$cd->name}}</option>
                    @endforeach
                    <option class="congdoan" value="sua1">Sửa 1</option>
                    <option class="congdoan" value="sua2">Sửa 2</option>
                    <option class="congdoan" value="sua3">Sửa 3</option>
                </select>
            </div>
        </div>
    </div>
    <div class="table-responsive tableFixHead">
        <table class="table table-bordered">
        	<thead>
	            <tr>
	                <th rowspan="2" class="text-center rowon ">Lệnh</th>
	                <th rowspan="2" class="text-center rowon ">Item</th>
	                <th rowspan="2" class="text-center rowon ">SL</th>
	                <th rowspan="2" class="text-center rowon ">Kiện</th>
                    <th rowspan="2" class="text-center rowon ">Vật Tư</th>
	                @foreach($getCD as $k => $cd)
                    <th colspan="4" class="text-center off rowon showmore" id="cd{{$cd->code}}">{{$cd->name}}</th>
	                @endforeach
                    @can('qc')
                    <th rowspan="2" class="text-center rowon ">QC</th>
                    <th rowspan="2" class="text-center rowon showmore off" id="sua1">Sửa 1</th>
                    <th rowspan="2" class="text-center rowon showmore off" id="sua2">Sửa 2</th>
                    <th rowspan="2" class="text-center rowon showmore off" id="sua3">Sửa 3</th>
                    @endcan
	                <th rowspan="2" class="text-center rowon ">Nhập Kho</th>
	            </tr>
	            <tr>
	                @foreach($getCD as $k => $cd)
	                    <th class="text-center off showmore rowdown" id="ttcd{{$cd->code}}">Trạng Thái</th>
	                    <th class="text-center off showmore rowdown" id="khcd{{$cd->code}}">Kế Hoạch</th>
	                    <th class="text-center off showmore rowdown" id="dmcd{{$cd->code}}">ĐM</th>
                        <th class="text-center off showmore rowdown" id="qccd{{$cd->code}}">QC</th>
	                @endforeach
	            </tr>
        	</thead>
            <tbody class="row_position">
                @foreach($sort as $k => $s)
                @foreach($s as $key => $item)
                @if($item->isNotEmpty())
                <tr id="{{$key ==  0 ? $k : '' }}" >
                    <td class="{{$key ==  0 ? '' : 'hide' }} " rowspan="{{count($s)}}" id="" style="width: 144px;">
                    	<span>{{$item['cat']['lenh']}}</span><br>
                        @can('xoa-moc')
                    	<a class="remove-lenh" type="button" data-toggle="modal" data-target="#remove" data-parent="{{$item['cat']->parent}}" data-name="{{$item['cat']->name}}" data-soluong="{{$item['cat']->so_luong}}" data-lenhlink="{{$item['cat']['lenh_link']}}" data-lenh="{{$item['cat']->lenh}}" data-sort="{{$k}}">
                    		<i class="fa fa-trash"></i>
                    	</a>
                        @endcan
                    </td>
                    <td class="{{$key ==  0 ? '' : 'hide' }} text-center" rowspan="{{count($s)}}" style="width: 189px;">
                        <span>{{$item['cat']['item']}}</span><br><br>
                        @if(count($s) > 1)
                        <a class="allinfo" data-show="infoshow{{$item['cat']->id_kehoach}}"><i class="fa fa-info"></i></a>
                        @endif
                    </td>
                    <td class="{{$key ==  0 ? '' : 'hide' }} text-center" rowspan="{{count($s)}}">
                        <span>{{$item['cat']['so_luong']}}</span><br><br>
                        @can('tomoc-tamdung')
                        <a class="td-lenh" type="button" data-toggle="modal" data-target="#stop" data-parent="{{$item['cat']->parent}}" data-name="{{$item['cat']->name}}" data-soluong="{{$item['cat']->so_luong}}" data-lenhname="{{$item['cat']->lenh_name}}" data-item="{{$item['cat']['item']}}" data-lenh="{{$item['cat']->lenh}}" data-sort="{{$k}}">
                            <i class="fa fa-share-square-o"></i>
                        </a>
                        @endcan
                    </td>
                    <td class="{{$key ==  0 ? '' : 'offshow' }} infoshow{{$item['cat']->id_kehoach}} qsua1 text-center scroll{{$item['cat']->parent}} " style="width: 144px;">
                    	<p>{{$item['cat']['name']}}</p>
                        @can('unlock-moc')
                        @if(count($s) > 1)
                    	<a class="lock" type="button" data-toggle="modal" data-target="#lock" data-parent="{{$item['cat']->parent}}" data-name="{{$item['cat']->name}}" data-item="{{$item['cat']->item}}" data-soluong="{{$item['cat']->so_luong}}" data-lenh="{{$item['cat']->lenh}}" data-sort="{{$k}}"><i class="fa fa-lock"></i></a>
                        @endif
                        @endcan
                    </td>
                    <td class="{{$key ==  0 ? '' : 'hide' }} text-center" rowspan="{{count($s)}}">
                        @if($item['cat']['status_vt'] != 1)
                            @can('tomoc-soanvt')
                            <a class="vattu" type="button" data-toggle="modal" data-target="#vattu" data-sort="{{$k}}" data-item="{{$item['cat']['item']}}" data-lenh="{{$item['cat']->lenh}}" data-name="{{$item['cat']->name}}" data-soluong="{{$item['cat']->so_luong}}" data-kehoach="{{$item['cat']->id_kehoach}}" data-loai="1">
                                @if($item['cat']['status_vt'] != 1)
                                <span class="label label-default">Chờ xuất</span><br>
                                @endif
                            </a>
                            @endcan
                            @cannot('tomoc-soanvt')
                            <span class="label label-default">Chờ xuất</span><br>
                            @endcan
                        @endif
                        @if($item['cat']['status_vt'] == 1)
                        <span class="label label-default">Đã xuất</span><br>
                        @endif
                        @if($item['cat']['user_id1'] != null)
                            <br><a class="filevattu" type="button" data-toggle="modal" data-target="#filevattu" data-kehoach="{{$item['cat']->id_kehoach}}" data-stt="1">Lần 1</a>: {{date('H:i d-m',strtotime($item['cat']['time_mot_vt']))}}
                            <br><span class="bg-aqua">{{$item['cat']['lan_mot_vt']}}</span>
                        @endif
                        @if($item['cat']['user_id2'] != null)
                            <br><a class="filevattu" type="button" data-toggle="modal" data-target="#filevattu" data-kehoach="{{$item['cat']->id_kehoach}}" data-stt="2">Lần 2</a>: {{date('H:i d-m',strtotime($item['cat']['time_hai_vt']))}}
                            <br><span class="bg-yellow">{{$item['cat']['lan_hai_vt']}}</span>
                        @endif
                        @if($item['cat']['user_id3'] != null)
                            <br><a class="filevattu" type="button" data-toggle="modal" data-target="#filevattu" data-kehoach="{{$item['cat']->id_kehoach}}" data-stt="3">Lần 3</a>: {{date('H:i d-m',strtotime($item['cat']['time_ba_vt']))}}
                            <br><span class="bg-olive">{{$item['cat']['lan_ba_vt']}}</span>
                        @endif
                    </td>
				        @if(!empty($item['donghop']))
				            @include('admin.list-column', ['kien' => $item['donghop'], 'quyen' => 'tomoc-donghop'])
				        @else
				        	<td class="text-center off tcdep" colspan="4"></td>
				        @endif
                    	@if(!empty($item['ep']))
				            @include('admin.list-column', ['kien' => $item['ep'], 'quyen' => 'tomoc-ep'])
				        @else
				        	<td class="text-center off tcdep" colspan="4"></td>
				        @endif
				        @if(!empty($item['cat']))
				            @include('admin.list-column', ['kien' => $item['cat'], 'quyen' => 'tomoc-cat'])
				        @else
				        	<td class="text-center off tcdep" colspan="4"></td>
				        @endif
				        @if(!empty($item['cnc']))
				            @include('admin.list-column', ['kien' => $item['cnc'], 'quyen' => 'tomoc-cnc'])
				        @else
				        	<td class="text-center off tcdep" colspan="4"></td>
				        @endif
				        @if(!empty($item['hoanthien']))
				            @include('admin.list-column', ['kien' => $item['hoanthien'], 'quyen' => 'tomoc-hoanthanh'])
				        @else
				        	<td class="text-center off tcdep" colspan="4"></td>
				        @endif
                    @can('qc')
                    <td class="text-center {{$key ==  0 ? '' : 'offshow' }} infoshow{{$item['cat']->id_kehoach}} qsua1 " style="width: 80px;">
                        @foreach($item['cat']['qcnew'] as $khoa => $a)
                            @if($a['end_datetime'] == null)
                                <a class="qcnew" type="button" data-toggle="modal" data-target="#qcnew" data-id="{{$a['id']}}" data-parent="{{$item['cat']['parent']}}" data-name="{{$item['cat']->name}}" data-item="{{$item['cat']->item}}" data-lan="{{$khoa + 1}}" data-time="{{$a['start_datetime']}}">Lần {{$khoa + 1}}:</a> {{$a['dat']}} </br>
                            @else
                                <a class="showqcnew" type="button" data-toggle="modal" data-target="#showqcnew" data-id="{{$a['id']}}" data-parent="{{$item['cat']['parent']}}" data-name="{{$item['cat']->name}}" data-item="{{$item['cat']->item}}" data-lan="{{$khoa + 1}}" data-timestart="{{$a['start_datetime']}}" data-timeend="{{$a['end_datetime']}}">Lần {{$khoa + 1}}: {{$a['dat']}} </a></br>
                            @endif
                        @endforeach

                        <span class="hidden">{{$l1 = isset($item['cat']['qcnew'][0]['dat']) ? $item['cat']['qcnew'][0]['dat'] : 0 }}</span>
                        <span class="hidden">{{$l2 = isset($item['cat']['qcnew'][1]['dat']) ? $item['cat']['qcnew'][1]['dat'] : 0 }}</span>
                        <span class="hidden">{{$l3 = isset($item['cat']['qcnew'][2]['dat']) ? $item['cat']['qcnew'][2]['dat'] : 0 }}</span>
                        <span class="hidden">{{$l4 = isset($item['cat']['qcnew'][3]['dat']) ? $item['cat']['qcnew'][3]['dat'] : 0 }}</span>
                        @if($l1 + $l2 + $l3 + $l4 == $item['cat']['so_luong'])
                            <span class="label label-success">Finish</span>
                        @else
                        <a class="qc" type="button" data-toggle="modal" data-target="#qc" data-parent="{{$item['cat']['parent']}}">
                            <span class="label label-default">Chờ qc</span><br>
                        </a>
                        @endif
                    </td>

                    <td class="text-center off qsua1">
                        @if($item['cat']['start_one'] == null)
                        @can('leader-tomoc')
                        <a type="button" data-parent="{{$item['cat']['parent']}}" href="#" class="action_dit" data-status="0" data-stt="1">
                            <span class="label label-warning">Chờ</span>
                        </a>
                        @endcan
                        @cannot('leader-tomoc')
                        <span class="label label-warning">Chờ</span>
                        @endcan
                        @elseif($item['cat']['end_one'] == null)
                        @can('leader-tomoc')
                        <a type="button" data-parent="{{$item['cat']['parent']}}" href="#" class="action_dit" data-status="1" data-stt="1">
                            <span class="label label-info">Start</span>
                            {{$item['cat']['start_one']}}
                        </a>
                        @endcan
                        @cannot('leader-tomoc')
                            <span class="label label-info">Start</span>
                            {{$item['cat']['start_one']}}
                        @endcan
                        @elseif($item['cat']['start_one'] != null and $item['cat']['end_one'] != null)
                            <span class="label label-default">Finish</span>
                            {{$item['cat']['start_one']}} - {{$item['cat']['end_one']}}
                        @endif
                    </td>

                    <td class="text-center off qsua2">
                        @if($item['cat']['start_two'] == null)
                        @can('leader-tomoc')
                        <a type="button" data-parent="{{$item['cat']['parent']}}" href="#" class="action_dit" data-status="0" data-stt="2">
                            <span class="label label-warning">Chờ</span>
                        </a>
                        @endcan
                        @cannot('leader-tomoc')
                        <span class="label label-warning">Chờ</span>
                        @endcan
                        @elseif($item['cat']['end_two'] == null)
                        @can('leader-tomoc')
                        <a type="button" data-parent="{{$item['cat']['parent']}}" href="#" class="action_dit" data-status="1" data-stt="2">
                            <span class="label label-info">Start</span>
                            {{$item['cat']['start_two']}}
                        </a>
                        @endcan
                        @cannot('leader-tomoc')
                            <span class="label label-info">Start</span>
                            {{$item['cat']['start_two']}}
                        @endcan
                        @elseif($item['cat']['start_two'] != null and $item['cat']['end_two'] != null)
                            <span class="label label-default">Finish</span>
                            {{$item['cat']['start_two']}} - {{$item['cat']['end_two']}}
                        @endif
                    </td>
                    <td class="text-center off qsua3">
                        @if($item['cat']['start_three'] == null)
                        @can('leader-tomoc')
                        <a type="button" data-parent="{{$item['cat']['parent']}}" href="#" class="action_dit" data-status="0" data-stt="3">
                            <span class="label label-warning">Chờ</span>
                        </a>
                        @endcan
                        @cannot('leader-tomoc')
                        <span class="label label-warning">Chờ</span>
                        @endcan
                        @elseif($item['cat']['end_three'] == null)
                        @can('leader-tomoc')
                        <a type="button" data-parent="{{$item['cat']['parent']}}" href="#" class="action_dit" data-status="1" data-stt="3">
                            <span class="label label-info">Start</span>
                            {{$item['cat']['start_three']}}
                        </a>
                        @endcan
                        @cannot('leader-tomoc')
                            <span class="label label-info">Start</span>
                            {{$item['cat']['start_three']}}
                        @endcan
                        @elseif($item['cat']['start_three'] != null and $item['cat']['end_three'] != null)
                        <span class="label label-default">Finish</span>
                        {{$item['cat']['start_three']}} - {{$item['cat']['end_three']}}
                        @endif
                    </td>
                    @endcan
                    <td class="{{$key == 0 ? '' : 'hide' }} text-center" rowspan="{{count($s)}}" style="width: 144px;">{{$item['cat']['date_nhapkho']}}<br>
                        {{\App\Common::nhapkho($item['cat']['parent'])}}%<br>
                        @if($item['cat']['status_nk'] == 0)
                            @can('nhapkho-moc')
                            <a class="nhapkho" type="button" data-toggle="modal" data-target="#nhapkho" data-sort="{{$k}}" data-item="{{$item['cat']['item']}}" data-lenh="{{$item['cat']->lenh}}"  data-name="{{$item['cat']->name}}" data-soluong="{{$item['cat']->so_luong}}" data-kehoach="{{$item['cat']->id_kehoach}}" data-loai="2">
                                @if($item['cat']['status_nk'] == 0)
                                <span class="label label-default">Chờ nhập</span><br>
                                @endif
                            </a>
                            @endcan
                            @cannot('nhapkho-moc')
                            <span class="label label-default">Chờ nhập</span><br>
                            @endcan
                        @endif
                        @if($item['cat']['status_nk'] == 1)
                        <span class="label label-default">Đã nhập</span><br>
                        @endif
                        @if($item['cat']['lan_mot'] != null)
                            <br><span class="bg-aqua">{{$item['cat']['lan_mot']}}</span> {{date('H:i d-m',strtotime($item['cat']['time_mot']))}}
                        @endif
                        @if($item['cat']['lan_hai'] != null)
                            <br><span class="bg-aqua">{{$item['cat']['lan_hai']}}</span> {{date('H:i d-m',strtotime($item['cat']['time_hai']))}}
                        @endif
                        @if($item['cat']['lan_ba'] != null)
                            <br><span class="bg-aqua">{{$item['cat']['lan_ba']}}</span> {{date('H:i d-m',strtotime($item['cat']['time_ba']))}}
                        @endif
                        @if($item['cat']['lan_bon'] != null)
                            <br><span class="bg-aqua">{{$item['cat']['lan_bon']}}</span> {{date('H:i d-m',strtotime($item['cat']['time_bon']))}}
                        @endif
                        @if($item['cat']['lan_nam'] != null)
                            <br><span class="bg-aqua">{{$item['cat']['lan_nam']}}</span> {{date('H:i d-m',strtotime($item['cat']['time_nam']))}}
                        @endif
                    </td>
                </tr>
                @endif
              
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div> 
    <div class="modal fade" id="filevattu" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close refesh" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tài Liệu</h4>
                </div>
                <div class="modal-body">
                    <div class="showVT"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="play" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close refesh" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bạn có muốn thao tác không?</h4>
                </div>
                <div class="modal-body">
                    <div class="error">
                    </div>
                    <input type="hidden" name="tre" id="changetre">
                    <input type="hidden" name="dinhmuc" id="changedinhmuc">
                    <input type="hidden" name="sort" id="changesort">
                    <input type="hidden" name="parent" id="changeparent">
                    <input type="hidden" name="status" id="status">
                    <input type="hidden" name="id" id="changeid">
                    <input type="hidden" name="cdc" id="chinh">
                    <input type="hidden" name="tt" id="changett" value="1">
                    <div class="col-md-12 end_check form-group">
                        <label>Số lượng tạm dừng</label>
                        <input type="text" class="form-control" placeholder="Nhập số lượng tạm dừng" id="tdsl" name="tdsl">
                    </div>
                    <a href="#" onclick="changelenh()"  class="btn btn-primary pull-right start_check">Start</a>
                    <a href="#" onclick="changelenh()"  class="btn btn-primary pull-right end_check finish">Finish</a>
                    <a href="#" onclick="tamdunglenh()"  class="btn btn-danger end_check">Tạm Dừng</a>
                </div>
                <div class="modal-footer" style="clear: both;">
                    <button type="button" class="refesh btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="qc_leader" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close refesh" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bạn có muốn thao tác không?</h4>
                </div>
                <div class="modal-body">
                    <div class="error">
                    </div>
                    <input type="hidden" name="sort" id="sortqc">
                    <input type="hidden" name="parent" id="parentqc">
                    <input type="hidden" name="status" id="status-qc">
                </div>
                <div class="modal-footer" style="clear: both;">
                    <button type="button" class="refesh btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <a href="#" onclick="qclenh()" class="btn btn-primary pull-right start_check_qc">Start</a>
                    <a href="#" onclick="qclenh()" class="btn btn-primary pull-right end_check_qc finish">Finish</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="nhapkho" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close refesh" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bạn có muốn thao tác <span id="loai"></span> lệnh <b id="nk-lenh"></b> không?</h4>
                </div>
                <div class="modal-body">
                    <label>Nhập Số Lượng</label>
                    <input type="name" name="soluong" id="sl_nhapkho" style="width: 100%;" placeholder=" Nếu nhập đủ thì bỏ qua">
                </div>
                <div class="modal-footer" style="clear: both;">
                    <input type="hidden" name="sort" id="sort_nhapkho">
                    <input type="hidden" name="kehoach" id="kehoach_nhapkho">
                    <input type="hidden" name="kehoach" id="soluong_nhapkho">
                    <input type="hidden" name="phanloai" id="phan_loai">
                    <a type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</a>
                    <a href="#" onclick="updateNhapKho()" type="button" class="btn btn-primary">Đồng Ý</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="vattu" role="dialog">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close refesh" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bạn có muốn thao tác <span id="loai-vattu"></span> lệnh <b id="nk-lenh-vattu"></b> không?</h4>
                </div>
                <div class="modal-body">
                    <form id="data-vt" enctype="multipart/form-data">
                        <label>Nhập Số Lượng</label>
                        <textarea type="name" name="vattu" id="sl_vattu" style="width: 100%;" placeholder="Nhập số lượng muốn xuất"></textarea>
                        <input type="file" name="uploadfile[]" multiple="multiple" style="width: 100px;">
                        <input type="checkbox" name="xuatdu" value="1"> Xuất Đủ
                        <input type="hidden" name="sort" id="sort_vattu">
                        <input type="hidden" name="kehoach" id="kehoach_vattu">
                        <input type="hidden" name="soluong" id="soluong_vattu">
                        <input type="hidden" name="phanloai" id="phan_loai_vattu">
                        <input class="submit_vt btn btn-primary pull-right" type="button" value="Đồng Ý">
                    </form>
                </div>
                <div class="modal-footer" style="clear: both;">
                    <a type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="moveLenh" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bạn có muốn thao tác không?</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idparent" id="idparent" value="">
                </div>
                <div class="modal-footer">
                    <a type="button" onclick="cancelMove()" class="btn btn-default pull-left" data-dismiss="modal">Close</a>
                    <a href="#" onclick="updateMove()" type="button" class="btn btn-primary">Đồng Ý</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lock" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <input type="hidden" id="lock-parent" >
                    <input type="hidden" id="lock-soluong" >
                    <input type="hidden" id="lock-lenh" >
                    <input type="hidden" id="sort">
                    <h3 class="modal-title">Bạn đang gỡ kiện <b class="lock-kien"></b> ra khỏi item <b class="lock-item"></b>?</h3>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</a>
                    <a href="#" onclick="unlock()" type="button" class="btn btn-primary">Đồng Ý</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="qc" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close refesh" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bạn có muốn thao tác <span id="loai"></span> lệnh <b id="nk-lenh"></b> không?</h4>
                </div>
                <div class="modal-footer" style="clear: both;">
                    <input type="hidden" name="sort" id="parent_add">
                    <a type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</a>
                    <a href="#" type="button" class="btn btn-primary actiontimeqc" >Start</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="qcnew" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span>QC</span> kiện <span class="qc_kien"></span> của <span class="qc_item"></span></h4>
                </div>
                <div class="modal-body table-responsive">
                    Thời gian bắt đầu QC lần <span class="qc_lan"></span> vào lúc: <br/><i class="qc_time"></i>
                    <form id="data-qc" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                <label>Tổng</label>
                                <input type="hidden" id="qcnew_id" name="id">
                                <input type="hidden" name="parent" id="parent_qcnew">
                                <input type="text" name="tong" style="width: 30px;">
                            </div>
                            <div class="col-md-4 col-xs-4">
                                <label>Đạt</label>
                                <input type="text" name="dat" style="width: 30px;">
                            </div>
                            <div class="col-md-4 col-xs-4">
                                <label>Không</label>
                                <input type="text" name="notdat" style="width: 30px;">
                            </div>
                        </div>
                        <div>
                            <label>Mã Lỗi</label>
                            <select class="form-control select2 select2-hidden-accessible" data-placeholder="Trống" style="width: 100%;" id="maloi" name="maloi">
                                <option></option>
                                @foreach($loi as $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Nguyên Nhân</label>
                            <select class="form-control select2 select2-hidden-accessible" data-placeholder="Trống" style="width: 100%;" id="nguyennhan" name="nguyennhan">
                                <option></option>
                                @foreach($nguyennhan as $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Kiểm Tra</label>
                            <select class="form-control select2 select2-hidden-accessible" data-placeholder="Trống" style="width: 100%;" id="kiemtra" name="kiemtra">
                                <option></option>
                                @foreach($kiemtra as $value)
                                    <option value="{{$value->id}}">{{$value->huong_dan}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Giải Pháp</label>
                            <select class="form-control select2 select2-hidden-accessible" data-placeholder="Trống" style="width: 100%;" id="giaiphap" name="giaiphap">
                                <option></option>
                                @foreach($giaiphap as $value)
                                    <option value="{{$value->id}}">{{$value->huong_dan}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Tài Liệu</label>
                            <input type="file" name="file[]" multiple="multiple">
                        </div>
                        <div>
                            <label>Đề Xuất</label>
                            Hủy/SX Lại: <input type='radio' id='radio_1' name='type' value='1'/>
                            Sửa: <input type='radio' id='radio_2' name='type' value='2'/>
                        </div>    
                        <input class="submit_qc pull-right" type="button" value="Đồng Ý">
                    </form>
                </div>
                <div class="modal-footer">
                    <a type="button" class="close btn btn-default pull-left" data-dismiss="modal">Close</a>
                    <a href="#" type="button" class="btn btn-primary deleteqcnew">Xóa</a>
                </div>
            </div>
        </div>
    </div>   

    <div class="modal fade" id="showqcnew" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span>QC</span> kiện <span class="showqc_kien"></span> của <span class="showqc_item"></span></h4>
                </div>
                <div class="modal-body table-responsive">
                    Thời gian bắt đầu QC lần <span class="showqc_lan"></span> vào lúc: <i class="showqc_starttime"></i></br>
                    Thời gian kết thúc QC lần <span class="showqc_lan"></span> vào lúc: <i class="showqc_endtime"></i>

                    <p>QC:<b class="qc_name"></b></p>
                    <p>Số Lượng Đạt/ Không Đạt: <b class="showqcdat"></b>/<b class="showqckhongdat"></b></p>
                    <p>Mã Lỗi: <b class="shoqqc_maloi"></b></p>
                    <p>Nguyên Nhân: <b class="shoqqc_nguyennhan"></b></p>
                    <p>Phương Pháp Kiểm Tra: <b class="shoqqc_kiemtra"></b></p>
                    <p>Giải Pháp: <b class="shoqqc_giaiphap"></b></p>
                    <p>Đề Xuất: <b class="shoqqc_dexuat"></b></p>
                </div>
                <div class="modal-footer">
                    <a type="button" class="close btn btn-default pull-left" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>  

    <div class="modal fade" id="note_kien" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <input type="hidden" id="note-parent" >
                    <input type="hidden" id="note-soluong" >
                    <input type="hidden" id="note-lenh" >
                    <input type="hidden" id="note-sort">
                    <input type="hidden" id="note-type">
                    <h3 class="modal-title">Bạn đang nhập ghi chú cho <b class="note-kien"></b> của item <b class="note-item"></b>?</h3>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" rows="3" placeholder="Nhập Ghi Chú ..." id="note_noidung"></textarea>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</a>
                    <a href="#" onclick="note()" type="button" class="btn btn-primary">Đồng Ý</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="note_content" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Nội Dung Ghi Chú Của Kiện <b class="note-kien"></b> Với Item Là <b class="note-item"></b>?</h3>
                </div>
                 <div class="modal-body">
                    <p id="note_show"></p>
                    <table>
                        <thead>
                            <tr>
                                <th>Nhân Viên</th>
                                <th>Nội Dung</th>
                                <th>Thời Gian</th>
                            </tr>
                        </thead>
                        <tbody class="show_note">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <a type="button" class="close btn btn-default pull-left" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="remove" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <input type="hidden" id="remove-parent">
                    <input type="hidden" id="remove-soluong">
                    <input type="hidden" id="remove-lenhlink">
                    <input type="hidden" id="remove-sort">
                    <h3 class="modal-title">Bạn có chắc chắc hủy lệnh <b id="remove-lenh"></b> ?</h3>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</a>
                    <a href="#" onclick="removeLenh()" type="button" class="btn btn-primary">Đồng Ý</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="stop" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <input type="hidden" id="td-parent">
                    <input type="hidden" id="td-soluong">
                    <input type="hidden" id="td-item">
                    <input type="hidden" id="td-sort">
                    <input type="hidden" id="td-lenh">
                    <input type="hidden" id="td-lenhname">
                    <h3 class="modal-title">Bạn có chắc chắc tạo lệnh còn lại ?</h3>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</a>
                    <a href="#" onclick="createdk()" type="button" class="btn btn-primary">Đồng Ý</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("js")
<script src="{{asset('js/select2/dist/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
    $('#maloi, #nguyennhan, #kiemtra, #giaiphap').select2({
        multiple: false,
    });
    $('#select-cd').select2();
    $('.off').hide();
    $('#select-cd').change(function(){
    	var data = $(this).val();
        $('.off').hide();
        if (data == 'all') {
		    var list = $("#select-cd .congdoan").map(function() {
		    	return $(this).val();
		    }).get();
        }else{
        	var list = data;
        }
    	console.log(list);

        $.each(list, function( key, value ) {
			$('#' + value).show();
			$('#kh' + value).show(); $('.st' + value).show();
			$('#dm' + value).show(); $('.ti' + value).show();
			$('#tt' + value).show(); $('.t' + value).show();
			$('#qc' + value).show(); $('.q' + value).show();$('.qsua1').show();
		});
    });

    // $(".allinfo").click(function () {
    //     var selector = $(this).data('show');
    //     $(selector).removeClass('');    
    // });

    $('.allinfo').each(function () {
        var $this = $(this);
        $this.on("click", function () {
            $('.'+ $(this).data('show')).siblings(".offshow").toggle();
            $('.'+ $(this).data('show')).siblings(".off").toggle();
            $('.showmore').siblings(".off").toggle();
        });
    });

    $(".close").click(function () {
        $('.delete_table').remove();    
    });

    $('.submit_vt').click(function(){ 
        $.ajax({
            url:"/addVattu",
            type:'post',
            data:  new FormData($("#data-vt")[0]),
            dataType:'json', 
            async:false, 
            processData: false, 
            contentType: false, 
            success:function(data){
                $.bootstrapGrowl("Update thành công", { type: 'success' });
                setTimeout(function(){
                   window.location.reload(); 
                }, 400);
            }
        });
    });

    $('.filevattu').click(function(){ 
        $.ajax({
            url:"/showVatTu",
            type:'post',
            data: {
                kehoach : $(this).data('kehoach'),
                stt : $(this).data('stt'),
            },
            success:function(data){
                var res='';
                var img='';
                $.each (data.link, function (key, value) {
                    img += '<img src="'+value+'" style="width:100%"> <br>'
                });
                res =
                'Người đăng: <h4 style="display: inline;"><i>'+data.user+
               '</h4></i><br>'+img;
                $('.showVT').html(res);

            }
        });
    });

    $('#maloi').change(function(){
        var idver =$(this).val();
        $.get("/findnguyennhan/"+idver,function(data){
            $("#nguyennhan").html(data);
        });
        $.get("/findkiemtra/"+idver,function(data){
            $("#kiemtra").html(data);
        });
        $.get("/findgiaiphap/"+idver,function(data){
            $("#giaiphap").html(data);
        });
    });

    $('.qcnew').click(function () {
        $('.qc_kien').text($(this).data('name'));
        $('.qc_item').text($(this).data('item'));
        $('.qc_lan').text($(this).data('lan'));
        $('.qc_time').text($(this).data('time'));
        $('#parent_qcnew').val($(this).data('parent'));   
        $('#qcnew_id').val($(this).data('id'));           
    });

    $('.showqcnew').click(function () {
        $('.showqc_kien').text($(this).data('name'));
        $('.showqc_item').text($(this).data('item'));
        $('.showqc_lan').text($(this).data('lan'));
        $('.showqc_starttime').text($(this).data('timestart'));
        $('.showqc_endtime').text($(this).data('timeend'));
        $.ajax({
            url:"/showQC",
            type:'post',
            data: {
                parent : $(this).data('parent'),
                id : $(this).data('id'), 
            },
            success:function(data){
                $('.qc_name').text(data.name_qc);
                $('.showqcdat').text(data.dat);
                $('.showqckhongdat').text(data.khong_dat);
                $('.shoqqc_nguyennhan').text(data.nguyennhan.name);
                $('.shoqqc_giaiphap').text(data.giaiphap.huong_dan);
                $('.shoqqc_kiemtra').text(data.kiemtra.huong_dan);
                $('.shoqqc_maloi').text(data.maloi.name);
                if (data.status == 2) {
                    $('.shoqqc_dexuat').text('Sửa');
                }else{
                    $('.shoqqc_dexuat').text('Hủy/SX Lại');
                }
            }
        });
    });

    $('.actiontimeqc').click(function(){
        $.ajax({
            url:"/actiontimeqc",
            type:'post',
            data: {
                parent : $('#parent_add').val(),
            },
            success:function(data){
                $.bootstrapGrowl(data.message, { type: 'success' });
                setTimeout(function(){
                   window.location.reload(); 
                }, 200);
            }
        });
    });

    $('.qc').click(function(){ 
        $('#parent_add').val($(this).data('parent'));
    });

    $('.submit_qc').click(function(){
        $.ajax({
            type: 'post',
            url: '/qc',
            data:  new FormData($("#data-qc")[0]),
            dataType:'json', 
            async:false, 
            processData: false, 
            contentType: false, 
            success: function(data){
                $.bootstrapGrowl(data.message, { type: 'success' });
                setTimeout(function(){
                   window.location.reload(); 
                }, 200);
            }
        })
    })

    $(document).ready(function(){
        var parameters = new URL(window.location).searchParams;
        var parent = parameters.get('parent') ;
        $(".scroll"+parent)[0].scrollIntoView({ inline: "nearest"});
        $(".scroll"+parent).scrollTop(150);
    	var data = $('#select-cd').val();
        $('.off').hide();
        if (data == 'all') {
		    var list = $("#select-cd .congdoan").map(function() {
		    	return $(this).val();
		    }).get();
        }else{
        	var list = data;
        }

        $.each(list, function( key, value ) {
			$('#' + value).show();
			$('#kh' + value).show(); $('.st' + value).show();
			$('#dm' + value).show(); $('.ti' + value).show();
			$('#tt' + value).show(); $('.t' + value).show();
			$('#qc' + value).show(); $('.q' + value).show();
		});
    });

    $('.refesh').click(function () {
        $('.end_check').removeClass('hidden');
        $('.start_check').removeClass('hidden');
    })

    $('.lock').click(function () {
        $('.lock-kien').text($(this).data('name'));
        $('.lock-item').text($(this).data('item'));
        $('#lock-soluong').val($(this).data('soluong'));
        $('#lock-parent').val($(this).data('parent'));
        $('#lock-lenh').val($(this).data('lenh'));
        $('#sort').val($(this).data('sort'));
    });

    $('.note_kien').click(function () {
        $('.note-kien').text($(this).data('name'));
        $('.note-item').text($(this).data('item'));
        $('#note-soluong').val($(this).data('soluong'));
        $('#note-parent').val($(this).data('parent'));
        $('#note-lenh').val($(this).data('lenh'));
        $('#note-sort').val($(this).data('sort'));
        $('#note-type').val($(this).data('type'));
    });

    $('.note_content').click(function () {
        $('.show-kien').text($(this).data('name'));
        $('.show-item').text($(this).data('item'));
        $('#note_show').text($(this).data('content'));
        $.ajax({
            url:"/showNote",
            type:'post',
            data: {
                sort      : $(this).data('sort'),
                parent    : $(this).data('parent'),
                type      : $(this).data('type'),
            },
            success:function(data){
                var res='';
                $.each (data, function (key, value) {
                    res +=
                    '<tr class="delete_table">'+
                        '<td>'+value.name+'</td>'+
                        '<td>'+value.content+'</td>'+
                        '<td>'+value.updated_at+'</td>'+
                   '</tr>';
                    $('.show_note').html(res);
                });
            }
        });
    });

    $('.nhapkho').click(function () {
        $('#sort_nhapkho').val($(this).data('sort'));
        $('#nk-kien').text($(this).data('name'));
        $('#nk-lenh').text($(this).data('lenh'));
        $('#kehoach_nhapkho').val($(this).data('kehoach'));
        $('#phan_loai').val($(this).data('loai'));
        $('#soluong_nhapkho').val($(this).data('soluong'));
        var phanloai = $(this).data('loai');
        if (phanloai == 1) {
            $('#loai').text('xuất vật tư');
        }
        if (phanloai == 2) {
            $('#loai').text('nhập kho');
        }
    });

    $('.vattu').click(function () {
        $('#sort_vattu').val($(this).data('sort'));
        $('#nk-kien-vattu').text($(this).data('name'));
        $('#nk-lenh-vattu').text($(this).data('lenh'));
        $('#kehoach_vattu').val($(this).data('kehoach'));
        $('#phan_loai_vattu').val($(this).data('loai'));
        $('#soluong_vattu').val($(this).data('soluong'));
        var phanloai = $(this).data('loai');
        if (phanloai == 1) {
            $('#loai-vattu').text('xuất vật tư');
        }
    });

    $('.remove-lenh').click(function () {
        $('#remove-lenh').text($(this).data('lenh'));
        $('#remove-lenhlink').val($(this).data('lenhlink'));
        $('#remove-soluong').val($(this).data('soluong'));
        $('#remove-parent').val($(this).data('parent'));
        $('#remove-sort').val($(this).data('sort'));
    });

    $('.td-lenh').click(function () {
        $('#td-lenh').val($(this).data('lenh'));
        $('#td-lenhname').val($(this).data('lenhname'));
        $('#td-item').val($(this).data('item'));
        $('#td-soluong').val($(this).data('soluong'));
        $('#td-parent').val($(this).data('parent'));
        $('#td-sort').val($(this).data('sort'));
    });

    $('.infolenh').click(function(){
        var check = $(this).data('status_kehoach');
        if(check == 0) {
            $('.end_check').addClass('hidden');
        }
        if(check == 1) {
            $('.start_check').addClass('hidden');
        }
        $('#changetre').val($(this).data('tre'));
        $('#changedinhmuc').val($(this).data('dinhmuc'));
        $('#changesort').val($(this).data('sort'));
        $('#status').val($(this).data('status'));
        $('#changeparent').val($(this).data('parent'));
        $('#changeid').val($(this).data('id'));
        $('#chinh').val($(this).data('chinh'));
    });

    $('.qc_leader').click(function(){
        var check = $(this).data('status_qc');
        if(check == 1) {
            $('.end_check_qc').addClass('hidden');
        }
        if(check == 2) {
            $('.start_check_qc').addClass('hidden');
        }
        $('#sortqc').val($(this).data('sort'));
        $('#status-qc').val($(this).data('status_qc'));
        $('#parentqc').val($(this).data('parent'));
    });
    
    $( ".row_position" ).sortable({
        delay: 50,
        stop: function() {
            var selectedData = new Array();
            $('.row_position>tr').each(function() {
                selectedData.push($(this).attr("id"));
            });
            updateOrder(selectedData);
        }
    });

    function createdk() {
        $.ajax({
            url:"/createdk",
            type:'post',
            data: {
                id      : $('#td-parent').val(),
                soluong : $('#td-soluong').val(),
                lenh    : $('#td-lenh').val(),
                sort    : $('#td-sort').val(),
                item    : $('#td-item').val(),
                lenhname: $('#td-lenhname').val()
            },
            success:function(data){
                $.bootstrapGrowl("Update thành công", { type: 'success' });
                setTimeout(function(){
                   window.location.reload(); 
                }, 400); 
            }
        })
    }

    $(".action_dit").click(function() {
        $.ajax({
            url:"/action",
            type:'post',
            data: {
                parent : $(this).data('parent'),
                status : $(this).data('status'),
                stt    : $(this).data('stt')
            },
            success:function(data){
                $.bootstrapGrowl("Update thành công", { type: 'success' });
                setTimeout(function(){
                   window.location.reload(); 
                }, 400); 
            }
        })
    });

    function updateOrder(data) {
        $.ajax({
            url:"/ajaxmove",
            type:'post',
            data: {
                position:data
            },
            success:function(data){
                console.log(data);
                if ($.isNumeric(data)) {
                    $('#idparent').val(data);
                    $('#moveLenh').modal('show');
                    $.bootstrapGrowl("Đổi thứ tự thành công", { type: 'success' });
                }else {
                    $.bootstrapGrowl("Lỗi", { type: 'danger' });
                    setTimeout(function(){
                       window.location.reload(); 
                    }, 200); 
                }
            }
        })
    }

    function updateMove() {
        $.ajax({
            url:"/updateLenh",
            type:'post',
            data: {
                id_menu: $('#idparent').val(),
            },
            success:function(data){
                console.log(data);
                $('#idparent').val(data);
                $('#moveLenh').modal('show');
                $.bootstrapGrowl("Update thành công", { type: 'success' });
                setTimeout(function(){
                   window.location.reload(); 
                }, 200); 
            }
        })
    }

    function changelenh() {
        var changelenh= '{{ route("changelenh") }}';
        $.ajax({
            data: {
                sort   : $('#changesort').val(),
                parent : $('#changeparent').val(),
                dinhmuc: $('#changedinhmuc').val(),
                tre    : $('#changetre').val(),
                status : $('#status').val(),
                id     : $('#changeid').val(),
                chinh  : $('#chinh').val(),
                select : $('#select-cd').val(),
            },
            url: changelenh,
            type: 'POST',
            success: function(data) {
                if(data.status === true) {
                	// console.log(data.select.length);
                    $.bootstrapGrowl(data.message, { type: 'success' });
                    var link = 'lenh';
                    var i;
                    var text = '';
					for (i = 0; i < data.select.length; i++) {
						if (data.select[i] == 'all') {
						    var list = $("#select-cd .congdoan").map(function() {
						    	return $(this).val();
						    }).get();
						    for (var j = 0; j < list.length; j++) {
							    var res = list[j].substring(2, list[j].length);
								text += '&select[]='+res;
							}
				        }else{
							var res = data.select[i].substring(2, data.select[i].length);
							text += '&select[]='+res;
				        }
					}
                    setTimeout(function(){
                       window.location.href = '/lenh?parent='+data.parent+text; 
                    }, 200); 
                }
            },
        });
    }

    function qclenh() {
        var qclenh = '{{ route("qclenh") }}';
        $.ajax({
            data: {
                sort   : $('#sortqc').val(),
                parent : $('#parentqc').val(),
                status : $('#status-qc').val(),
                select : $('#select-cd').val(),
            },
            url: qclenh,
            type: 'POST',
            success: function(data) {
                if(data.status === true) {
                    $.bootstrapGrowl(data.message, { type: 'success' });
                    var link = 'lenh';
                    var i;
                    var text = '';
                    for (i = 0; i < data.select.length; i++) {
                        if (data.select[i] == 'all') {
                            var list = $("#select-cd .congdoan").map(function() {
                                return $(this).val();
                            }).get();
                            for (var j = 0; j < list.length; j++) {
                                var res = list[j].substring(2, list[j].length);
                                text += '&select[]='+res;
                            }
                        }else{
                            var res = data.select[i].substring(2, data.select[i].length);
                            text += '&select[]='+res;
                        }
                    }
                    setTimeout(function(){
                       window.location.href = '/lenh?parent='+data.parent+text; 
                    }, 200); 
                }
            },
        });
    }

    function removeLenh() {
        var removeLenh = '{{ route("removeLenh") }}';
        $.ajax({
            data: {
                id 		: $('#remove-parent').val(),
                soluong : $('#remove-soluong').val(),
                lenh    : $('#remove-lenh').text(),
                sort    : $('#remove-sort').val(),
                lenh_link : $('#remove-lenhlink').val(),
            },
            url: removeLenh,
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
    }

	function unlock() {
        var unlock = '{{ route("unlock") }}';
        $.ajax({
            data: {
                item    : $('.lock-item').text(),
                kien    : $('.lock-kien').text(),
                id 		: $('#lock-parent').val(),
                soluong : $('#lock-soluong').val(),
                lenh    : $('#lock-lenh').val(),
                sort    : $('#sort').val(),
            },
            url: unlock,
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
    }

    function note() {
        var note = '{{ route("note") }}';
        $.ajax({
            data: {
                item    : $('.note-item').text(),
                kien    : $('.note-kien').text(),
                id      : $('#note-parent').val(),
                soluong : $('#note-soluong').val(),
                lenh    : $('#note-lenh').val(),
                sort    : $('#note-sort').val(),
                content : $('#note_noidung').val(),
                type    : $('#note-type').val(),
            },
            url: note,
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
    }

    function duyetqc(elem) {
        var status = $('input[type=radio]:checked').val();
        var id = elem.getAttribute("data-id");
        var duyetqc = '{{ route("duyetqc") }}';
        $.ajax({
            data: {
                status : status,
                id     : id,
            },
            url: duyetqc,
            type: 'POST',
            success: function(data) {
                var type = '';
                if(data.status == 1) {
                    type = '<td class="text-center"><i class="fa fa-check"></i></td><td></td><td>'+data.name+'</td>';
                }
                if(data.status == 2) {
                    type = '<td></td><td class="text-center"><i class="fa fa-check"></i></td><td>'+data.name+'</td>';
                }
                $('.addtd'+data.id).append(type);
                $('.removeqc'+data.id).remove();
            },
        });
    }

    function updateNhapKho() {
        var nhapkho = '{{ route("nhapkho") }}';
        $.ajax({
            data: {
                sort    : $('#sort_nhapkho').val(),
                id_kehoach    : $('#kehoach_nhapkho').val(),
                soluong    : $('#soluong_nhapkho').val(),
                sl_nhapkho : $('#sl_nhapkho').val(),
                loai : $('#phan_loai').val()
            },
            url: nhapkho,
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
    }

    function tamdunglenh() {
        var form = $('#tdsl').val();
        var txt1 = '<div class="callout callout-warning "><p id="error">';               
        var txt2 = '</p></div>';  
        var tamdunglenh= '{{ route("tamdunglenh") }}';
        if( form.length === 0 ) { 
            $(".callout").remove();
            $(".error").append(txt1+ 'Hãy Nhập Số Lượng Đã Sản Xuất Được Khi Ấn Tạm Dừng</p></div>' +txt2); 
        }else{
            if ($.isNumeric(form)) {
                $.ajax({
                    data: {
                        sort   : $('#changesort').val(),
                        parent : $('#changeparent').val(),
                        dinhmuc: $('#changedinhmuc').val(),
                        tre    : $('#changetre').val(),
                        status : $('#status').val(),
                        id     : $('#changeid').val(),
                        tt     : $('#changett').val(),
                        select : $('#select-cd').val(),
                        sl_dsx : form,
                    },
                    url: tamdunglenh,
                    type: 'POST',
                    success: function(data) {
                        if(data.status === true) {
                            $.bootstrapGrowl(data.message, { type: 'success' });
                            var link = 'lenh';
                            var i;
                            var text = '';
                            for (i = 0; i < data.select.length; i++) {
                                if (data.select[i] == 'all') {
                                    var list = $("#select-cd .congdoan").map(function() {
                                        return $(this).val();
                                    }).get();
                                    for (var j = 0; j < list.length; j++) {
                                        var res = list[j].substring(2, list[j].length);
                                        text += '&select[]='+res;
                                    }
                                }else{
                                    var res = data.select[i].substring(2, data.select[i].length);
                                    text += '&select[]='+res ;
                                }
                            }
                            setTimeout(function(){
                               window.location.href = '/lenh?parent='+data.parent+text;
                            }, 200); 
                        }
                    },
                });
            }else{
                $(".callout").remove();
                $(".error").append(txt1+ 'SỐ LƯỢNG phải là số!</p></div>' +txt2); 
            }
        }
    }

    function cancelMove() {
        var cancelMove= '{{ route("cancelMove") }}';
        $.ajax({
            data: {
                
            },
            url: cancelMove,
            type: 'POST',
            success: function(data) {
                if(data.status === true) {
                    $.bootstrapGrowl(data.message, { type: 'warning' });
                    setTimeout(function(){
                       window.location.reload(); 
                    }, 200); 
                }
            },
        });
    }

    function savePos() {
        var savePos = '{{ route("savePos") }}';
        $.ajax({
            data: {
                
            },
            url: savePos,
            type: 'Get',
            success: function(data) {
                if(data.status === true) {
                    $.bootstrapGrowl(data.message, { type: 'success' });
                    window.location.reload();
                    setTimeout(function(){
                       window.location.reload(); 
                    }, 200); 
                }
            },
        });
    }

    function reset() {
        $("#select-cd").val('').trigger('change');
    }
</script>
@endsection