@extends("app")
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
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Mã Sản Phẩm</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Số Lượng</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Ghi Chú</th>
	                        <th>Thao Tác</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<div class="hidden">{{$stt = 1}}</div>
	                	@foreach($loaichiphi as $key => $item)
		                	<tr role="row" class="odd">
		                		<td class="sorting_1">{{$stt}}</td>
		                		<td class="sorting_1">{{$item->name_lcp}}</td>
		                		<td class="sorting_1">{{$item->ma_sp}}</td>
		                		<td class="sorting_1">{{$item->sl_nk}}</td>
		                		<td class="sorting_1">{{$item->note}}</td>
		                        <td class="sorting_1">
		                        	<a type="button" class="edit_data" data-toggle="modal" data-target="#edit" data-name="{{$item->name_lcp}}" data-id="{{$item->id}}">
		                        		<span class="fa fa-edit"></span>
		                        	</a>

		                        	<a href="{{asset('destroyloaichiphi').'/'.$item->id}}"><span class="fa fa-trash"></span></a>
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
	                <h4 class="modal-title">Loại Chi Phí</h4>
	            </div>
	            <div class="modal-body">
				    <div class="form-group col-md-12">
				        <label>Name:</label>
			            <input type="text" class="form-control" id="name" placeholder="Nhập tên loại chi phí...">
				    </div>
				    <div class="form-group col-md-12">
				        <label>Mã Sản Phẩm:</label>
			            <input type="text" class="form-control" id="ma_sp" placeholder="Nhập tên loại chi phí...">
				    </div>
				    <div class="form-group col-md-12">
				        <label>Số Lượng:</label>
			            <input type="text" class="form-control" id="sl_nk" placeholder="Nhập tên loại chi phí...">
				    </div>
				    <div class="form-group col-md-12">
				        <label>Ghi Chú:</label>
			            <input type="text" class="form-control" id="note" placeholder="Nhập tên loại chi phí...">
				    </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="addloaichiphi()"  type="button" class="btn btn-primary">Lưu</a>
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
	                <h4 class="modal-title">Sửa Loại Chi Phí</h4>
	            </div>
	            <div class="modal-body">
	            	<input type="hidden" class="form-control" id="edit_id">
				    <div class="form-group col-md-12">
				        <label>Name:</label>
			            <input type="text" class="form-control" id="edit_name" placeholder="Nhập tên loại chi phí...">
				    </div>
				    <div class="form-group col-md-12">
				        <label>Mã Sản Phẩm:</label>
			            <input type="text" class="form-control" id="edit_sp" placeholder="Nhập tên loại chi phí...">
				    </div>
				    <div class="form-group col-md-12">
				        <label>Số Lượng:</label>
			            <input type="text" class="form-control" id="edit_sl" placeholder="Nhập tên loại chi phí...">
				    </div>
				    <div class="form-group col-md-12">
				        <label>Ghi Chú:</label>
			            <input type="text" class="form-control" id="edit_note" placeholder="Nhập tên loại chi phí...">
				    </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="editloaichiphi()" type="button" class="btn btn-primary">Lưu</a>
	            </div>
	        </div>
	    </div>
	</div>

@endsection

@section('js')
<script type="text/javascript">
    $('.edit_data').click(function () {
    	$('#edit_name').val($(this).data('name'));
    	$('#edit_id').val($(this).data('id'));
    });

	function addloaichiphi() {
		var addloaichiphi= '{{ route("addloaichiphi") }}';
	    $.ajax({
	        data: {
	            name_lcp : $('#name').val(),
	            ma_sp    : $('#ma_sp').val(),
	            sl_nk    : $('#sl_nk').val(),
	            note     : $('#note').val(),
	        },
	        url: addloaichiphi,
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

	function editloaichiphi() {
		var editloaichiphi= '{{ route("editloaichiphi") }}';
	    $.ajax({
	        data: {
	            name_lcp : $('#edit_name').val(),
	            ma_sp    : $('#edit_sp').val(),
	            sl_nk    : $('#edit_sl').val(),
	            note     : $('#edit_note').val(),
	            id : $('#edit_id').val(),
	        },
	        url: editloaichiphi,
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

</script>
@endsection
