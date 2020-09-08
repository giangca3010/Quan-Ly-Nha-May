@extends("app")
@section("css")
<link rel="stylesheet" href="{{asset('js/select2/dist/css/select2.min.css')}}">	
@endsection
@section("content")
	<a type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default"><span class="glyphicon glyphicon-plus"></span> Thêm </a>
    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
	    <div class="row"></div>
	    <div class="row">
	        <div class="col-sm-12">
	            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
	                <thead>
	                    <tr role="row">
	                        <th class="sorting_asc text-center" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >ID</th>
	                        <th class="sorting text-center" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Mã Lỗi</th>
	                        <th class="sorting text-center" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Tên</th>
	                        <th class="sorting text-center" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Mô Tả</th>
	                        <th>Thao Tác</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<div class="hidden">{{$stt = 1}}</div>
             		   	@foreach($dataQC as $key => $item)
	                	<tr role="row" class="odd">
	                		<td class="sorting_1">{{$stt}}</td>
	                		<td class="sorting_1">
	                			@if($item['code'])
	                			@foreach($item['code'] as $key => $value)
	                			<span>{{$value}}</span><br/>
	                			@endforeach	
	                			@endif
	                		</td>
	                		<td class="sorting_1">{{$item['name']}}</td>
	                		<td class="sorting_1">{{$item['note']}}</td>
	                        <td class="sorting_1">
	                        	<a type="button" class="edit_data" data-toggle="modal" data-target="#modal-default" data-note="{{$item['note']}}" data-name="{{$item['name']}}" data-id="{{$item['id']}}" data-code="{{$item['id_ma']}}">
	                        		<span class="fa fa-edit"></span>
	                        	</a>
	                        	<a type="button" class="delete_data" data-id="{{$item['id']}}">
	                        		<span class="fa fa-trash"></span>
	                        	</a>
	                        </td>
	                    </tr>
	                    <div class="hidden">{{$stt += 1}}</div>
	                    @endforeach	
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="modal-default">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Tạo Nguyên Nhân</h4>
	            </div>
	            <div class="modal-body">
	            	<form id="data-nguyennhan" enctype="multipart/form-data">
		            	<div class="form-group">
						    <label for="name">Mã Lỗi</label>
						    <input type="hidden" class="form-control" name="id" id="id" >
						    <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;" id="ma_loi" name="id_ma[]">
					            <option></option>
					            @foreach($maloi as $value)
									<option value="{{$value->id}}">{{$value->name}}</option>
								@endforeach
					        </select>
						</div>
		                <div class="form-group">
						    <label for="nameLenh">Tên</label>
						    <input type="hidden" class="form-control" id="id" >
						    <input type="name" class="form-control" id="name" name="name" placeholder="Nhập Tên Nguyên Nhân">
						</div>
						<div class="form-group">
						    <label for="nameLenh">Mô Tả</label>
						    <textarea type="note" class="form-control" id="note" name="note" placeholder="Nhập Mô Tả Nguyên Nhân"></textarea>
						</div>
						<div>
	                        <input class="submit_nguyennhan pull-right" type="button" value="Đồng Ý">
	                    </div>

	                </form>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <!-- <a href="#" onclick="add()"  type="button" class="btn btn-primary">Lưu</a> -->
	            </div>
	        </div>
	    </div>
	</div>
@endsection

@section('js')
<script src="{{asset('js/select2/dist/js/select2.full.min.js')}}"></script>
<script >
$('#ma_loi').select2();
$('.submit_nguyennhan').click(function(){
    $.ajax({
        type: 'post',
        url: '{{ route("action.nguyennhan") }}',
        data:  new FormData($("#data-nguyennhan")[0]),
        dataType:'json', 
        async:false, 
        processData: false, 
        contentType: false, 
        success: function(data){
            if(data.status === true) {
				$.bootstrapGrowl(data.message, { type: 'success' });
	            setTimeout(function(){
		           window.location.reload(); 
				}, 200); 
        	}
        }
    })
})	

$('.edit_data').click(function (){
	$('#name').val($(this).data('name'));
	$('#note').val($(this).data('note'));
	$('#id').val($(this).data('id'));
	$('#ma_loi').val($(this).data('code')).trigger('change');
});

$('.delete_data').click(function () {
	var add = '{{ route("delete.nguyennhan") }}';
    $.ajax({
        data: {
            id   : $(this).data('id'),
        },
        url: add,
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
@endsection