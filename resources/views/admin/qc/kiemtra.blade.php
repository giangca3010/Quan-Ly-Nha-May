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
	                        <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >ID</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Mã Lỗi</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Hướng Dẫn</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Quy Trình</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Nhân Viên</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Định Mức</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Tài Liệu</th>
	                        <th>Thao Tác</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<div class="hidden">{{$stt = 1}}</div>
             		   	@foreach($dataQC as $item)
	                	<tr role="row" class="odd">
	                		<td class="sorting_1">{{$stt}}</td>
	                		<td>
	                			@foreach($item['code'] as $key => $value)
	                			<span>{{$value}}</span><br/>
	                			@endforeach	
	                		</td>
	                		<td class="sorting_1">{{$item['huong_dan']}}</td>
	                		<td class="sorting_1">{{$item['quy_trinh']}}</td>
	                		<td class="sorting_1">{{$item['nhan_vien']}}</td>
	                		<td class="sorting_1">{{$item['dinh_muc']}}</td>
                			<td>
	                			@foreach($item['link'] as $key => $value)
	                			<div>
		                			<a href="{{$value}}" target="blank">Ảnh {{$key+1}}</a>
	                				<a type="button" class="delete_images" data-id="{{$value}}" data-type="1">
		                        		<span class="fa fa-trash"></span>
		                        	</a><br/>
	                			</div>
	                			@endforeach	
                			</td>
	                        <td class="sorting_1">
	                        	<a type="button" class="edit_data" data-toggle="modal" data-target="#modal-default" data-quytrinh="{{$item['quy_trinh']}}"  data-id="{{$item['id']}}" data-dinhmuc="{{$item['dinh_muc']}}" data-huongdan="{{$item['huong_dan']}}" data-nhanvien="{{$item['nhan_vien']}}" data-code="{{$item['id_ma']}}">
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
	                <h4 class="modal-title">Tạo Phương Pháp Kiểm Tra</h4>
	            </div>
	            <div class="modal-body">
		        	<form id="data-kiemtra" enctype="multipart/form-data">
		                <div class="form-group">
						    <label for="name">Mã Lỗi</label>
						    <input type="hidden" class="form-control" name="id" id="id" >
						    <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;" id="ma_loi" name="id_ma[]">
					            <option></option>
					            @foreach($maloi as $value)
									<option value="{{$value->id}}">{{$value->name}} - {{$value->note}}</option>
								@endforeach
					        </select>
						</div>

						<div class="form-group">
						    <label for="huongdan">Hướng Dẫn</label>
						    <textarea type="text" class="form-control" id="huongdan" name="huongdan" placeholder="Nhập Mô Tả"></textarea>
						</div>

						<div class="form-group">
						    <label for="quytrinh">Quy Trình</label>
						    <textarea type="text" class="form-control" id="quytrinh" name="quytrinh" placeholder="Nhập Code"></textarea>
						</div>

						<div class="form-group">
						    <label for="dinhmuc">Định Mức</label>
						    <textarea type="text" class="form-control" id="dinhmuc" name="dinhmuc" placeholder="Nhập Mức Độ"></textarea>
						</div>

						<div class="form-group">
						    <label for="nhanvien">Nhân Viên</label>
						    <textarea type="text" class="form-control" id="nhanvien" name="nhanvien" placeholder="Nhập Bộ Phận"></textarea>
						</div>

	                    <div class="form-group">
	                        <input type="file" name="file[]" multiple="multiple" style="width: 200px;">
	                        <input class="submit_kiemtra pull-right" type="button" value="Đồng Ý">
	                    </div>

	                </form>

	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	            </div>
	        </div>
	    </div>
	</div>

@endsection

@section('js')
<script src="{{asset('js/select2/dist/js/select2.full.min.js')}}"></script>
<script>
	$('#ma_loi').select2();
	$('.submit_kiemtra').click(function(){
        $.ajax({
            type: 'post',
            url: '{{ route("action.kiemtra") }}',
            data:  new FormData($("#data-kiemtra")[0]),
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
		// $('#name').val($(this).data('name'));
		$('#huongdan').val($(this).data('huongdan'));
		$('#quytrinh').val($(this).data('quytrinh'));
		$('#id').val($(this).data('id'));
		$('#mucdo').val($(this).data('mucdo'));
		$('#nhanvien').val($(this).data('nhanvien'));
		$('#dinhmuc').val($(this).data('dinhmuc'));
	    $('#ma_loi').val($(this).data('code')).trigger('change');
	});
    $('.delete_data').click(function () {
		var add = '{{ route("delete.kiemtra") }}';
	    $.ajax({
	        data: {
	            id : $(this).data('id'),
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
