@extends("app")
@section("content")
    <a type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default"><span class="glyphicon glyphicon-plus"></span> Thêm Lệnh</a>
	<a type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modal-excel"><span class="fa fa-file-excel-o"></span></a>
	@if(count($errors) > 0)
	<div class="alert alert-danger">
		<ul>
			@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif

	@if($message = Session::get('success'))
	<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
		<strong>{{ $message }}</strong>
	</div>
	@endif
    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
	    <div class="row"></div>
	    <div class="row">
	        <div class="col-sm-12 table-responsive ">
	            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
	                <thead>
	                    <tr role="row">
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Mã Lệnh</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Item</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >SL</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Kiện</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Mô Tả</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Bắt Đầu</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Nhập Kho</th>
	                        <th>Thao Tác</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	@foreach($groupBy as $key => $m)
                        	@foreach($m as $k => $parent)
		                	<tr role="row" class="odd">
		                		<td class="sorting_1 {{$k ==  0 ? '' : 'hide' }}" rowspan="{{count($m)}}">{{$parent->lenh}}<br/><p>{{$parent->date}}</p></td>
		                        <td class="sorting_1 {{$k ==  0 ? '' : 'hide' }}" rowspan="{{count($m)}}">{{$parent->item}}</td>
		                        <td class="sorting_1 {{$k ==  0 ? '' : 'hide' }}" rowspan="{{count($m)}}">{{$parent->so_luong}}</td>
		                        <td class="sorting_1">
		                        	<p><a class=" showdata" data-toggle="modal" data-target="#modal-detail" data-id="{{$parent->id}}">{{$parent->name}}</a></p>
		                        </td>
		                        <td class="sorting_1">{{$parent->mota}}</td>
		                        <td class="sorting_1">
		                        	<p>{{$parent->date_time}}</p>
		                        </td>
		                        <td class="sorting_1">
		                        	<p>{{$parent->date_nhapkho}} {{$parent->start_time}}</p>
		                        </td>
		                        <td class="sorting_1 {{$k ==  0 ? '' : 'hide' }}" rowspan="{{count($m)}}">
		                        	@if($parent->duyet == 0 and $parent->name != '')
		                        	<a type="button" class="btn btn-default showdata" data-toggle="modal" data-target="#modal-duyet" data-id="{{$parent->id}}" data-time="{{$parent->start_time}}" data-date="{{$parent->date}}" data-lenh="{{$parent->lenh}}" data-key="{{$key}}" data-soluong="{{$parent->so_luong}}" data-item="{{$parent->item}}">
		                        		<span class="fa fa-check"></span>Duyệt
		                        	</a>
		                        	@endif
		                        	@if($parent->name == '')
		                        	<a type="button" class="btn btn-default" onclick="additem(this)" data-soluong="{{$parent->so_luong}}" data-name="{{$parent->item}}">
		                        		Thêm Item và Kiện
		                        	</a>
		                        	@endif
		                        	@if($parent->duyet != 0)
		                        	<p><span class="bg-success">Đã Duyệt</span></p>
		                        	@endif
		                        </td>
		                    </tr>
                        	@endforeach
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
	                <h4 class="modal-title">Thêm Lệnh</h4>
	            </div>
	            <div class="modal-body">
					<div class="form-group col-md-4">
				        <label>Ngày Nhập Kho:</label>
				        <div class="input-group date ">
				            <div class="input-group-addon">
				                <i class="fa fa-calendar"></i>
				            </div>
				            <input type="text" class="form-control" id="datepicker_nhapkho">
				        </div>
					</div>
					<div class="form-group col-md-4">
						<label>Giờ Nhập Kho</label>
			            <input type="text" class="form-control" id="time_nhapkho" name="Giờ Bắt Đầu" placeholder="Định Dạng 00:00" value="00:00">
			        </div>
			        <div class="form-group col-md-4">
						<label>Số Lượng </label>
			            <input type="text" class="form-control" id="so_luong" name="Giờ Bắt Đầu" placeholder="Nhập số lượng..." >
			        </div>
				    <div class="form-group col-md-6">
				        <label>Lệnh Sản Xuất:</label>
			            <input type="text" class="form-control" id="lenh" placeholder="PR190000...">
				    </div>
				    <div class="form-group col-md-6">
				        <label>Item:</label>
			            <input type="text" class="form-control" id="item">
				    </div>
                	<div class="form-group col-md-12">
				        <label>Mô tả:</label>
			            <textarea class="form-control" rows="5" placeholder="Nhập diễn giải..." id='mota'></textarea>
				    </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="addBoom()"  type="button" class="btn btn-primary">Lưu</a>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close remove_data" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Thông Tin Lệnh</h4>
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
					    <tbody>
							@foreach($groupBy as $key => $m)
		                    	@foreach($m as $parent)
		                    		@foreach($parent->parentSons as $son)
			                    	<tr class="hidden show{{$parent->id}}">
		                    			<td>{{$son->name}}</td>
		                    			<td>{{$son->tre}}</td>
		                    			<td>{{$son->dinhmuc}}</td>
			                    	</tr>
		                    		@endforeach	
		                    	@endforeach
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

	<div class="modal fade" id="modal-excel" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close remove_data" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Thêm</h4>
	            </div>
	            <div class="modal-body">
	            	<form action="{{ url('import') }}"  method="post" enctype="multipart/form-data">
	            		@csrf
						<!-- <div class="form-group col-md-6">
					        <label>Ngày Nhập Kho:</label>
					        <div class="input-group date ">
					            <div class="input-group-addon">
					                <i class="fa fa-calendar"></i>
					            </div>
					            <input type="text" class="form-control" name="datepicker_excel" id="datepicker_excel">
					        </div>
						</div>
						<div class="form-group col-md-6">
							<label>Giờ Nhập Kho</label>
							<div class="input-group date ">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					            <input type="text" class="form-control" id="time_excel" name="time_excel" placeholder="Định Dạng 00:00" value="00:00">
					        </div>
				        </div> -->
				        <div class="form-group col-md-12">
							<span class="control-fileupload">
								<label for="fileInput">Chọn Tệp :</label>
								<input type="file" name="fileInput" id="fileInput">
							</span>
						</div>
	                	<div class="form-group col-md-12">
					        <label>Mô tả:</label>
				            <textarea class="form-control" rows="5" name="mota_excel" placeholder="Nhập diễn giải..." id='mota_excel'></textarea>
					    </div>
					    <div class="form-group text-center">
			                <button class="btn btn-primary ">Thêm</button>
		                </div>
		            </form>
	            </div>
	            
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="modal-duyet" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close remove_data" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Thêm Lệnh</h4>
	            </div>
	            <div class="modal-body">
	            	<input type="hidden" id="get_id">
	            	<input type="hidden" id="get_date">
	            	<input type="hidden" id="get_lenh">
	            	<input type="hidden" id="get_item">
	            	<input type="hidden" id="get_soluong">
	            	<input type="hidden" id="key">
	            	<p>Bạn có muốn lập kế hoạch với thời gian bắt đầu của công đoạn chính không?</p>
	            	<div class="radio">
						<label><input type="radio" name="optradio" value="1" id="checkbox_status">Có</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="optradio" checked value="0" id="checkbox_status">Không</label>
					</div>
					<div class="form-group col-md-6">
				        <label>Ngày Bắt Đầu:</label>
				        <div class="input-group date ">
				            <div class="input-group-addon">
				                <i class="fa fa-calendar"></i>
				            </div>
				            <input type="text" class="form-control" id="datepicker_start">
				        </div>
					</div>
					<div class="form-group col-md-6">
				        <label>Ngày Nhập Kho:</label>
				        <div class="input-group">
				            <input type="text" class="form-control" id="time_start" name="Giờ Bắt Đầu" placeholder="Định Dạng 00:00" value="00:00">
				            <div class="input-group-addon">
				                <i class="fa fa-clock-o"></i>
				            </div>
				        </div>
					</div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left remove_data" data-dismiss="modal">Close</button>
	                <a href="#" onclick="duyet()" type="button" class="btn btn-primary">Duyệt</a>
	            </div>
	        </div>
	    </div>
	</div>
@endsection

@section('js')
<script src="{{asset('js/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('js/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('js/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('js/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script src="{{asset('js/moment/min/moment.min.js')}}"></script>
<script src="{{asset('js/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('js/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('js/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script type="text/javascript">
	$('#datepicker_tao').datepicker({
		autoclose: true,
		format: 'dd-mm-yyyy'
    });
    $('#datepicker_nhapkho').datepicker({
		autoclose: true,
		format: 'dd-mm-yyyy'
    });
    $('#datepicker_start').datepicker({
		autoclose: true,
		format: 'dd-mm-yyyy'
    });
    $('#datepicker_excel').datepicker({
		autoclose: true,
		format: 'dd-mm-yyyy'
    });
	$('.timepicker').timepicker({ 
		showInputs: true, 
		showMeridian: false,
		'timeFormat': 'H:i'
	}).val('00:00');
	$('.showdata').click(function(){
        $('.show'+$(this).data('id')).removeClass('hidden');
        $('#clear_id').val($(this).data('id'));
        $('#time_duyet').text($(this).data('time'));
        $('#get_id').val($(this).data('id'));
        $('#get_date').val($(this).data('date'));
        $('#get_lenh').val($(this).data('lenh'));
        $('#get_soluong').val($(this).data('soluong'));
        $('#get_item').val($(this).data('item'));
        $('#key').val($(this).data('key'));
    });
    $('.remove_data').click(function(){
    	var id = $('#clear_id').val();
    	$('.show'+id).addClass('hidden');
    });
	function addLenh() {
		var addLenh= '{{ route("addLenh") }}';
	    $.ajax({
	        data: {
	            name: $('#nameLenh').val(),
	        },
	        url: addLenh,
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
	function addExcel() {
		var addExcel= '{{ route("import") }}';
	    $.ajax({
	        data: {
	            time_nhapkho: $('#time_excel').val(),
	            date_nhapkho  : $('#datepicker_excel').val(),
	            fileInput      : $('#fileInput').val(),
	            mota      : $('#mota_excel').val(),
	        },
	        url: addExcel,
	        type: 'POST',
	        success: function(data) {
	        	if(data.status === true) {
					$.bootstrapGrowl(data.message, { type: 'success' });
		            setTimeout(function(){
			           window.location.reload(); 
					}, 200); 
	        	}
	        	if(data.status === false) {
					$.bootstrapGrowl(data.message, { type: 'warning' });
		            setTimeout(function(){
			           window.location.reload(); 
					}, 200); 
	        	}
	        },
	    });
	}
	function addBoom() {
		var addBoom= '{{ route("addboom") }}';
	    $.ajax({
	        data: {
	            so_luong      : $('#so_luong').val(),
	            time_nhapkho: $('#time_nhapkho').val(),
	            date_nhapkho  : $('#datepicker_nhapkho').val(),
	            item      : $('#item').val(),
	            lenh      : $('#lenh').val(),
	            mota      : $('#mota').val(),
	        },
	        url: addBoom,
	        type: 'POST',
	        success: function(data) {
	        	if(data.status === true) {
					$.bootstrapGrowl(data.message, { type: 'success' });
		            setTimeout(function(){
			           window.location.reload(); 
					}, 200); 
	        	}
	        	if(data.status === false) {
					$.bootstrapGrowl(data.message, { type: 'warning' });
		            setTimeout(function(){
			           window.location.reload(); 
					}, 200); 
	        	}
	        },
	    });
	}
	function duyet() {
		var duyet= '{{ route("duyet") }}';
	    $.ajax({
	        data: {
	            id: $('#get_id').val(),
	            status: $('#checkbox_status:checked').val(),
	            date: $('#get_date').val(),
	            time: $('#time_start').val(),
	            lenh: $('#get_lenh').val(),
	            item: $('#get_item').val(),
	            date_start: $('#datepicker_start').val(),
	            soluong: $('#get_soluong').val(),
	            key: $('#key').val(),
	        },
	        url: duyet,
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
	function additem(elem) {
		var additem= '{{ route("additem") }}';
	    $.ajax({
	        data: {
	            soluong   : $(elem).data("soluong"),
	            name      : $(elem).data("name"),
	            kien      : null,
	            mota      : 'Mới thêm từ dự kiến',
	            menu_id   : 1,
	        },
	        url: additem,
	        type: 'POST',
	        success: function(data) {
	        	if(data.status === true) {
					$.bootstrapGrowl(data.message, { type: 'success' });
		            setTimeout(function(){
			           window.location.href = 'item?menu_id=1'; 
					}, 200); 
	        	}
	        },
	    });
	}
    $('#select-boom').change(function(){
        var iditem =$(this).val();
        $.get("loadversion/"+iditem,function(data){
            $("#select-version").html(data);
        });
    });

</script>
@endsection