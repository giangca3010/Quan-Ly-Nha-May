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
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Tên</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Code</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascendingbindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Mức Độ</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Ảnh</th>
	                        <th class="sorting" tabin" >Mô Tả</th>
	                        <th class="sorting" tadex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Bộ Phận</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Nguyên Nhân</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Phương Pháp</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Sửa Chữa</th>
	                        <th>Thao Tác</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<div class="hidden">{{$stt = 1}}</div>
             		   	@foreach($dataQC as $item)
	                	<tr role="row" class="odd">
	                		<td class="sorting_1">{{$stt}}</td>
	                		<td class="sorting_1">{{$item['name']}}</td>
	                		<td class="sorting_1">{{$item['code']}}</td>
	                		<td class="sorting_1">{{$item['note']}}</td>
	                		<td class="sorting_1">{{$item['mucdo']}}</td>
	                		<td>
	                			@foreach($item['link'] as $key => $value)
	                			<div>
		                			<a href="{{$value}}" target="blank">Ảnh {{$key+1}}</a>
	                				<a type="button" class="delete_images" data-id="{{$value}}" data-type="0">
		                        		<span class="fa fa-trash"></span>
		                        	</a><br/>
	                			</div>
	                			@endforeach	
                			</td>
	                		<td class="sorting_1">{{$item['bophan']}}</td>
	                		<td class="sorting_1">
	                			@foreach($item['nguyennhan'] as $key => $value)
	                			<span>{{$value['name']}}</span><br/>
	                			@endforeach	
	                		</td>
	                		<td>
	                			@foreach($item['kiemtra'] as $key => $value)
	                			<span>{{$value['huong_dan']}}</span><br/>
	                			@endforeach	
	                		</td>
	                		<td>
	                			@foreach($item['suachua'] as $key => $value)
	                			<span>{{$value['huong_dan']}}</span><br/>
	                			@endforeach	
	                		</td>
	                        <td class="sorting_1">
	                        	<a type="button" class="edit_data" data-toggle="modal" data-target="#modal-default" data-note="{{$item['note']}}" data-name="{{$item['name']}}" data-id="{{$item['id']}}" data-mucdo="{{$item['mucdo']}}" data-bophan="{{$item['bophan']}}"  data-code="{{$item['code']}}" data-kiemtra="{{$item['kiemtra']}}" data-nguyennhan="{{$item['nguyennhan']}}" data-suachua="{{$item['suachua']}}">
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
	                <h4 class="modal-title">Tạo Mã Lỗi</h4>
	            </div>
	            <div class="modal-body">
		        	<form id="data-maloi" enctype="multipart/form-data">
		                <div class="form-group">
						    <label for="name">Tên</label>
						    <input type="hidden" class="form-control" name="id" id="id" >
						    <input type="hidden" class="form-control" id="kiemtra_old" name="kiemtra_old" >
						    <input type="hidden" class="form-control" id="nguyennhan_old" name="nguyennhan_old" >
						    <input type="hidden" class="form-control" id="suachua_old" name="suachua_old" >
						    <input type="text" class="form-control" id="name" name="name" placeholder="Nhập Tên">
						</div>

						<div class="form-group">
						    <label for="note">Mô Tả</label>
						    <textarea type="text" class="form-control" id="note" name="note" placeholder="Nhập Mô Tả"></textarea>
						</div>

						<div class="form-group">
						    <label for="code">Code</label>
						    <textarea type="text" class="form-control" id="code" name="code" placeholder="Nhập Code"></textarea>
						</div>

						<div class="form-group">
						    <label for="mucdo">Mức Độ</label>
						    <textarea type="text" class="form-control" id="mucdo" name="mucdo" placeholder="Nhập Mức Độ"></textarea>
						</div>

						<div class="form-group">
						    <label for="bophan">Bộ Phận</label>
						    <textarea type="text" class="form-control" id="bophan" name="bophan" placeholder="Nhập Bộ Phận"></textarea>
						</div>

						<div class="form-group">
						    <label for="name">Phương Pháp Kiểm Tra</label>
						    <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;" id="kiem_tra" name="kiem_tra[]">
					            <option></option>
					            <!-- @foreach($kiemtra as $value)
									<option value="{{$value->id}}">{{$value->huong_dan}}</option>
								@endforeach -->
					        </select>
						</div>

						<div class="form-group">
						    <label for="name">Nguyên Nhân</label>
						    <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;" id="nguyen_nhan" name="nguyen_nhan[]">
					            <option></option>
					            @foreach($nguyennhan as $value)
									<option value="{{$value->id}}">{{$value->name}}</option>
								@endforeach
					        </select>
						</div>

						<div class="form-group">
						    <label for="name">Sửa Chữa</label>
						    <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;" id="sua_chua" name="sua_chua[]">
					            <option></option>
					            @foreach($suachua as $value)
									<option value="{{$value->id}}">{{$value->huong_dan}}</option>
								@endforeach
					        </select>
						</div>

	                    <div class="form-group">
	                        <input type="file" name="file[]" multiple="multiple" style="width: 200px;">
	                        <input class="submit_maloi pull-right" type="button" value="Đồng Ý">
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
	$('#kiem_tra').select2();
	$('#nguyen_nhan').select2();
	$('#sua_chua').select2();
	$('.submit_maloi').click(function(){
        $.ajax({
            type: 'post',
            url: '{{ route("action.maloi") }}',
            data:  new FormData($("#data-maloi")[0]),
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
		$('#mucdo').val($(this).data('mucdo'));
		$('#bophan').val($(this).data('bophan'));
		$('#code').val($(this).data('code'));
		var array = [];
		$.each($(this).data('kiemtra'), function( key, value ) {
			array.push(value.id);
		});
		$('#kiemtra_old').val(array);
		$('#kiem_tra').val(array).trigger('change');

		var nguyennhan = [];
		$.each($(this).data('nguyennhan'), function( key, value ) {
			nguyennhan.push(value.id);
		});
		$('#nguyennhan_old').val(nguyennhan);
		$('#nguyen_nhan').val(nguyennhan).trigger('change');

		var suachua = [];
		$.each($(this).data('suachua'), function( key, value ) {
			suachua.push(value.id);
		});
		console.log(suachua);
		$('#suachua_old').val(suachua);
		$('#sua_chua').val(suachua).trigger('change');
	});
    $('.delete_data').click(function () {
		var add = '{{ route("delete.maloi") }}';
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
