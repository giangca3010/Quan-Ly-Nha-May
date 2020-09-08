@extends("app")
@section("css")

@endsection
@section("content")
<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
    <div class="row"></div>
    <div class="row">
        <div class="col-sm-12">
            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >ID</th>
                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Tên</th>
                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >P</th>
                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Đơn Vị</th>
                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >T1</th>
                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >T2</th>
                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >T3</th>
                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >T4</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="tb_show">
                	<div class="hidden">{{$stt = 1}}</div>
                	@foreach($target as $key => $item)
	                	<tr role="row" class="odd">
	                		<td class="sorting_1">{{$stt}}</td>
	                		<td class="sorting_1">{{$item->name}}</td>
                            <td class="sorting_1">{{$item->count}}</td>
                            <td class="sorting_1">{{$item->donvi}}</td>
                            @if(count($item->target) == 0)
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            @else
                                @foreach($item->target as $t)
                                <td>{{$t->dm_tieuthu}}</td>
                                @endforeach
                            @endif
	                		<td>
	                			@if($item->count == 0)
		                        	<a type="button" class="add" data-toggle="modal" data-target="#add" data-id="{{$item->id_nvl}}" data-p="{{$item->p}}" data-donvi ="{{$item->donvi}}">
		                        		<span class="fa fa-plus"></span>
		                        	</a>
	                        	@else
		                        	<a type="button" class="edit" data-toggle="modal" data-target="#add" data-id="{{$item->id_nvl}}" data-p ="{{$item->p}}" data-t1="{{$item->target[0]->dm_tieuthu}}" data-t2 ="{{$item->target[1]->dm_tieuthu}}" data-t3="{{$item->target[2]->dm_tieuthu}}" data-t4 ="{{$item->target[3]->dm_tieuthu}}" data-donvi ="{{$item->donvi}}" data-bt4 ="{{$item->target[3]->status}}" data-bt3 ="{{$item->target[2]->status}}" data-bt2 ="{{$item->target[1]->status}}" data-bt1 ="{{$item->target[0]->status}}">
		                        		<span class="fa fa-edit"></span>
		                        	</a>
	                        	@endif
	                		</td>
	                    </tr>
	                    <div class="hidden">{{$stt += 1}}</div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="add" data-toggle="modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_data" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"> Định Mức Tiêu Thụ Thực Tế</h4>
            </div>
            <form action="{{ url('adddinhmuc') }}"  method="post">
            <div class="modal-body">
            	<table class="table table-bordered">
            		@csrf
            		<input type="hidden" name="id_nvl" id="id_nvl">
            		<input type="hidden" name="p" id="p">
            		<thead>
            			<td class="text-center">T</td>
            			<td class="text-center">Định Mức</td>
            		</thead>
            		<tbody>
            			<tr>
            				<td class="text-center">1</td>
            				<td class="text-center">
                                <input type="hidden" name="date1" value="{{$t1}}">
                                <input type="number" name="t1" id="target_t1"> <span class="show_donvi"></span> /ngày
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td class="text-center">
                                <input type="hidden" name="date2" value="{{$t2}}">
                                <input type="number" name="t2" id="target_t2"> <span class="show_donvi"></span> /ngày
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td class="text-center">
                                <input type="hidden" name="date3" value="{{$t3}}">
                                <input type="number" name="t3" id="target_t3"> <span class="show_donvi"></span> /ngày
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">4</td>
                            <td class="text-center">
                                <input type="hidden" name="date4" value="{{$t4}}">
                                <input type="number" name="t4" id="target_t4"> <span class="show_donvi"></span> /ngày
                            </td>
                        </tr>
            		</tbody>
            	</table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
	        </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	$('.add').click(function () {
		$('#id_nvl').val($(this).data('id'));
        $('#p').val($(this).data('p'));
		$('.show_donvi').text($(this).data('donvi'));
	});
    $('.edit').click(function () {
        $('#id_nvl').val($(this).data('id'));
        $('#p').val($(this).data('p'));
        $('#target_t1').val($(this).data('t1'));
        $('#target_t2').val($(this).data('t2'));
        $('#target_t3').val($(this).data('t3'));
        $('#target_t4').val($(this).data('t4'));
        $('.show_donvi').text($(this).data('donvi'));
        if ($(this).data('bt1')) {
            $('#target_t1').attr('disabled', 'disabled');
        }
        if ($(this).data('bt2')) {
            $('#target_t2').attr('disabled', 'disabled');
        }
        if ($(this).data('bt3')) {
            $('#target_t3').attr('disabled', 'disabled');
        }
        if ($(this).data('bt4')) {
            $('#target_t4').attr('disabled', 'disabled');
        }
    });

</script>
@endsection
