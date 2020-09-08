@extends("app")
@section("css")
<link rel="stylesheet" href="{{asset('js/select2/dist/css/select2.min.css')}}">
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/bootstrap-datetimepicker.min.css')}}" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section("content")
<div class="col-md-6">
    <!-- <label>Lọc Ngày Tháng</label>
    <input type="text" class="form-control" name="daterange"/> -->
</div>
<div class="col-md-6">
    <a href="/export" class="btn pull-right"><i class="fa fa-download"></i></a>
    <a type="button" class="btn  pull-right" data-toggle="modal" data-target="#modal-excel"><span class="fa fa-upload"></span></a>
</div>

<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
    <div class="row"></div>
    <div class="row">
        <div class="col-sm-12">
            <table id="muahang" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead>
                    <tr role="row" class="showdate">
                        <th class="sorting_asc" tabindex="0" aria-controls="muahang" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >STT</th>
                        <th class="sorting text-center" tabindex="0" aria-controls="muahang" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Nguyên Vật Liệu</th>
                        <th class="sorting text-center" tabindex="0" aria-controls="muahang" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Tồn Kho</th>
                        <th class="sorting text-center" tabindex="0" aria-controls="muahang" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Số Ngày An Toàn</th>
                        <th class="sorting text-center" tabindex="0" aria-controls="muahang" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Ngày Nhập Kho</th>
                        <th class="sorting text-center" tabindex="0" aria-controls="muahang" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Trạng Thái</th>
                    </tr>
                </thead>
                <tbody class="tb_show">
                    <div class="hidden">{{$stt = 1}}</div>
            		@foreach($items as $i)
                	<tr role="row" class="odd">
                        <td class="sorting_1"><a class="showdinhmuc" type="button" data-toggle="modal" data-target="#modal-target" data-id ="{{$i['id']}}">{{$stt}}</a></td>
                        <td class="sorting text-center" tabindex="0" aria-controls="muahang" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >{{$i['name']}}</td>
                        <td class="sorting text-center @if($i['soluong'] == 0 ) bg-danger text-white @endif " tabindex="0" aria-controls="muahang" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >{{$i['soluong']}}</td>
                        <td class="sorting text-center" tabindex="0" aria-controls="muahang" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >{{$i['songay']}}</td>
                        <td class="sorting text-center" tabindex="0" aria-controls="muahang" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >{{$i['ngaynhapkho']}}</td>
                        <td class="sorting text-center {{\App\Common::warning($i['date'])['class']}}" tabindex="0" aria-controls="muahang" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">{{empty($i['date']) ? '' : 'hàng chưa nhập kho '.\App\Common::warning($i['date'])['count'].' ngày'}}</td>
                	</tr>
                    <div class="hidden">{{$stt += 1}}</div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-excel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close remove_data" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Thêm</h4>
            </div>
            <div class="modal-body">
                <form action="{{ url('importkho') }}"  method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-md-12">
                        <span class="control-fileupload">
                            <label for="fileInput">Chọn Tệp :</label>
                            <input type="file" name="fileInput" id="fileInput">
                        </span>
                        <div class="form-group text-center pull-right">
                            <button class="btn btn-primary ">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-target" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close remove_data" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Định Mức</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <td class="text-center">P</td>
                        <td class="text-center">T</td>
                        <td class="text-center">Tiêu Thụ</td>
                        <td class="text-center">Mua</td>
                        <td class="text-center">Tồn Tối Thiểu</td>
                    </thead>
                    <tbody class="show_target">
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$(function() {
    var start = moment().startOf('isoWeek');
    var end = moment().endOf('isoWeek');
    $('input[name="daterange"]').daterangepicker({
        startDate: start,
        endDate: end,
        locale: {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Đồng Ý",
            "cancelLabel": "Hủy",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "Chủ Nhật",
                "Hai",
                "Ba",
                "Tư",
                "Năm",
                "Sáu",
                "Bảy",
            ],
            "monthNames": [
                "Tháng 1",
                "Tháng 2",
                "Tháng 3",
                "Tháng 4",
                "Tháng 5",
                "Tháng 6",
                "Tháng 7",
                "Tháng 8",
                "Tháng 9",
                "Tháng 10",
                "Tháng 11",
                "Tháng 12"
            ],
            "firstDay": 0
        },
        opens: 'left'
      }, function(start, end, label) {
       
      });
    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
        console.log(picker.startDate.format('DD-MM-YYYY') + ' to ' + picker.endDate.format('DD-MM-YYYY'));
        var idver =$(this).val();
        $.get("/showitems?start="+picker.startDate.format('DD-MM-YYYY')+"&end="+picker.endDate.format('DD-MM-YYYY'),function(data){
            $(".tb_show").html(data);
        });
        $.get("/showdates?start="+picker.startDate.format('DD-MM-YYYY')+"&end="+picker.endDate.format('DD-MM-YYYY'),function(data){
            var str =  ['<th class="sorting_asc" tabindex="0" aria-controls="muahang" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Item / Ngày</th>'].concat(data);
            $(".showdate").html(str);
        });
    });

    $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});
$(function () {
    $('#muahang').DataTable({
        'paging'         : true,
        'lengthChange'   : true,
        'searching'      : true,
        'ordering'       : true,
        'info'           : true,
        'autoWidth'      : false,
        'aLengthMenu'    : [
            [25, 50, 100, 200, -1],
            [25, 50, 100, 200, "All"]
        ],
        'iDisplayLength' : -1
    })
})
$('.showdinhmuc').click(function () {
    $.ajax({
        url:"/showtarget",
        type:'post',
        data: {
            id : $(this).data('id'),
        },
        success:function(data){
            var res = '';
            console.log(data);
            $.each (data, function (key, value) {
                res +=
                '<tr><td>'+value.p+'</td>'
                    +'<td>'+value.t+'</td>'
                    +'<td>'+value.dm_tieuthu+'</td>'
                    +'<td>'+value.dm_mua+'</td>'
                    +'<td>'+value.dm_tktt+'</td>'
                    +'</tr>';
                $('.show_target').html(res);
            });        
        }
    });
});
</script>
@endsection
