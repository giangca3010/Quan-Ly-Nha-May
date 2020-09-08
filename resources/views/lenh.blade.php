<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{asset('js/jquery-ui.min_1.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div>
        <button type="button" class="btn" id="myBtn"><span class="glyphicon glyphicon-plus"></span> Thêm Lệnh</button>
        <table class="table table-bordered">
            <tr>
                <th rowspan="2">Lệnh</th>
                @for ($i = 1; $i < 5; $i++)
                    <th colspan="3">Công Đoạn {{$i}}</th>
                @endfor
                @for ($i = 5; $i < 11; $i++)
                    <th colspan="3" class="hidden hidden{{$i-4}}">Công Đoạn {{$i}}</th>
                @endfor
            </tr>
            <tr>
                @for ($i = 1; $i < 5; $i++)
                    <td>Kế Hoạch</td>
                    <td>Trạng Thái</td>
                    <td>QC</td>
                @endfor
                @for ($i = 5; $i < 11; $i++)
                    <td class="hidden hidden{{$i-4}}">Kế Hoạch</td>
                    <td class="hidden hidden{{$i-4}}">Trạng Thái</td>
                    <td class="hidden hidden{{$i-4}}">QC</td>
                @endfor
            </tr>
            <tbody class="row_position">
            	@foreach($sort as $key => $s)
                <tr id="{{$s[0]['id']}}">
                    <td><a href="/ke-hoach?menu=4&parent={{$s[0]['id_menu']}}">{{$s[0]['title']}}</a></td>
                    @foreach($s as $k => $lenh)
                    @if($k < 4)
                    <td>
                        {{$lenh->start_time}} - {{$lenh->end_time}}
                    </td>
                    <td>
                        <a href="#">
                            <span class="glyphicon glyphicon-play"></span>
                        </a>
                        <a>
                            <span class="glyphicon glyphicon-pause"></span>
                        </a>
                        <a href="#">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                        <a href="#">
                            <span class="glyphicon glyphicon-ok"></span>
                        </a>
                    </td>
                    <td>
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
                    @if(!empty($s[4]))
                    <td class="number-cd"><a class="show-cd" data-id="{{count($s)- 4}}">{{count($s)- 4}}</a></td>
                    @endif
                    @foreach($s as $k => $lenh)
                    @if($k > 3)
                    <td class="hidden show-more">
                        {{$lenh->start_time}} - {{$lenh->end_time}}
                    </td>
                    <td class="hidden show-more">
                        <a href="#">
                            <span class="glyphicon glyphicon-play"></span>
                        </a>
                        <a>
                            <span class="glyphicon glyphicon-pause"></span>
                        </a>
                        <a href="#">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                        <a href="#">
                            <span class="glyphicon glyphicon-ok"></span>
                        </a>
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
                </tr>
         		@endforeach
            </tbody>
        </table>
    </div> 
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thêm Lệnh</h4>
                </div>
                <div class="modal-body">
                    <p>Some text in the modal.</p>

                    <p>Nếu chưa có lệnh hãy tạo lệnh <a href="/addlenh">Tại Đây</a> </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal();
    });
});
</script>
<script>
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
</script>
<script type="text/javascript">
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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
            data:{position:data},
            success:function(){
                alert('Đổi thứ tự thành công');
            }
        })
    }
</script>
</html>