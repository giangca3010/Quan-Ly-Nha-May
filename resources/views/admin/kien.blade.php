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
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Chú Ý</th>
	                        <th>Thao Tác</th>
	                    </tr>
	                </thead>
	                <tbody>
                		<div class="hidden">{{$stt = 1}}</div>
	                	@foreach($kien as $key => $k)
	                		@if($k->parent == 0)
		                	<tr role="row" class="odd">
		                		<td class="sorting_1">{{$stt}}</td>
		                		<td class="sorting_1">
		                			<a class=" showdata" data-toggle="modal" data-target="#modal-detail" data-id="{{$k->id}}">{{$k->name}}</a>
		                		</td>
		                		<td class="sorting_1">{{$k->note}}</td>
		                        <td class="sorting_1">
		                        	<a type="button" class="delete_data" data-id="{{$k->id}}">
		                        		<span class="fa fa-trash"></span>
		                        	</a>
		                        </td>
		                    </tr>
		                    <div class="hidden">{{$stt += 1}}</div>
		                    @endif
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
	                <h4 class="modal-title">Kiện</h4>
	            </div>
	            <div class="modal-body">
				    <div class="form-group col-md-12">
				        <label>Name:</label>
			            <input type="text" class="form-control" id="name" placeholder="Nhập tên kiện...">
				    </div>
				    <div class="form-group col-md-12">
				    	<label>Boom</label>
					    <select class="form-control select2" style="width: 100%" id="select-boom">
							@foreach($item as $i)
							<option value="{{$i}}">{{$i}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-12">
                        <label>Version</label>
                        <select class="form-control" id="select-version">
                            @foreach($version as $v)
							<option value="{{$v->version}}"> Version {{$v->version}}</option>
							@endforeach
                         </select>
                    </div>
                	<div class="form-group col-md-12">
				        <label>Mô tả:</label>
			            <textarea class="form-control" rows="5" placeholder="Nhập diễn giải..." id='mota'></textarea>
				    </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="addkien()"  type="button" class="btn btn-primary">Lưu</a>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close remove_data" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
                	@foreach($kien as $key => $k)
                		@if($k->parent == 0)
		                <h4 class="modal-title hidden show{{$k->id}}">Thông Tin Kiện 
                			{{$k->name}}
		                </h4>
		                @endif
                    @endforeach 
	            </div>
	            <div class="modal-body">
	            	<input type="hidden" id="clear_id">
	            	<table class="table">
					    <thead>
							<tr>
								<th>Lệnh</th>
								<th>Độ Trễ</th>
								<th>Định Mức</th>
							</tr>
					    </thead>
					    <tbody >
                    		@foreach($kien as $son)
	                    	<tr class="hidden show{{$son->parent}}">
                    			<td>{{$son->name}}</td>
                    			<td>{{$son->tre}}</td>
                    			<td>{{$son->dinhmuc}}</td>
	                    	</tr>
                    		@endforeach	
		                </tbody>
	                </table>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left remove_data" data-dismiss="modal">Close</button>
	            </div>
	        </div>
	    </div>
	</div>
@endsection

@section('js')
<script src="{{asset('js/select2/dist/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
	$('#select-boom').select2();
	$('.showdata').click(function(){
        $('.show'+$(this).data('id')).removeClass('hidden');
        $('#clear_id').val($(this).data('id'));
    });
    $('.remove_data').click(function(){
    	var id = $('#clear_id').val();
    	$('.show'+id).addClass('hidden');
    });
    $('#select-boom').change(function(){
        var idver =$(this).val();
        $.get("/version/"+idver,function(data){
            $("#select-version").html(data);
        });
    });

	function addkien() {
		var addkien= '{{ route("addkien") }}';
		var search = window.location.search;
		var number = search.match(/\d+/);
	    $.ajax({
	        data: {
	            menu_id   : number.toString(),
	            boom      : $('#select-boom').val(),
	            name      : $('#name').val(),
	            ver       : $('#select-version').val(),
	            mota      : $('#mota').val(),
	        },
	        url: addkien,
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

	$('.delete_data').click(function () {
    	var destroy= '{{ route("destroy.kien") }}';
	    $.ajax({
	        data: {
	            id  : $(this).data('id'),
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
</script>
@endsection
