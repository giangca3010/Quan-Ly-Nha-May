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
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Code</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Tên</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Số Lượng</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Kiện</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Chú Ý</th>
	                        <th>Thao Tác</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<div class="hidden">{{$stt = 1}}</div>
	                	@foreach($map as $key => $item)
		                	<tr role="row" class="odd">
		                		<td class="sorting_1">{{$stt}}</td>
		                		<td class="sorting_1">{{$item->code}}
		                			<!-- <a class=" showdata" data-toggle="modal" data-target="#modal-detail" data-id="{{$item->id}}"></a> -->
		                		</td>
		                		<td class="sorting_1">{{$item->name}}</td>
		                		<td class="sorting_1">{{$item->so_luong}}</td>
		                		<td class="sorting_1">
		                			@if($item->list_kien)
		                			@foreach($item->list_kien as $k)
		                			<span class="bg-info text-white">{{$k->name}}</span>
		                			@endforeach
		                			@endif
		                		</td>
		                		<td class="sorting_1">{{$item->note}}</td>
		                        <td class="sorting_1">
		                        	<a type="button" class="edit_data" data-toggle="modal" data-target="#edit" data-note="{{$item->note}}" data-name="{{$item->name}}" data-so_luong="{{$item->so_luong}}" data-kien="{{$item->kien_id}}" data-id="{{$item->id}}">
		                        		<span class="fa fa-edit"></span>
		                        	</a>

		                        	<a type="button" class="delete_data" data-id="{{$item->id}}">
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
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title">Item</h4>
	            </div>
	            <div class="modal-body">
				    <div class="form-group col-md-8">
				        <label>Name:</label>
			            <input type="text" class="form-control" id="name" placeholder="Nhập tên iten...">
				    </div>
				    <div class="form-group col-md-4">
				        <label>Số Lượng:</label>
			            <input type="text" class="form-control" id="soluong" placeholder="Nhập số lượng...">
				    </div>
			    	<div class="col-md-12">
					    <div class="form-group" >
					        <label>Chọn Kiện</label>
					        <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;" id="kien">
					            <option></option>
					            @foreach($kien as $value)
									<option value="{{$value->id}}">{{$value->name}} - {{$value->note}}</option>
								@endforeach
					        </select>
					    </div>
					</div>
					           
                	<div class="form-group col-md-12">
				        <label>Mô tả:</label>
			            <textarea class="form-control" rows="5" placeholder="Nhập diễn giải..." id='mota'></textarea>
				    </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="additem()"  type="button" class="btn btn-primary">Lưu</a>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="edit">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title">Item</h4>
	            </div>
	            <div class="modal-body">
	            	<input type="hidden" class="form-control" id="edit_id">
				    <div class="form-group col-md-8">
				        <label>Name:</label>
			            <input type="text" class="form-control" id="edit_name" placeholder="Nhập tên item...">
				    </div>
				    <div class="form-group col-md-4">
				        <label>Số Lượng:</label>
			            <input type="text" class="form-control" id="edit_soluong" placeholder="Nhập số lượng...">
				    </div>
			    	<div class="col-md-12">
					    <div class="form-group" >
					        <label>Chọn Kiện</label>
					        <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;" id="edit_kien"  name="edit_kien[]">
					            <option></option>
					            @foreach($kien as $value)
									<option value="{{$value->id}}" >{{$value->name}}</option>
								@endforeach
					        </select>
					    </div>
					</div>
					           
                	<div class="form-group col-md-12">
				        <label>Mô tả:</label>
			            <textarea class="form-control" rows="5" placeholder="Nhập diễn giải..." id='edit_mota'></textarea>
				    </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="edititem()"  type="button" class="btn btn-primary">Lưu</a>
	            </div>
	        </div>
	    </div>
	</div>

@endsection

@section('js')
<script src="{{asset('js/select2/dist/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
	$('#kien').select2();
	$('#edit_kien').select2();
	$('.showdata').click(function(){
        $('.show'+$(this).data('id')).removeClass('hidden');
        $('#clear_id').val($(this).data('id'));
    });
    $('.remove_data').click(function(){
    	var id = $('#clear_id').val();
    	$('.show'+id).addClass('hidden');
    });
    $('.edit_data').click(function () {
    	$('#edit_name').val($(this).data('name'));
    	$('#edit_soluong').val($(this).data('so_luong'));
    	$('#edit_mota').val($(this).data('note'));
    	$('#edit_id').val($(this).data('id'));
    	var kien = $(this).data('kien');
		var data = [];
		$.each(kien, function(key, value) {
	        data.push(value);
		});
		$("#edit_kien").val(data.map(function(x) {
		    return x;
		})); 
		$('select').select2();
    });

    $('.delete_data').click(function () {
    	var destroy= '{{ route("destroy.item") }}';
	    $.ajax({
	        data: {
	            id      : $(this).data('id'),
	        },
	        url: destroy,
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
	function additem() {
		var additem= '{{ route("additem") }}';
		var search = window.location.search;
		var number = search.match(/\d+/);
	    $.ajax({
	        data: {
				menu_id   : number.toString(),
	            soluong   : $('#soluong').val(),
	            name      : $('#name').val(),
	            kien      : $('#kien').val(),
	            mota      : $('#mota').val(),
	        },
	        url: additem,
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
	function edititem() {
		var edititem= '{{ route("edititem") }}';
	    $.ajax({
	        data: {
	            soluong   : $('#edit_soluong').val(),
	            name      : $('#edit_name').val(),
	            kien      : $('#edit_kien').val(),
	            mota      : $('#edit_mota').val(),
	            id        : $('#edit_id').val(),
	        },
	        url: edititem,
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
</script>
@endsection
