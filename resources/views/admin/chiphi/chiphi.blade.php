@extends("app")
@section("css")
<link rel="stylesheet" href="{{asset('js/select2/dist/css/select2.min.css')}}">
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script type="text/javascript" src="{{asset('js/bootstrap-datetimepicker.min.js')}}"></script>
  <link rel="stylesheet" href="{{asset('css/bootstrap-datetimepicker.min.css')}}" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
	.card {
	    position: relative;
	    display: -webkit-box;
	    display: flex;
	    -webkit-box-orient: vertical;
	    -webkit-box-direction: normal;
	    flex-direction: column;
	    min-width: 0;
	    word-wrap: break-word;
	    background-color: #fff;
	    background-clip: border-box;
	    border: 1px solid rgba(0,0,0,.125);
	    border-radius: .25rem;
	}

	.card-widget {
	    border: none;
	    position: relative;
	}
	.card {
	    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
	}
	.card-comments {
	    background: #f7f7f7;
	}
	.card-comments .card-comment:first-of-type {
	    padding-top: 0;
	}
	.card-comments .card-comment:last-of-type {
	    border-bottom: 0;
	}
	.card-comments .card-comment {
	    padding: 8px 0;
	    border-bottom: 1px solid #eee;
	}
	.card-comments .card-comment img, .img-sm, .user-block.user-block-sm img {
	    width: 30px!important;
	    height: 30px!important;
	}
	.card-comments .card-comment img, .img-lg, .img-md, .img-sm, .user-block.user-block-sm img {
	    float: left;
	}
	.card-comments .card-comment img {
	    float: left;
	}
	.img-circle {
	    border-radius: 50%;
	}
	.card-comments .comment-text {
	    margin-left: 40px;
	    color: #555;
	}
	.card-comments .username {
	    color: #444;
	    display: block;
	    font-weight: 600;
	}
	.card-comments .text-muted {
	    font-weight: 400;
	    font-size: 12px;
	}
	.text-muted {
	    color: #6c757d!important;
	}
	.float-right {
	    float: right!important;
	}
</style>
@endsection
@section("content")
	<div class="col-md-2">
		<a type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default"><span class="glyphicon glyphicon-plus"></span> Thêm </a>
	</div>
	<div class="col-md-2">
		<a type="button" class="btn btn-default" data-toggle="modal" data-target="#add_tamung"><span class="glyphicon glyphicon-plus"></span> Bổ Sung </a>
	</div>
	<div class="col-md-2">
		<label>Lọc tình trạng</label>
		<select id="status_select" class="form-control select2 select2-hidden-accessible"  data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;">
			<option value="100">Tất Cả</option>
	    	<option value="3">Đã Duyệt</option>
	    	<option value="2">Kế Toán Duyệt</option>
	    	<option value="1">Chờ Duyệt</option>
			<option value="4">Cần Xem Lại</option>
			<option value="0">Chờ Gửi</option>
		</select>
	</div>
	<!-- <div class="col-md-2">
		<label>Lọc Bộ Phận</label>
		<select id="roles_select" class="form-control select2 select2-hidden-accessible"  data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;">
			<option value="100">Tất Cả</option>
			@foreach($role as $value)
	    	<option value="{{$value->id}}">{{$value->name}}</option>
	    	@endforeach
		</select>
	</div> -->
	<!-- <div class="col-md-2">
		<label>Lọc Ngày Tháng</label>
		<input type="text" class="form-control" name="daterange" value="27/01/2020 - 23/02/2020" />

		<a type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modal-excel"><span class="fa fa-file-excel-o"></span></a>
	</div> -->
    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
	    <div class="row"></div>
	    <div class="row">
	        <div class="col-sm-12">
	            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
	                <thead>
	                    <tr role="row">
	                        <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >ID</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Tên</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Người đề xuất</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Tổng chi phí</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Tình Trạng</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Loại</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Trạng Thái</th>
	                        <th>Thao Tác</th>
	                    </tr>
	                </thead>
	                <tbody class="tb_show">
	                	<div class="hidden">{{$stt = 1}}</div>
	                	@foreach($chiphi as $key => $item)
		                	<tr role="row" class="odd">
		                		<td class="sorting_1">{{$stt}}</td>
		                		<td class="sorting_1"><a type="button" class="show_data" data-toggle="modal" data-target="#show_data" data-name="{{$item->name}}" data-id="{{$item->id_cp}}">{{$item->name_dx}}</a></td>
		                		<td class="sorting_1"><a type="button" class="show_duyet" data-toggle="modal" data-target="#show_duyet" data-id="{{$item->id_cp}}" data-loai="2">{{$item->name}}</a></td>
		                		<td class="sorting_1">{{number_format($item->total)}}</td>
		                		<td class="sorting_1">
		                			@if($item->status == 0)
		                			@elseif($item->status == 1)
		                				Khẩn Cấp
		                			@elseif($item->status == 2)
		                				Ưu Tiên
		                			@elseif($item->status == 3)
		                				Chờ
		                			@endif
		                		</td>
		                		<td class="sorting_1">{{$item->name_lcp}}</td>
		                        <td class="sorting_1">
		                        	@if($item->status_duyet == 0)
			                        	<a href="/sendchiphi/{{$item->id_cp}}">Chờ Gửi</a>
		                        	@elseif($item->status_duyet == 1)
			                        	<a type="button" class="show_duyet" data-toggle="modal" data-target="#show_duyet" data-id="{{$item->id_cp}}" data-loai="2">Chờ Duyệt</a>
		                			@elseif($item->status_duyet == 2)
		                				<a type="button" class="show_duyet" data-toggle="modal" data-target="#show_duyet" data-id="{{$item->id_cp}}" data-loai="3">Kế Toán Duyệt</a>
	                				@elseif($item->status_duyet == 4)
		                				<a href="/sendchiphi/{{$item->id_cp}}">Cần Xem Lại</a>
		                			@elseif($item->status_duyet == 3)
		                				Đã Duyệt
		                			@endif
		                        </td>
		                        <td class="sorting_1">
		                        	@if($item->status_duyet == 0 || $item->status_duyet == 4)
		                        	<a type="button" class="edit_data" data-toggle="modal" data-target="#edit" data-name="{{$item->name}}" data-id="{{$item->id_cp}}">
		                        		<span class="fa fa-edit"></span>
		                        	</a>
		                        	<a href="{{asset('destroychiphi').'/'.$item->id_cp}}">
		                        		<span class="fa fa-trash"></span>
		                        	</a>
		                        	@elseif($item->status_duyet == 3 && $item->id_bank == null) 
		                        		@if(Auth::user()->id == 1 || Auth::user()->id == 47 || Auth::user()->id == 48 || Auth::user()->id == 49)
				                        	<a type="button" class="add_bank" data-toggle="modal" data-target="#add_bank" data-id="{{$item->id_cp}}">
				                        		<span class="fa fa-edit"></span>
				                        	</a>
			                        	@endif
		                        	@endif
		                        	@if($item->status_duyet == 1  &&  $item->id_bank != null) 
		                        		@if( Auth::user()->id == $item->user_create || Auth::user()->id == $item->user_dx )
				                        	<a type="button" class="edit_duyet" data-toggle="modal" data-target="#edit_duyet" data-name="{{$item->name}}" data-id="{{$item->id_cp}}">
				                        		<span class="fa fa-edit"></span>
				                        	</a>
			                        	@endif
		                        	@endif
	                        		{{$color = ''}}
		                        	@if($item->total - $item->total_thuc < 0) 
		                        		<p class="hidden">{{$color = 'text-red'}}</p>
	                        		@endif
			                        @if($item->total - $item->total_thuc > 0)
			                        	<p class="hidden">{{$color = 'text-yellow'}}</p>
		                        	@endif
		                        	<a type="button" class="show_data {{$color}}" data-toggle="modal" data-target="#show_data" data-name="{{$item->name}}" data-id="{{$item->id_cp}}">
		                        		<span class="fa fa-eye"></span>
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
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title">Chi Phí</h4>
	            </div>
	            <div class="modal-body addCreate">
	            	<div class="form-group col-md-12">
				        <label>Đề Xuất:</label>
			            <input type="text" class="form-control" id="dexuat" placeholder="Nhập đề xuất / tạm ứng..." >
				    </div>
	            	<div class="form-group col-md-6">
				        <label>Nhân Viên:</label>
			            <select id="user_dx" class="form-control select2 select2-hidden-accessible"  data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;">
			            	<option></option>
			            	@foreach($nhanvien as $item)
						    <option value="{{$item->id}}">{{$item->name}}</option>
						    @endforeach
						</select>
				    </div>
				    <div class="form-group col-md-6">
				        <label>Bộ Phận:</label>
			            <select id="role_dx" class="form-control select2 select2-hidden-accessible"  data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;">
			            	<option></option>
			            	@foreach($role as $value)
					    	<option value="{{$value->id}}">{{$value->name}}</option>
					    	@endforeach
						</select>
				    </div>
				    <div class="form-group col-md-6">
				        <label>Thời gian cần:</label>
		                <span class='input-group date' id='need_date'>
		                    <input type='text' class="form-control" id='date_need'/>
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </span>
				    </div>
				    <div class="form-group col-md-6">
				        <label>Thời gian xuất tiền:</label>
		                <span class='input-group date' id='money_date'>
		                    <input type='text' class="form-control" id='date_money'/>
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </span>
				    </div>
				    
				    <div class="form-group col-md-6">
				    	<a onclick="addInputToForm()">Thêm Chi Phí</a>
				    </div>
				    <div class="form-group col-md-6">
				    	<label><input type="checkbox" id="checkbox" value="0">Tạm Ứng</label>
				    </div>

				    <div class="form-group lines col-md-12">
				    	<table class="table table-striped">
				    		<thead>
				    			<tr>
					    			<td class="text-center">Tên</td>
					    			<td class="text-center">SL</td>
					    			<td class="text-center">Đơn Vị</td>
					    			<td class="text-center">Giảm Gía</td>
					    			<td class="text-center">Tiền</td>
					    			<td class="text-center">Thành Tiền</td>
					    			<td class="text-center">Nội Dung</td>
				    			</tr>
				    		</thead>
				    		<tbody id="lines">
				    			
				    		</tbody>		
				    	</table>
				    </div>
				    <div class="col-md-12"><div id="dataList"><br></div></div>
			    	
				    <div class="form-group col-md-6">
				    	<label>Tổng Tiền: </label>
				    	<input type="number" min="1" step="any" disabled="" class="hide" name="total" id='total' pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$">
				    </div>
				    <div class="form-group col-md-6">
				    	<label>Tạm Ứng: </label>
				    	<input type="number" min="1" step="any" name="tamung" id='tamung' pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$">
				    </div>
				    <div class="form-group col-md-6">
				        <label>Loại Chi Phí:</label>
			            <select id="loaichiphi">
			            	<option></option>
			            	@foreach($loaichiphi as $item)
						    <option value="{{$item->id}}">{{$item->name_lcp}}</option>
						    @endforeach
						 </select>
				    </div>
				    <div class="form-group col-md-6">
				        <label>Tình Trạng:</label>
			            <select id="status">
						    <option vlaue="0"></option>
						    <option value="1">Khẩn Cấp</option>
						    <option value="2">Ưu Tiên</option>
						    <option value="3">Chờ</option>
						 </select>
				    </div>
				    
				    <div class="form-group col-md-12">
				        <label>Mục Đích:</label>
			            <textarea  rows="4" cols="50" type="text" class="form-control" id="chuy" ></textarea > 
				    </div>

	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="addchiphi()"  type="button" class="btn btn-primary">Lưu</a>
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
	            	<form action="{{ url('importItem') }}"  method="post" enctype="multipart/form-data">
	            		@csrf
				        <div class="form-group col-md-12">
							<span class="control-fileupload">
								<label for="fileInput">Chọn Tệp :</label>
								<input type="file" name="fileInput" id="fileInput">
								<input type="submit" value="Đồng ý">
							</span>
						</div>
		            </form>
	            </div>
	        </div>
	        <div class="modal-footer">
            </div>
	    </div>
	</div>

	<div class="modal fade" id="show_data" data-toggle="modal" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close close_data" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title">Chi Tiết Chi Phí</h4>
	            </div>
	            <div class="modal-body">
	            	<h4 class="name_dx_show">Đề xuất mua ổ cứng</h4>
	            	<label>Người đề xuất:</label><i id="name_show"> </i>
	            	<label class="pull-right">Bộ Phận: <i id="roles_show"></i></label><br>
	            	<label>Thời gian đề xuất: <i id="date_show"> </i></label><br>
	            	<label>Thời gian cần: <i id="date_need_show"> </i></label><br>
	            	<label>Thời gian xuất tiền: <i id="date_money_show"> </i></label><br>
	            	<label class="pull-right">Tổng tiền: <i id="total_show"></i></label><br>
	            	<div>
		            	<table class="table table-striped">
		            		<thead>
		            			<td class="text-center">STT</td>
		            			<td class="text-center">Tên</td>
		            			<td class="text-center">SL</td>
		            			<td class="text-center">Đơn Vị</td>
		            			<td class="text-center">Giá</td>
		            			<td class="text-center">Giảm Gía</td>
		            			<td class="text-center">Thành Tiền</td>
		            			<td class="text-center">Gía Thực Tế</td>
		            			<td class="text-center">Ghi Chú</td>
		            		</thead>
		            		<tbody id="show_line">
		            			
		            		</tbody>
		            	</table>
	            	</div>
	            </div>
	            <div class="modal-footer">
	            	<div class="show_image pull-left">
	            		
	            	</div>
	                <form id="data-chiphi" enctype="multipart/form-data">
		            	<div class="form-group col-md-12">
						    <label class="pull-left">Tài Liệu</label><br><br>
						    <input type="hidden" name="id" id="input_id">
	                        <input type="file" name="file[]" multiple="multiple">
	                        <input class="submit_cp pull-right" type="button" value="Đồng Ý">
	                    </div>	
		            </form>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="show_duyet" data-toggle="modal" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close close-duyet" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title">Duyệt</h4>
	            </div>
	            <div class="modal-body">
	            	<div class="box-chat">
	            		<div class="card card-widget">
						    
						</div>
						<div class="card-footer">
					        <div class="img-push">
				            	<input type="hidden" id="id_comment">
				            	<input type="hidden" id="loai">
					            <textarea placeholder="Nội dung bình luận" class="form_comment form-control form-control"></textarea>
					            <button class="btn btn-primary submit_comment">Gửi bình luận</button>
					        </div>
					    </div>
	            	</div>
	            </div>
	            <div class="modal-footer">
	            	<div class="turn_status turn_stt hidden">
		            	<button class="duyet_chiphi">Duyệt</button>
		            	<button class="khongduyet_chiphi">Không Duyệt</button>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="edit">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title">Sửa Chi Phí</h4>
	            </div>
	            <div class="modal-body addCreate">
	            	<div class="form-group col-md-12">
				        <label>Đề Xuất:</label>
			            <input type="text" class="form-control" id="dexuat_edit" placeholder="Nhập đề xuất / tạm ứng...">
				    </div>
	            	<div class="form-group col-md-6">
				        <label>Nhân Viên:</label>
			            <select id="user_dx_edit" class="form-control" data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;">
			            	<option></option>
			            	@foreach($nhanvien as $item)
						    <option value="{{$item->id}}">{{$item->name}}</option>
						    @endforeach
						</select>
				    </div>
				    <div class="form-group col-md-6">
				        <label>Bộ Phận:</label>
			            <select id="role_dx_edit" class="form-control" data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;">
			            	<option></option>
			            	@foreach($role as $item)
						    <option value="{{$item->id}}">{{$item->name}}</option>
						    @endforeach
						</select>
				    </div>
				    <div class="form-group col-md-6">
				        <label>Thời gian cần:</label>
		                <span class='input-group date' id='need_date'>
		                    <input type='text' class="form-control" id='date_need_edit'/>
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </span>
				    </div>
				    <div class="form-group col-md-6">
				        <label>Thời gian xuất tiền:</label>
		                <span class='input-group date' id='money_date'>
		                    <input type='text' class="form-control" id='date_money_edit'/>
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </span>
				    </div>
				    <!-- <div class="form-group col-md-12">
				    	<a onclick="addInputToForm()">Thêm Chi Phí</a>
				    </div> -->
				    <input type="hidden" id="edit_id">
				    <div class="form-group  col-md-12">
				    	<table>
				    		<thead>
				    			<tr>
					    			<td class="text-center">STT</td>
					    			<td class="text-center">Tên</td>
					    			<td class="text-center">SL</td>
					    			<td class="text-center">Đơn Vị</td>
					    			<td class="text-center">Giảm Giá</td>
					    			<td class="text-center">Tiền</td>
					    			<td class="text-center">Thành Tiền</td>
					    			<td class="text-center">Nội Dung</td>
				    			</tr>
				    		</thead>
				    		<tbody id="lines_edit">
				    			
				    		</tbody>		
				    	</table>
				    </div>
				    <div class="form-group col-md-6">
				    	<label>Tổng Tiền: </label>
				    	<input type="number" min="1" step="any" disabled="" name="total" id='total_edit' pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$">
				    </div>
				    <div class="form-group col-md-6">
				    	<label>Tạm Ứng: </label>
				    	<input type="number" min="1" step="any" disabled="" name="total" id='total_edit' pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$">
				    </div>
				    <div class="form-group col-md-6">
				        <label>Loại Chi Phí:</label>
			            <select id="loaichiphi_edit">
			            	<option></option>
			            	@foreach($loaichiphi as $item)
						    <option value="{{$item->id}}">{{$item->name_lcp}}</option>
						    @endforeach
						 </select>
				    </div>
				    <div class="form-group col-md-6">
				        <label>Tình Trạng:</label>
			            <select id="status_edit">
						    <option vlaue="0"></option>
						    <option value="1">Khẩn Cấp</option>
						    <option value="2">Ưu Tiên</option>
						    <option value="3">Chờ</option>
						 </select>
				    </div>

				    <div class="form-group col-md-12">
				        <label>Mục Đích:</label>
			            <textarea  rows="4" cols="50" type="text" class="form-control" id="chuy_edit" ></textarea > 
				    </div>

	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="editchiphi()"  type="button" class="btn btn-primary">Lưu</a>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="edit_duyet">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title">Chi Phí</h4>
	            </div>
	            <div class="modal-body addCreate">
	            	<div class="form-group col-md-12">
				        <label>Đề Xuất: <i class="duyet_edit_name_dx">	</i></label>
				    </div>
	            	<div class="form-group col-md-12">
				        <label>Nhân Viên: <i class="duyet_edit_name">	</i></label>
				    </div>
				    <input type="hidden" id="duyet_id">
				    <div class="form-group  col-md-12">
				    	<table class="table table-striped">
				    		<thead>
				    			<tr>
					    			<td class="text-center">STT</td>
					    			<td class="text-center">Tên</td>
					    			<td class="text-center">SL</td>
					    			<td class="text-center">Đơn Vị</td>
					    			<td class="text-center">Tiền</td>
					    			<td class="text-center">Giảm Gía</td>
					    			<td class="text-center">Thành Tiền</td>
					    			<td class="text-center">SL Thực Tế</td>
					    			<td class="text-center">Tiền Thực Tế</td>
					    			<td class="text-center">Tổng Tiền Thực Tế</td>
					    			<td class="text-center">Nội Dung</td>
				    			</tr>
				    		</thead>
				    		<tbody id="lines_duyet">
				    			
				    		</tbody>		
				    	</table>
				    </div>
				    <div class="form-group col-md-12">
				    	<label>Tổng Tiền:</label>
				    	<input type="number" min="1" step="any" disabled="" name="total" id='duyet_total_edit' pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$">
				    </div>
				    <div class="form-group col-md-12">
				    	<p>Mục Đích: <span class="duyet_chuy"></span> </p>
				    </div>
				    <div class="form-group col-md-6">
				        <label>Loại Chi Phí:<i class="duyet_edit_lcp">	</i></label>
				    </div>
				    <div class="form-group col-md-6">
				        <label>Tình Trạng:<i class="duyet_edit_status">	</i></label>
				    </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="duyetchiphi()"  type="button" class="btn btn-primary">Chuyển Chi Phí</a>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="add_bank">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title">Chi Phí</h4>
	            </div>
	            <div class="modal-body">
			    	<input type="hidden" id='bank_id_cp' >
				    <div class="col-md-12">
			            <label>	Tài khoản </label>
			    		<div class="form-group">
			                <select class="form-control select2" id="bank">
			                	@foreach($bank as $value)
									<option value="{{$value->id}}">{{$value->description}}</option>
								@endforeach
			                </select>
			            </div>
			    	</div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="addbank()"  type="button" class="btn btn-primary">Lưu</a>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="add_tamung">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title">Đề Xuất Chi Phí Bổ Sung</h4>
	            </div>
	            <div class="modal-body">
			    	<input type="hidden">
				    <div class="col-md-12">
			            <label>	Danh Sách Tạm Ứng Trước Đó </label>
			    		<div class="form-group">
			                <select class="form-control select2" id="select_tamung">
				                	<option></option>
			                	@foreach($tamung as $value)
									<option value="{{$value->id_cp}}">{{$value->name_dx}}</option>
								@endforeach
			                </select>
			            </div>
			            <div class="form-group ">
				            <label>	Số Tiền Tạm Ứng Còn Lại</label>
					    	<input type="number" id='con_lai'>
					    </div>
			    	</div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="addCP()"  type="button" class="btn btn-primary">Lưu</a>
	            </div>
	        </div>
	    </div>
	</div>

@endsection

@section('js')
<script src="{{asset('js/select2/dist/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
$('#user_dx,#status_select,#item,#des,#roles_select,#role_dx').select2();
$('#money_date,#need_date').datetimepicker();
$('#status_select').change(function(){
	$.ajax({
        url:"/filterStatus",
        type:'post',
        data: {
            status_duyet : $(this).val(),
        },
        success:function(data){
            var res = '';
            var color = '';
            if (data.chiphi.length > 0) {
	            $.each (data.chiphi, function (key, value) {
	                var stt = key + 1;
	                if (value.status == 1) {
	                	var status = 'Khẩn Cấp';
	                }
	                if (value.status == 2) {
	                	var status = 'Ưu Tiên';
	                }
	                if (value.status == 3) {
	                	var status = 'Chờ';
	                }

	                if (value.total > value.total_thuc) {
	                	color = 'text-yellow';
	                }
	                if (value.total < value.total_thuc) {
	                	color = 'text-red';
	                }

	                if (value.status_duyet == 0) {
	                	var duyet = '<a href="/sendchiphi/'+value.id_cp+'">Chờ Gửi</a>';
	                	var action = '<a type="button" class="edit_data" data-toggle="modal" data-target="#edit" data-name="'+value.name+'" data-id="'+value.id_cp+'">'+
		                        		'<span class="fa fa-edit"></span>'+
		                        	'</a><a href="/destroychiphi/'+value.id_cp+'">'+
		                        		'<span class="fa fa-trash"></span>'+
		                        	'</a>';
	                }
	                if (value.status_duyet == 1) {
	                	var duyet = '<a type="button" class="show_duyet" data-toggle="modal" data-target="#show_duyet" data-id="'+value.id_cp+'" data-loai="2">Chờ Duyệt</a>';
	                	var action = '';
	                }
	                if (value.status_duyet == 2) {
	                	var duyet = '<a type="button" class="show_duyet" data-toggle="modal" data-target="#show_duyet" data-id="'+value.id_cp+'" data-loai="3">Kế Toán Duyệt</a>';
	                	var action = '';
	                }
	                if (value.status_duyet == 3) {
	                	var duyet = 'Đã Duyệt';
	                	var user = '{!! auth()->user()->id !!}';
	                	if(user == 1 || user == 47 || user == 48 || user == 49){
		                	var action = '<a type="button" class="edit_duyet" data-toggle="modal" data-target="#edit_duyet" data-name="'+value.id_cp+'" data-id="'+value.id_cp+'">'+
			                        		'<span class="fa fa-edit"></span>'+
			                        	'</a>';
				    	}else{
				    		var action = '';	
				    	}
	                }
	                if (value.status_duyet == 4) {
	                	var duyet = '<a href="/sendchiphi/'+value.id_cp+'">Cần Xem Lại</a>';
	                	var action = '<a type="button" class="edit_data" data-toggle="modal" data-target="#edit" data-name="'+value.name+'" data-id="'+value.id_cp+'">'+
		                        		'<span class="fa fa-edit"></span>'+
		                        	'</a><a href="/destroychiphi/'+value.id_cp+'">'+
		                        		'<span class="fa fa-trash"></span>'+
		                        	'</a>';
	                }

	                res +=
	                '<tr role="row" class="odd">'+
	                	'<td>'+stt+'</td>'+
	                    '<td><a type="button" class="show_data" data-toggle="modal" data-target="#show_data" data-name="'+value.name+'" data-id="'+value.id_cp+'">'+value.name_dx+'</a></td>'+
	                    '<td>'+value.name+'</td>'+
	                    '<td>'+format(value.total)+'</td>'+
	                    '<td>'+status+'</td>'+
	                    '<td>'+value.name_lcp+'</td>'+
	                    '<td>'+duyet+'</td>'+
	                    '<td>'+action+
	                    '<a type="button" class="show_data '+color+'" data-toggle="modal" data-target="#show_data" data-name="'+value.name+'" data-id="'+value.id_cp+'"><span class="fa fa-eye"></span>'+
	                    '</a></td>'+
		                        	
	               '</tr>';
	            });
            }
	        $('.tb_show').html(res);
	        $('.show_data').click(function () {
				$('#input_id').val($(this).data('id'));
			    $.ajax({
			        url:"/showChiPhi",
			        type:'post',
			        data: {
			            id : $(this).data('id'),
			        },
			        success:function(data){
			            var res = '';
			            var role = '';
			            $.each (data.list, function (key, value) {
			                var stt = key + 1;
			                if(value.content == null) {
			                	var content = '';
			                }else{
			                	var content = value.content;
			                }
			                res +=
			                '<tr>'+
			                	'<td>'+stt+'</td>'+
			                    '<td>'+value.ten+'</td>'+
			                    '<td>'+value.so_luong+'</td>'+
			                    '<td>'+value.donvi+'</td>'+
			                    '<td>'+format(value.money)+'</td>'+
			                    '<td>'+format(value.giamgia)+'</td>'+
			                    '<td>'+format(value.thanh_tien)+'</td>'+
			                    '<td>'+format(value.money_thucte)+'</td>'+
			                    '<td>'+content+'</td>'+
			               '</tr>';
			                $('#show_line').html(res);
			            });
			            $.each (data.role, function (key, value) {
			                if(value.id > 6) {
			                	role += value.name;
			                }
			                $('#roles_show').text(role);
			            });
			            var img = '';
			            $.each (data.image, function (key, value) {
			                img += '<a href="'+value.link+'" target="_blank"><img src="'+value.link+'" width="180" target="_blank"></a><a href="/deletemedia/'+value.id+'" style="position: relative;"><span class="fa fa-trash" style="position: absolute;left: -10px;"></span></a>';
			                $('.show_image').html(img);
			            });
			            $('#name_show').text(data.chiphi.name);
			            $('#total_show').text(format(data.chiphi.total)+'/'+format(data.chiphi.total_thuc));
			            $('.name_dx_show').text(data.chiphi.name_dx);
			            $('#date_show').text(data.chiphi.created_at);
			            $('#date_need_show').text(data.chiphi.date_need);
			            $('#date_money_show').text(data.chiphi.date_money);
			        }
			    });
			});
			$('.show_duyet').click(function () {
				$('#id_comment').val($(this).data('id'));
				$('#loai').val($(this).data('loai'));
			    $.ajax({
			        url:"/showComment",
			        type:'post',
			        data: {
			            id : $(this).data('id'),
			        },
			        success:function(data){
			            var res = '';
			            var user = '{!! auth()->user()->id !!}';
					    if ($('#loai').val() == 2) {
					    	if(user == 1 || user == 47 || user == 48 || user == 49){
					    		$('.turn_stt').removeClass('hidden');
					    	}else{
					    		$('.turn_stt').addClass('hidden');
					    	}
					    }
					    if ($('#loai').val() == 3) {
					    	if(user == 1 || user == 3){
					    		$('.turn_stt').removeClass('hidden');
					    	}else{
					    		$('.turn_stt').addClass('hidden');
					    	}
					    }
			            $.each (data.comment, function (key, value) {
			                res +=
			                '<div class="card-footer card-comments"><div class="card-comment"><img class="img-circle img-sm" src="'+value.avatar+'"><div class="comment-text"><span class="username">'
			                    +value.name+'<span class="text-muted float-right">2 giờ trước</span></span>'+value.content+'</div></div>';
			                $('.box-chat .card').html(res);
			            });	       
			        }
			    });
			});
			$('.edit_data').click(function () {
				$('#edit_id').val($(this).data('id'));
			    $.ajax({
			        url:"/showChiPhi",
			        type:'post',
			        data: {
			            id : $(this).data('id'),
			        },
			        success:function(data){
			            var res = '';
			            $.each (data.list, function (key, value) {
			                var stt = key + 1;
			                if(value.content == null) {
			                	var content = '';
			                }else{
			                	var content = value.content;
			                }
			                res += '<tr class="edit_post">'+
			                '<td>'+stt+'</td>'+
			                '<td><input type="text" name="noidung" value="'+value.ten+'"></td>'+
			                '<td><input type="text" name="soluong" style="width: 40px;" value="'+value.so_luong+'" ></td>'+
			                '<td><input type="text" name="donvi" style="width: 40px;" value="'+value.donvi+'"></td>'+
			                '<td><input type="text" name="giamgia" style="width: 90px;" value="'+value.giamgia+'"></td>'+
			                '<td><input type="text" name="money" class="money_edit" style="width: 90px;" value="'+value.money+'"></td>'+
			                '<td><input type="text" name="thanhtien" class="thanhtien_edit" style="width: 90px;" value="'+value.thanh_tien+'" disabled></td>'+
			                '<td><input type="text" name="note" placeholder="Nhập nội dung" value="'+content+'"></td>'+
			                '<td><input type="button" value="Xóa" class="delete_line_edit"></td></tr>';
			            });
			            $('#lines_edit').append(res);
			            $('#dexuat_edit').val(data.chiphi.name_dx);
			            $('#total_edit').val(data.chiphi.total);
			            $('#loaichiphi_edit').val(data.chiphi.id_phanloai).attr('selected','selected');
			            $('#status_edit').val(data.chiphi.status).attr('selected','selected');
			            $('#user_dx_edit').val(data.chiphi.user_dx).attr('selected','selected');
			            $('#role_dx_edit').val(data.chiphi.role_id).attr('selected','selected');
			            $('#chuy_edit').val(data.chiphi.chuy);
			            $('#date_need_edit').val(data.chiphi.date_need);
			            $('#date_money_edit').val(data.chiphi.date_money);
					    $(".money_edit").on("keydown keyup", function() {
					        var sum = 0;
						    $(".money_edit").each(function() {
						        if (!isNaN(this.value) && this.value.length != 0) {
						            var total =  $(this).parent().prev().prev().prev().children().val() * $(this).val() - $(this).parent().prev().children().val();
						            $(this).css("background-color", "#FEFFB0");
						            $(this).parent().next().children().val(total);
						        }
						        else if (this.value.length != 0){
						            $(this).css("background-color", "red");
						        }
						    });
							$(".thanhtien_edit").each(function() {
						        if (!isNaN(this.value) && this.value.length != 0) {
						            sum += parseFloat(this.value);
						        }
						        
						    });

							$("input#total_edit").val(sum);
					    });

					    $('.delete_line_edit').click(function () {
							$(this).parent().parent().remove();
						});
			        }
			    });
			});
			$('.edit_duyet').click(function () {
				$('#duyet_id').val($(this).data('id'));
			    $.ajax({
			        url:"/showChiPhi",
			        type:'post',
			        data: {
			            id : $(this).data('id'),
			        },
			        success:function(data){
			            var res = '';
			            $.each (data.list, function (key, value) {
			                var stt = key + 1;
			                if(value.content == null) {
			                	var content = '';
			                }else{
			                	var content = value.content;
			                }
			                res += '<tr class="duyet_post">'+
			                '<td><input type="hidden" class="thanhtien_edit" value="'+value.id+'">'+stt+'</td>'+
			                '<td>'+value.ten+'</td>'+
			                '<td>'+value.so_luong+'</td>'+
			                '<td>'+value.donvi+'</td>'+
			                '<td>'+value.giamgia+'</td>'+
			                '<td>'+value.money+'</td>'+
			                '<td>'+value.thanh_tien+'</td>'+
			                '<td><input type="text" name="soluong" class="soluong_edit" value="'+value.so_luong+'"></td>'+
			                '<td><input type="text" name="gia" class="gia_edit" value="'+value.money+'"></td>'+
			                '<td><input type="text" name="thanhtien" class="thanhtien_edit" value="'+value.money_thucte+'"></td>'+
			                '<td><input type="text" name="note" placeholder="Nhập nội dung" value="'+content+'"></td>';
			            });
			            $('#lines_duyet').append(res);
			            $('.duyet_edit_name').text(data.chiphi.name);
			            $('.duyet_edit_name_dx').text(data.chiphi.name_dx);
			            $('.duyet_edit_lcp').text(data.chiphi.name_lcp);
            			$('.duyet_chuy').text(data.chiphi.chuy);

			            $('#duyet_total_edit').val(data.chiphi.total_thuc);
			            if(data.chiphi.status == 1) {
			            	$('.duyet_edit_status').text("Khẩn Cấp");
			            }
			            if(data.chiphi.status == 2) {
			            	$('.duyet_edit_status').text("Ưu Tiên");
			            }
			            if(data.chiphi.status == 3) {
			            	$('.duyet_edit_status').text("Chờ");
			            }
			            
					    $(".thanhtien_edit").on("keydown keyup", function() {
					        var sum = 0;
						    $(".thanhtien_edit").each(function() {
						        if (!isNaN(this.value) && this.value.length != 0) {
						            var total =  $(this).val();
						            $(this).css("background-color", "#FEFFB0");
						        }
						        else if (this.value.length != 0){
						            $(this).css("background-color", "red");
						        }
						    });
							$(".thanhtien_edit").each(function() {
						        if (!isNaN(this.value) && this.value.length != 0) {
						            sum += parseFloat(this.value);
						        }
						        
						    });

							$("#duyet_total_edit").val(sum);
					    });

			        }
			    });
			});
        }
    });
});

$('#select_tamung').change(function(){
    var idver = $(this).val();
    $.get("/show_tamung/"+idver,function(data){
    	$('#con_lai').val(data);
    });
});

function addCP() {
	var addCP= '{{ route("addCP") }}';
	$.ajax({
        data: {
            id : $('#select_tamung').val(),
            tam_ung :$('#con_lai').val(),
        },
        url: addCP,
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

var count = 0;
function addInputToForm() {
	$('#total').removeClass('hide');
	
	count += 1;
	const form = document.createElement("tr");
	const td = document.createElement("td");
	const td1 = document.createElement("td");
	const td2 = document.createElement("td");
	const td3 = document.createElement("td");
	const td4 = document.createElement("td");
	const td5 = document.createElement("td");
	const td6 = document.createElement("td");
	const td7 = document.createElement("td");

	const noidung = document.createElement("INPUT");
	const money = document.createElement("INPUT");
	const note = document.createElement("INPUT");
	const soluong = document.createElement("INPUT");
	const thanhtien = document.createElement("INPUT");
	const button = document.createElement("INPUT");
	const giamgia = document.createElement("INPUT");
	const donvi = document.createElement("INPUT");

	td.appendChild(noidung);
	td1.appendChild(soluong);
	td2.appendChild(donvi);
	td3.appendChild(giamgia);
	td4.appendChild(money);
	td5.appendChild(thanhtien);
	td6.appendChild(note);
	td7.appendChild(button);

	form.appendChild(td);
	form.appendChild(td1);
	form.appendChild(td2);
	form.appendChild(td3);
	form.appendChild(td4);
	form.appendChild(td5);
	form.appendChild(td6);
	form.appendChild(td7);

	document.getElementById("lines").appendChild(form);

	noidung.type = "text";
	money.type = "text";
	note.type = "text";
	soluong.type = "text";
	thanhtien.type = "text";
	donvi.type = "text";
	giamgia.type = "text";
	button.type = "button";

	noidung.name = "noidung";
	money.name = "money";
	note.name = "note";
	soluong.name = "soluong";
	thanhtien.name = "thanhtien";
	donvi.name = "donvi";
	giamgia.name = "giamgia";

	noidung.placeholder = "Tên "+count;
	money.placeholder = "Tiền "+count;
	note.placeholder = "ghi chú "+count;
	soluong.placeholder = "SL"+count;
	thanhtien.placeholder = "Thành tiền "+count;
	donvi.placeholder = "Đơn Vị "+count;
	giamgia.placeholder = "Giảm Gía "+count;

	soluong.value = "1";
	giamgia.value = "0";
	donvi.value = "cái";
	button.value = "Xóa";
	form.classList = "sum_add";
	money.classList = "money";
	button.classList = "delete_line";
	thanhtien.classList = "thanhtien";

	soluong.style = "width:40px;";
	donvi.style = "width:70px;";
	giamgia.style = "width:90px;";
	money.style = "width:90px;";
	thanhtien.style = "width:90px;";
	thanhtien.disabled="disabled";

    $(".money").on("keydown keyup", function() {
        calculateSum();
    });

	$('.delete_line').click(function () {
		$(this).parent().remove();
	});

	$('input[name="noidung"]').keyup(function(){
		var query = this.value;
		if(query != ''){
			$.ajax({
				url:"{{ route('search') }}", 
				method:"POST", 
				data:{query:query},
				success:function(data){ 
					$('#dataList').fadeIn();  
					$('#dataList').html(data); 
				}
			})
		}
	});	
	$(document).on('click', 'li', function(){  
		$('input[name="noidung"]').last().val($(this).text());  
	    $('#dataList').fadeOut();  
	}); 
}

function format(num) {
  return num.toString().replace(/^[+-]?\d+/, function(int) {
    return int.replace(/(\d)(?=(\d{3})+$)/g, '$1,');
  });
}

function calculateSum() {
    var sum = 0;
    $(".money").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            var total =  $(this).parent().prev().prev().prev().children().val() * $(this).val() - $(this).parent().prev().children().val();
            $(this).css("background-color", "#FEFFB0");
            $(this).parent().next().children().val(total)
        }
        else if (this.value.length != 0){
            $(this).css("background-color", "red");
        }
    });
	$(".thanhtien").each(function() {
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);
        }
        
    });

	$("input#total").val(sum);
	$("input#tamung").val(sum);
}

function addchiphi() {
	var addchiphi= '{{ route("addchiphi") }}';
	var data = $('.sum_add > td ').map(function() {
		var obj = '';
		$(this).find('input, textarea').each(function() {
			obj += $(this).val();
		})
		return obj;
	}).get()
	console.log(data);
	$.ajax({
        data: {
            name : $('#dexuat').val(),
            line : data,
            nhanvien : $('#user_dx').val(),
            total : $('#total').val(),
            loaichiphi : $('#loaichiphi').val(),
            status :$('#status').val(),
            chuy :$('#chuy').val(),
            check : $("#checkbox").is(":checked"),
            date_money :$('#date_money').val(),
            date_need : $("#date_need").val(),
            role_dx : $("#role_dx").val(),
            tamung : $("#tamung").val(),
        },
        url: addchiphi,
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

function editchiphi() {
	var editchiphi= '{{ route("editchiphi") }}';
	var data = $('.edit_post > td').map(function() {
		var obj = '';
		$(this).find('input, textarea').each(function() {
			obj += $(this).val();
		})
		return obj;
	}).get()
	$.ajax({
        data: {
            name : $('#dexuat_edit').val(),
            line : data,
            role_dx : $('#role_dx_edit').val(),
            nhanvien : $('#user_dx_edit').val(),
            date_need: $('#date_need_edit').val(),
			date_money: $('#date_money_edit').val(),
            chuy : $('#chuy_edit').val(),
            total : $('#total_edit').val(),
            loaichiphi : $('#loaichiphi_edit').val(),
            status :$('#status_edit').val(),
            id: $('#edit_id').val(),
        },
        url: editchiphi,
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

function duyetchiphi(){
	var duyethai = '{{ route("duyethai") }}';
	var data = $('.duyet_post > td').map(function() {
		var obj = '';
		$(this).find('input, textarea').each(function() {
			obj += $(this).val();
		})
		return obj;
	}).get()
	$.ajax({
        data: {
            line : data,
            total_thuc	: $('#duyet_total_edit').val(),
            id : $('#duyet_id').val(),
        },
        url: duyethai,
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

function addbank(){
	var addbank = '{{ route("addbank") }}';
	$.ajax({
        data: {
            id_bank	: $('#bank').val(),
            id : $('#bank_id_cp').val(),
        },
        url: addbank,
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

$('.add_bank').click(function () {
	$('#bank_id_cp').val($(this).data('id'));
});

$('.show_data').click(function () {
	$('#input_id').val($(this).data('id'));
    $.ajax({
        url:"/showChiPhi",
        type:'post',
        data: {
            id : $(this).data('id'),
        },
        success:function(data){
            var res = '';
            var role = '';
            $.each (data.list, function (key, value) {
                var stt = key + 1;
                if(value.content == null) {
                	var content = '';
                }else{
                	var content = value.content;
                }
                res +=
                '<tr>'+
                	'<td>'+stt+'</td>'+
                    '<td>'+value.ten+'</td>'+
                    '<td>'+value.so_luong+'</td>'+
                    '<td>'+value.donvi+'</td>'+
                    '<td>'+format(value.money)+'</td>'+
                    '<td>'+format(value.giamgia)+'</td>'+
                    '<td>'+format(value.thanh_tien)+'</td>'+
                    '<td>'+format(value.money_thucte)+'</td>'+
                    '<td>'+content+'</td>'+
               '</tr>';
                $('#show_line').html(res);
            });
            $.each (data.role[0].roles, function (key, value) {
                if(value.id > 6) {
                	role += value.name;
                }
                $('#roles_show').text(role);
            });
            var img = '';
            $.each (data.image, function (key, value) {
                img += '<a href="'+value.link+'" target="_blank"><img src="'+value.link+'" width="180" target="_blank"></a><a href="/deletemedia/'+value.id+'" style="position: relative;"><span class="fa fa-trash" style="position: absolute;left: -10px;"></span></a>';
                $('.show_image').html(img);
            });
            $('#name_show').text(data.chiphi.name);
            $('#total_show').text(format(data.chiphi.total)+'/'+format(data.chiphi.total_thuc));
            $('.name_dx_show').text(data.chiphi.name_dx);
            $('#date_show').text(data.chiphi.created_at);
            $('#date_need_show').text(data.chiphi.date_need);
            $('#date_money_show').text(data.chiphi.date_money);
        }
    });
});

$('.edit_data').click(function () {
	$('#edit_id').val($(this).data('id'));
    $.ajax({
        url:"/showChiPhi",
        type:'post',
        data: {
            id : $(this).data('id'),
        },
        success:function(data){
            var res = '';
            $.each (data.list, function (key, value) {
                var stt = key + 1;
                if(value.content == null) {
                	var content = '';
                }else{
                	var content = value.content;
                }
                res += '<tr class="edit_post">'+
                '<td>'+stt+'</td>'+
                '<td><input type="text" name="noidung" placeholder="Nhập nội dung" value="'+value.ten+'"></td>'+
                '<td><input type="text" name="soluong" placeholder="SL" style="width: 40px;" value="'+value.so_luong+'" ></td>'+
                '<td><input type="text" name="donvi" placeholder="SL" style="width: 60px;" value="'+value.donvi+'" ></td>'+
                '<td><input type="text" name="giamgia" placeholder="SL" style="width: 90px;" value="'+value.giamgia+'" ></td>'+
                '<td><input type="text" name="money" class="money_edit" placeholder="Nhập số tiền" style="width: 90px;" value="'+value.money+'"></td>'+
                '<td><input type="text" name="thanhtien" class="thanhtien_edit" style="width: 90px;" value="'+value.thanh_tien+'" disabled></td>'+
                '<td><input type="text" name="note" placeholder="Nhập nội dung" value="'+content+'"></td>'+
                '<td><input type="button" value="Xóa" class="delete_line_edit"></td></tr>';
            });
            $('#lines_edit').append(res);
            $('#dexuat_edit').val(data.chiphi.name_dx);
            $('#total_edit').val(data.chiphi.total);
            $('#loaichiphi_edit').val(data.chiphi.id_phanloai).attr('selected','selected');
            $('#status_edit').val(data.chiphi.status).attr('selected','selected');
            $('#user_dx_edit').val(data.chiphi.user_dx).attr('selected','selected');
			$('#role_dx_edit').val(data.chiphi.role_id).attr('selected','selected');
            $('#date_need_edit').val(data.chiphi.date_need);
            $('#date_money_edit').val(data.chiphi.date_money);            
            $('#chuy_edit').val(data.chiphi.chuy);
		    $(".money_edit").on("keydown keyup", function() {
		        var sum = 0;
			    $(".money_edit").each(function() {
			        if (!isNaN(this.value) && this.value.length != 0) {
			            // var total =  $(this).parent().prev().children().val() * $(this).val();
			            var total =  $(this).parent().prev().prev().prev().children().val() * $(this).val() - $(this).parent().prev().children().val();

			            $(this).css("background-color", "#FEFFB0");
			            $(this).parent().next().children().val(total);
			        }
			        else if (this.value.length != 0){
			            $(this).css("background-color", "red");
			        }
			    });
				$(".thanhtien_edit").each(function() {
			        if (!isNaN(this.value) && this.value.length != 0) {
			            sum += parseFloat(this.value);
			        }
			        
			    });

				$("input#total_edit").val(sum);
		    });

		    $('.delete_line_edit').click(function () {
				$(this).parent().parent().remove();
			});
        }
    });
});

$('.edit_duyet').click(function () {
	$('#duyet_id').val($(this).data('id'));
    $.ajax({
        url:"/showChiPhi",
        type:'post',
        data: {
            id : $(this).data('id'),
        },
        success:function(data){
            var res = '';
            $.each (data.list, function (key, value) {
                var stt = key + 1;
                if(value.content == null) {
                	var content = '';
                }else{
                	var content = value.content;
                }
                res += '<tr class="duyet_post">'+
                '<td><input type="hidden" class="thanhtien_edit" value="'+value.id+'">'+stt+'</td>'+
                '<td>'+value.ten+'</td>'+
                '<td>'+value.so_luong+'</td>'+
                '<td>'+value.donvi+'</td>'+
                '<td>'+value.money+'</td>'+
                '<td>'+value.giamgia+'</td>'+
                '<td>'+value.thanh_tien+'</td>'+
                '<td><input type="text" name="soluong" class="soluong_edit" style="width:25px" value="'+value.so_luong+'"></td>'+
                '<td><input type="text" name="gia" class="gia_edit" style="width:100px" value="'+value.money+'"></td>'+                
                '<td><input type="text" name="thanhtien" class="thanhtien_edit" style="width:100px" value="'+value.money_thucte+'"></td>'+
                '<td><input type="text" name="note" placeholder="Nhập nội dung" value="'+content+'"></td>';
            });
            $('#lines_duyet').append(res);
            $('.duyet_edit_name').text(data.chiphi.name);
            $('.duyet_edit_name_dx').text(data.chiphi.name_dx);
            $('.duyet_edit_lcp').text(data.chiphi.name_lcp);
            $('.duyet_chuy').text(data.chiphi.chuy);
            $('#duyet_total_edit').val(data.chiphi.total_thuc);
            if(data.chiphi.status == 1) {
            	$('.duyet_edit_status').text("Khẩn Cấp");
            }
            if(data.chiphi.status == 2) {
            	$('.duyet_edit_status').text("Ưu Tiên");
            }
            if(data.chiphi.status == 3) {
            	$('.duyet_edit_status').text("Chờ");
            }
            
		    $(".thanhtien_edit").on("keydown keyup", function() {
		        var sum = 0;
			    $(".thanhtien_edit").each(function() {
			        if (!isNaN(this.value) && this.value.length != 0) {
			            var total =  $(this).val();
			            $(this).css("background-color", "#FEFFB0");
			        }
			        else if (this.value.length != 0){
			            $(this).css("background-color", "red");
			        }
			    });
				$(".thanhtien_edit").each(function() {
			        if (!isNaN(this.value) && this.value.length != 0) {
			            sum += parseFloat(this.value);
			        }
			        
			    });

				$("#duyet_total_edit").val(sum);
		    });

        }
    });
});

$('.show_duyet').click(function () {
    var user = '{!! auth()->user()->id !!}';
    if ($(this).data('loai') == 2) {
    	if(user == 1 || user == 47 || user == 48 || user == 49){
    		$('.turn_status').removeClass('hidden');
    	}else{
    		$('.turn_status').addClass('hidden');
    	}
    }
    if ($(this).data('loai') == 3) {
    	if(user == 1 || user == 3){
    		$('.turn_status').removeClass('hidden');
    	}else{
    		$('.turn_status').addClass('hidden');
    	}
    }
	$('#id_comment').val($(this).data('id'));
	$('#loai').val($(this).data('loai'));
    $.ajax({
        url:"/showComment",
        type:'post',
        data: {
            id : $(this).data('id'),
        },
        success:function(data){
            var res = '';
            $.each (data.comment, function (key, value) {
                res +=
                '<div class="card-footer card-comments"><div class="card-comment"><img class="img-circle img-sm" src="'+value.avatar+'"><div class="comment-text"><span class="username">'
                    +value.name+'<span class="text-muted float-right">2 giờ trước</span></span>'+value.content+'</div></div>';
                $('.box-chat .card').html(res);
            });	       
        }
    });
});

$('.close-duyet').click(function () {
	var res = '';
	$('.box-chat .card').html(res);
});	

$('.close_data').click(function () {
	$('.show_image a').remove();
});	

$('.submit_comment').click(function () {
    $.ajax({
        url:"/addComment",
        type:'post',
        data: {
            id : $('#id_comment').val(),
            content : $('.form_comment').val(),
        },
        success:function(data){
            res =
            '<div class="card-footer card-comments"><div class="card-comment"><img class="img-circle img-sm" src="'+data.info.avatar+'"><div class="comment-text"><span class="username">'
                +data.user+'<span class="text-muted float-right">2 giờ trước</span></span>'+data.content+'</div></div>';
            $('.box-chat .card').append(res);
            $('.form_comment').val('');
        }
    });
});



$('.submit_cp').click(function(){
    $.ajax({
        type: 'post',
        url: '/mediaCP',
        data:  new FormData($("#data-chiphi")[0]),
        dataType:'json', 
        async:false, 
        processData: false, 
        contentType: false, 
        success: function(data){
            var res = '';
            $('.show_image img').remove();
            $.each (data.image, function (key, value) {
                res += '<img src="'+value.link+'" width="180">';
                $('.show_image').html(res);
            });
        }
    })
})

$('.duyet_chiphi').click(function () {
    $.ajax({
        url:"/duyetChiPhi",
        type:'post',
        data: {
        	id : $('#id_comment').val(),
            loai : $('#loai').val(),
        },
        success:function(data){
        	$.bootstrapGrowl(data.message, { type: 'success' });
            setTimeout(function(){
	           window.location.reload(); 
			}, 200); 
        }
    });
});

$('.khongduyet_chiphi').click(function () {
    $.ajax({
        url:"/khongduyetChiPhi",
        type:'post',
        data: {
        	id : $('#id_comment').val(),
        },
        success:function(data){
        	$.bootstrapGrowl(data.message, { type: 'success' });
            setTimeout(function(){
	           window.location.reload(); 
			}, 200); 
        }
    });
});


$(function() {
  $('input[name="daterange"]').daterangepicker({
  	locale: {
        format: "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Đồng Ý",
        "cancelLabel": "Hủy",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "Hai",
            "Ba",
            "Tư",
            "Năm",
            "Sáu",
            "Bảy",
            "Chủ Nhật"
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
    console.log(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>
@endsection
