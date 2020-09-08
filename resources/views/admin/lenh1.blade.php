@extends("app")
@section("css")
<link rel="stylesheet" href="{{asset('js/select2/dist/css/select2.min.css')}}">
@endsection
@section("content")
    <div class="row">       
        <div class="col-md-6">
            <a href="#" onclick="savePos()" class="btn btn-success">Lưu</a>
            <a href="#"  class="btn btn-danger">Hủy</a>
        </div>
        <div class="col-md-6">
            <div class="form-group"> 
                <select class="form-control select2 select2-hidden-accessible" multiple="" style="width: 100%;"  data-placeholder="Chọn Công Đoạn Muốn Xem" id="select-cd">
                    <option></option>
                    <option value="all">Tất Cả</option>
                    @for ($i = 1; $i <= $maxCD; $i++)
                        <option value="cd{{$i}}">Công Đoạn {{$i}}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>
    <div class="table-responsive ">
        <table class="table table-bordered">
            <tr>
                <th rowspan="2" class="text-center">Lệnh</th>
                <th rowspan="2" class="text-center">Item</th>
                <th rowspan="2" class="text-center">Số Lượng</th>
                <th rowspan="2" class="text-center">Kiện</th>
                <th rowspan="2" class="text-center">Nhập Kho</th>
                @for ($i = 1; $i < 5; $i++)
                    <th colspan="4" class="text-center">Công Đoạn {{$i}}</th>
                @endfor
                @for ($i = 5; $i < 11; $i++)
                    <th colspan="4" class="hidden hidden{{$i-4}} text-center">Công Đoạn {{$i}}</th>
                @endfor
            </tr>
            <tr>
                @for ($i = 1; $i < 5; $i++)
                    <td class="text-center">Kế Hoạch</td>
                    <td class="text-center">ĐM</td>
                    <td class="text-center">Trạng Thái</td>
                    <td class="text-center">QC</td>
                @endfor
                @for ($i = 5; $i < 11; $i++)
                    <td class="hidden hidden{{$i-4}} text-center">Kế Hoạch</td>
                    <td class="hidden hidden{{$i-4}} text-center">Định Mức</td>
                    <td class="hidden hidden{{$i-4}} text-center">Trạng Thái</td>
                    <td class="hidden hidden{{$i-4}} text-center">QC</td>
                @endfor
            </tr>
            <tbody class="row_position">
                @foreach($sort as $k => $s)
                @foreach($s as $key => $item)
                @if($item->isNotEmpty())
                <tr id="{{$key ==  0 ? $k : '' }}">
                    <td class="{{$key ==  0 ? '' : 'hide' }} text-center" rowspan="{{count($s)}}"><span>{{$item[0]['lenh']}}</span></td>
                    <td class="{{$key ==  0 ? '' : 'hide' }} text-center" rowspan="{{count($s)}}"><span>{{$item[0]['item']}}</span></td>
                    <td class="{{$key ==  0 ? '' : 'hide' }} text-center" rowspan="{{count($s)}}"><span>{{$item[0]['so_luong']}}</span></td>
                    <td class="text-center"><a href="/ke-hoach?menu=1&parent={{$item[0]['parent']}}">{{$item[0]['name']}}</a></td>
                    <td class="text-center">{{$item[0]['date_nhapkho']}}<br>
                        {{\App\Common::nhapkho($item[0]['parent'])}}
                    </td>
                    @foreach($item as $stt => $kien)
                        @if($stt < 4)
                        <td class="text-center">
                            {{date('H:i',strtotime($kien->start_time))}} - {{date('H:i',strtotime($kien->end_time))}} <br>
                            {{date('d/m',strtotime($kien->start_date))}} - {{date('d/m',strtotime($kien->end_date))}}
                        </td>
                        <td class="text-center bg {{$kien->status ==  1 ? 'bg-success' : ''  }} ">
                            {{$kien->dinhmuc}}</br>
                            @if($kien->status_kehoach == 1)
                            {{(\App\Common::targetS($kien->dinhmuc,$kien->start_time,$kien->start_date,$kien->label))[0]}}<br>    
                            {{(\App\Common::targetS($kien->dinhmuc,$kien->start_time,$kien->start_date,$kien->label))[1]}}
                            @endif
                            @if($kien->status_kehoach == 2)
                            {{(\App\Common::targetF($kien->dinhmuc,$kien->start_time,$kien->start_date,$kien->end_time,$kien->end_date,$kien->label))[0]}}<br>
                            {{(\App\Common::targetF($kien->dinhmuc,$kien->start_time,$kien->start_date,$kien->end_time,$kien->end_date,$kien->label))[1]}}
                            @endif
                        </td>
                        <td class="text-center">
                            @if($kien->status_kehoach == 0)
                            <a class="infolenh" type="button" data-toggle="modal" data-target="#play" data-status_kehoach="{{$kien->status_kehoach}}" data-parent="{{$kien->parent}}" data-sort="{{$kien->sort}}" data-chinh="{{$kien->status}}" data-dinhmuc="{{$kien->dinhmuc}}" data-tre="{{$kien->tre}}" data-status="1" data-id="{{$kien->id}}">Chờ</a>
                            @elseif($kien->status_kehoach == 1)
                            <a class="infolenh" type="button" data-toggle="modal" data-target="#play" data-status_kehoach="{{$kien->status_kehoach}}" data-parent="{{$kien->parent}}" data-sort="{{$kien->sort}}" data-chinh="{{$kien->status}}" data-dinhmuc="{{$kien->dinhmuc}}" data-tre="{{$kien->tre}}" data-status="2" data-id="{{$kien->id}}">Start</a>
                            @elseif($kien->status_kehoach == 2)
                            <span>Finish</span>
                            @elseif($kien->status_kehoach == 3)
                            <span>Tạm Dừng</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="form-group">
                                <select class="form-control" id="sel1">
                                    <option>Lỗi</option>
                                    <option>Đạt</option>
                                    <option>Chờ</option>
                                </select>
                            </div>
                        </td>
                        @endif
                    @endforeach
                    @foreach($item as $stt => $kien)
                        @if($stt > 3)
                        <td class="hidden show-more">
                            {{date('H:i',strtotime($kien->start_time))}} - {{date('H:i',strtotime($kien->end_time))}} <br>
                            {{date('d/m',strtotime($kien->start_date))}} - {{date('d/m',strtotime($kien->end_date))}}
                        </td>
                        <td class="hidden show-more">
                            {{$kien->dinhmuc}}</br>
                            @if($kien->status_kehoach == 1)
                            {{(\App\Common::targetS($kien->dinhmuc,$kien->start_time,$kien->start_date,$kien->label))[0]}}<br>    
                            {{(\App\Common::targetS($lenh->dinhmuc,$kien->start_time,$kien->start_date,$kien->label))[1]}}
                            @endif
                            @if($kien->status_kehoach == 2)
                            {{(\App\Common::targetF($kien->dinhmuc,$kien->start_time,$kien->start_date,$kien->end_time,$kien->end_date,$kien->label))[0]}}<br>
                            {{(\App\Common::targetF($kien->dinhmuc,$kien->start_time,$kien->start_date,$kien->end_time,$kien->end_date,$kien->label))[1]}}
                            @endif
                        </td>
                        <td class="hidden show-more">
                            @if($kien->status_kehoach == 0)
                            <a class="infolenh" type="button" data-toggle="modal" data-target="#play" data-status_kehoach="{{$kien->status_kehoach}}" data-parent="{{$kien->parent}}" data-sort="{{$kien->sort}}" data-dinhmuc="{{$kien->dinhmuc}}" data-tre="{{$kien->tre}}" data-status="1" data-id="{{$kien->id}}">Chờ</a>
                            @elseif($kien->status_kehoach == 1)
                            <a class="infolenh" type="button" data-toggle="modal" data-target="#play" data-status_kehoach="{{$kien->status_kehoach}}" data-parent="{{$kien->parent}}" data-sort="{{$kien->sort}}" data-dinhmuc="{{$kien->dinhmuc}}" data-tre="{{$kien->tre}}" data-status="2" data-id="{{$kien->id}}">Start</a>
                            @elseif($kien->status_kehoach == 2)
                            <span>Finish</span>
                            @elseif($kien->status_kehoach == 3)
                            <span>Tạm Dừng</span>
                            @endif
                        </td>
                        <td class="hidden show-more">
                            <div class="form-group">
                                <select class="form-control" id="sel1">
                                    <option>Lỗi</option>
                                    <option>Đạt</option>
                                    <option>Chờ</option>
                                </select>
                            </div>
                        </td>
                        @endif
                    @endforeach
                    @if(!empty($item[4]))
                    <td class="number-cd"><a class="show-cd" data-id="{{count($item) - 4}}">{{count($item) - 4}}</a></td>
                    @endif
                </tr>
                @endif
                @if($item->isEmpty())
                <tr>
                    <td class="text-center">{{\App\Common::getKien($k,$key)}}</td>       
                </tr>
                @endif
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div> 
    <div class="modal fade" id="play" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close refesh" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bạn có muốn thao tác không?</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="tre" id="changetre">
                    <input type="hidden" name="dinhmuc" id="changedinhmuc">
                    <input type="hidden" name="sort" id="changesort">
                    <input type="hidden" name="parent" id="changeparent">
                    <input type="hidden" name="status" id="status">
                    <input type="hidden" name="id" id="changeid">
                    <input type="hidden" name="cdc" id="chinh">
                    <input type="hidden" name="tt" id="changett" value="1">
                    <a href="#" onclick="changelenh()"  class="btn btn-primary pull-right start_check">Start</a>
                    <a href="#" onclick="tamdunglenh()"  class="btn btn-danger start_check">Tạm Dừng</a>
                    <a href="#" onclick="changelenh()"  class="btn btn-primary pull-right end_check finish">Finish</a>
                    <a href="#" onclick="tamdunglenh()"  class="btn btn-danger end_check">Tạm Dừng</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="refesh btn btn-default pull-left" data-dismiss="modal">Close</button>
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
@endsection
@section("js")
<script src="{{asset('js/select2/dist/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
    $('#select-cd').select2();
    $('#select-cd').change(function(){
        $('.colors').hide();
        $('#' + $(this).val()).show();
    });
    $(document).ready(function(){
        $(".show-cd").click(function(){
            var max = 0;
            $('.show-cd').each(function() {
                var value = parseInt($(this).data('id'));
                max = (value > max) ? value : max;
            });

            for (var i = 1; i <= max; i++) {
                $(".hidden" + i).removeClass('hidden');
            }
            
            $(".show-more").removeClass('hidden');
            $(".number-cd").addClass('hidden');
        });
    });

    $('.refesh').click(function () {
        $('.end_check').removeClass('hidden');
        $('.start_check').removeClass('hidden');
    })

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
                window.location.reload();
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
                chinh     : $('#chinh').val(),
            },
            url: changelenh,
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
        var tamdunglenh= '{{ route("tamdunglenh") }}';
        $.ajax({
            data: {
                sort   : $('#changesort').val(),
                parent : $('#changeparent').val(),
                dinhmuc: $('#changedinhmuc').val(),
                tre    : $('#changetre').val(),
                status : $('#status').val(),
                id     : $('#changeid').val(),
                tt     : $('#changett').val(),
            },
            url: tamdunglenh,
            type: 'POST',
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
                    window.location.reload();
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
</script>
@endsection