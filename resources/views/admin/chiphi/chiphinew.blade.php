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
		<a type="button" class="btn btn-default" data-toggle="modal" data-target="#add"><span class="glyphicon glyphicon-plus"></span> Thêm </a>
	</div>
	
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
	                	<div class="hidden">{{$sttdx = 1}} {{$stttw = 1}}</div>
	                	@foreach($chiphi as $key => $item)
		                	<tr role="row" class="odd">
		                		<td class="sorting_1">
		                			@if($item->type == 0)
		                				TU{{$sttdx}}
	                				@else
	                					CP{{$stttw}}
	                				@endif
		                		</td>
		                		<td class="sorting_1"><a type="button" class="show_data" data-toggle="modal" data-target="#show_data" data-name="{{$item->name}}" data-id="{{$item->id_cp}}">{{$item->name_dx}}</a></td>
		                		<td class="sorting_1"><a type="button" class="show_duyet" data-toggle="modal" data-target="#show_duyet" data-id="{{$item->id_cp}}" data-loai="2">{{$item->name}}</a></td>
		                		<td class="sorting_1">
		                			<a type="button" class="timeline" data-toggle="modal" data-target="#timeline" data-id="{{$item->id_cp}}">{{number_format($item->total)}}</a>
		                		</td>
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
		                        		@if($item->user_create == $user_id || $item->user_dx == $user_id)
			                        		<a href="/sendchiphi/{{$item->id_cp}}">{{$item->tra_lai == 1 ? 'Trả Lại' : ''}} Chờ Gửi</a>
		                        		@else
				                        	{{$item->tra_lai == 1 ? 'Trả Lại' : ''}} Chờ gửi
			                        	@endif
		                        	@elseif($item->status_duyet == 1)
		                        		@if($item->user_check == $user_id)
			                        		<a href="/sendchiphil2/{{$item->id_cp}}">{{$item->tra_lai == 1 ? 'Trả Lại' : ''}} Gửi Duyệt</a>
		                        		@else
				                        	{{$item->tra_lai == 1 ? 'Trả Lại' : ''}} Gửi Duyệt
			                        	@endif
		                			@elseif($item->status_duyet == 2)
		                				@if($item->user_duyet == $user_id)
			                				<a type="button" class="show_duyet" data-toggle="modal" data-target="#show_duyet" data-id="{{$item->id_cp}}" data-loai="3" data-user="{{$item->user_duyet}}">{{$item->tra_lai == 1 ? 'Trả Lại' : ''}} Chờ Duyệt</a>
		                        		@else
				                        	{{$item->tra_lai == 1 ? 'Trả Lại' : ''}} Chờ Duyệt
			                        	@endif
	                				@elseif($item->status_duyet == 3)
		                				<a type="button" class="show_duyet" data-toggle="modal" data-target="#show_duyet" data-id="{{$item->id_cp}}" data-loai="4">Kế Toán Duyệt</a>
	                				@elseif($item->status_duyet == 4)
		                				<a type="button" class="show_duyet" data-toggle="modal" data-target="#show_duyet" data-id="{{$item->id_cp}}" data-loai="5" data-du="{{$item->bank_status}}" data-idtamung="{{$item->id_tu}}">Duyệt</a>
	                				@elseif($item->status_duyet == 6)
	                					Hoàn Thành
	                				@else
	                					Đã Duyệt
		                			@endif
		                        </td>
		                        <td class="sorting_1">
		                        	@if($item->status_duyet == 0)
		                        		@if($item->user_create == $user_id || $item->user_dx == $user_id)
			                        		<a type="button" class="edit" data-toggle="modal" data-target="#edit" data-name="{{$item->name}}" data-id="{{$item->id_cp}}">
				                        		<span class="fa fa-edit"></span>
				                        	</a>
				                        	<a href="{{asset('destroychiphi').'/'.$item->id_cp}}">
				                        		<span class="fa fa-trash"></span>
				                        	</a>
			                        	@endif
		                        	@elseif($item->status_duyet == 1 && $user_id == $item->user_check) 
		                        		@if($item->total == 0)
			                        	<a type="button" class="add_check" data-toggle="modal" data-target="#add_check" data-name="{{$item->name}}" data-id="{{$item->id_cp}}">
			                        		<span class="fa fa-plus"></span>
			                        	</a>
			                        	@else
			                        	<a type="button" class="edit_check" data-toggle="modal" data-target="#edit_check" data-name="{{$item->name}}" data-id="{{$item->id_cp}}">
			                        		<span class="fa fa-edit"></span>
			                        	</a>
			                        	@endif
		                        	@elseif($item->status_duyet == 5)
		                        		@if(Auth::user()->id == 1 || Auth::user()->id == 47 || Auth::user()->id == 48 || Auth::user()->id == 49)
				                        	<a type="button" class="add_bank" data-toggle="modal" data-target="#add_bank" data-id="{{$item->id_cp}}">
				                        		<span class="fa fa-edit"></span>
				                        	</a>
			                        	@endif
		                        	@elseif($item->status_duyet == 6 && $item->type == 0 && $item->id_tu == 0)
		                        		@if(Auth::user()->id == 1 || Auth::user()->id == 47 || Auth::user()->id == 48 || Auth::user()->id == 49)
		                					<a type="button" class="edit_duyet" data-toggle="modal" data-target="#edit_duyet" data-name="{{$item->name}}" data-id="{{$item->id_cp}}">
				                        		<span class="fa fa-edit"></span>
				                        	</a>
		                				@endif
		                        	@endif
		                        </td>
		                    </tr>
		                    <div class="hidden">
		                    	@if($item->type == 0)
		                			{{$sttdx += 1}}
                				@else
                					{{$stttw += 1}}
                				@endif
		                	</div>
	                    @endforeach
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>

	<!-- add  -->
	<div class="modal fade" id="add">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title">Chi Phí</h4>
	            </div>
            	<form action="{{ url('addChiPhi') }}"  method="post" enctype="multipart/form-data">
		            <div class="modal-body">
	            		@csrf
		            	<div class="form-group col-md-12">
					        <label>Đề Xuất:</label>
				            <input type="text" class="form-control" name="name" id="dexuat" placeholder="Nhập đề xuất / tạm ứng..." >
					    </div>
		            	<div class="form-group col-md-3">
					        <label>Nhân Viên Đề Xuất:</label>
				            <select id="user_dx" class="form-control select2 select2-hidden-accessible" name="user_dx" data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;">
				            	<option></option>
				            	@foreach($nhanvien as $item)
							    <option value="{{$item->id}}">{{$item->name}}</option>
							    @endforeach
							</select>
					    </div>
					    <div class="form-group col-md-3">
					        <label>Nhân Viên Nhận Tiền:</label>
				            <select id="user_check" name="user_check" class="form-control select2 select2-hidden-accessible"  data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;">
				            	<option></option>
				            	@foreach($nhanvienNT as $item)
							    <option value="{{$item->id}}">{{$item->name}}</option>
							    @endforeach
							</select>
					    </div>
					    <div class="form-group col-md-3">
					        <label>Người Duyệt:</label>
				            <select id="user_duyet" class="form-control select2 select2-hidden-accessible" name="user_duyet" data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;">
				            	<option></option>
				            	@foreach($nhanvien as $item)
							    <option value="{{$item->id}}">{{$item->name}}</option>
							    @endforeach
							</select>
					    </div>
					    <div class="form-group col-md-3">
					        <label>Bộ Phận:</label>
				            <select id="role_dx" name="role_dx" class="form-control select2 select2-hidden-accessible"  data-placeholder="Ấn lần 2 để bỏ chọn" style="width: 100%;">
				            	<option></option>
				            	@foreach($role as $value)
						    	<option value="{{$value->id}}">{{$value->name}}</option>
						    	@endforeach
							</select>
					    </div>
					    <div class="form-group col-md-6">
					        <label>Thời gian cần:</label>
			                <span class='input-group date' id='need_date'>
			                    <input type='text' class="form-control" name="date_need" id='date_need'/>
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                </span>
					    </div>
					    <div class="form-group col-md-6">
					        <label>Thời gian xuất tiền:</label>
			                <span class='input-group date' id='money_date'>
			                    <input type='text' class="form-control" id='date_money' name="date_money" />
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                </span>
					    </div>
					    
					    <div class="form-group col-md-3">
					    	<label>Tạm Ứng <input type="checkbox" name="checkbox" id="checkbox"></label>
					    </div>

					    <div class="form-group col-md-4">
					        <label>Tình Trạng:</label>
				            <select id="status" style="width: 100%;" name="status">
							    <option vlaue="0"></option>
							    <option value="1">Khẩn Cấp</option>
							    <option value="2">Ưu Tiên</option>
							    <option value="3">Chờ</option>
							 </select>
					    </div>
					    <div class="form-group col-md-5">
					        <label>Loại Chi Phí:</label>
				            <select id="loaichiphi" style="width: 100%;" name="loaichiphi">
				            	<option></option>
				            	@foreach($loaichiphi as $item)
							    <option value="{{$item->id}}">{{$item->name_lcp}}</option>
							    @endforeach
							 </select>
					    </div>
					    
					    <div class="form-group col-md-12">
					        <label>Mục Đích:</label>
				            <textarea  rows="4" cols="50" type="text" class="form-control" id="chuy" name="chuy"></textarea > 
					    </div>
				        <div class="form-group col-md-12">
							<span class="control-fileupload">
								<label for="file">Chọn Tệp :</label>
                        		<input type="file" name="file[]" multiple="multiple">
							</span>
						</div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		                <button type="submit" class="btn btn-primary">Lưu</button>
		            </div>
	            </form>
	        </div>
	    </div>
	</div>

	<!-- edit -->
	<div class="modal fade" id="edit">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title">Sửa Chi Phí</h4>
	            </div>
	            <form action="{{ url('editChiPhi') }}"  method="post" enctype="multipart/form-data">
		            <div class="modal-body">
	            		@csrf
		            	<div class="form-group col-md-12">
					        <label>Đề Xuất:</label>
				            <input type="text" class="form-control" name="name" id="dexuat_edit" placeholder="Nhập đề xuất / tạm ứng...">
					    </div>
					    <div class="form-group col-md-3">
					        <label>Nhân Viên Đề Xuất:</label>
				            <select id="user_dx_edit" name="user_dx">
				            	<option></option>
				            	@foreach($nhanvien as $item)
							    <option value="{{$item->id}}">{{$item->name}}</option>
							    @endforeach
							</select>
					    </div>
					    <div class="form-group col-md-3">
					        <label>Nhân Viên Nhận Tiền:</label>
				            <select id="user_check_edit" name="user_check">
				            	<option></option>
				            	@foreach($nhanvienNT as $item)
							    <option value="{{$item->id}}">{{$item->name}}</option>
							    @endforeach
							</select>
					    </div>
					    <div class="form-group col-md-3">
					        <label>Người Duyệt:</label>
				            <select id="user_duyet_edit" name="user_duyet">
				            	<option></option>
				            	@foreach($nhanvien as $item)
							    <option value="{{$item->id}}">{{$item->name}}</option>
							    @endforeach
							</select>
					    </div>
					    <div class="form-group col-md-3">
					        <label>Bộ Phận:</label>
				            <select id="role_dx_edit" name="role_dx">
				            	<option></option>
				            	@foreach($role as $value)
						    	<option value="{{$value->id}}">{{$value->name}}</option>
						    	@endforeach
							</select>
					    </div>
					    <div class="form-group col-md-4">
					    	<label>Tạm Ứng <input type="checkbox" name="checkbox" id="checkbox_edit"></label>
					    </div>
					    <div class="form-group col-md-4">
					        <label>Thời gian cần:</label>
			                <span class='input-group date' id='need_date'>
			                    <input type='text' class="form-control" name="date_need" id='date_need_edit'/>
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                </span>
					    </div>
					    <div class="form-group col-md-4">
					        <label>Thời gian xuất tiền:</label>
			                <span class='input-group date' id='money_date'>
			                    <input type='text' class="form-control" name="date_money" id='date_money_edit'/>
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                </span>
					    </div>
					    <input type="hidden" name="id" id="edit_id">
					    <div class="form-group col-md-6">
					        <label>Loại Chi Phí:</label>
				            <select id="loaichiphi_edit" name="loaichiphi">
				            	<option></option>
				            	@foreach($loaichiphi as $item)
							    <option value="{{$item->id}}">{{$item->name_lcp}}</option>
							    @endforeach
							 </select>
					    </div>
					    <div class="form-group col-md-6">
					        <label>Tình Trạng:</label>
				            <select id="status_edit" name="status">
							    <option vlaue="0"></option>
							    <option value="1">Khẩn Cấp</option>
							    <option value="2">Ưu Tiên</option>
							    <option value="3">Chờ</option>
							 </select>
					    </div>

					    <div class="form-group col-md-12">
					        <label>Mục Đích:</label>
				            <textarea  rows="4" cols="50" type="text" class="form-control" id="chuy_edit" name="chuy"></textarea > 
					    </div>

					    <div class="form-group col-md-12">
							<span class="control-fileupload">
								<label for="file">Chọn Tệp :</label>
	                    		<input type="file" name="file[]" multiple="multiple">
							</span>
						</div>

						<div class="col-md-12">
							<div class="edit_image pull-left">
			            		
			            	</div>
						</div>
					</div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		                <button type="submit" class="btn btn-primary">Lưu</a>
		            </div>
	            </form>
	        </div>
	    </div>
	</div>

	<!-- showdata all -->
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
	            	<label>Mục Đích: <i id="chuy_show"> </i></label><br>
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
	            </div>
	        </div>
	    </div>
	</div>

	<!-- comment + duyet -->
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
				            	<input type="hidden" id="user">
					            <textarea placeholder="Nội dung bình luận" class="form_comment form-control form-control"></textarea>
					            <button class="btn btn-primary submit_comment">Gửi bình luận</button>
					        </div>
					    </div>
	            	</div>
	            </div>
	            <div class="modal-footer">
	            	<p class="duyet_lai hide">Duyệt <i class="number_status"></i> Lại Lần 2 Của Tạm Ứng <i class="id_tamung"></i></p>
	            	<div class="turn_status turn_stt hidden">
		            	<button class="duyet_chiphi">Duyệt</button>
		            	<button class="khongduyet_chiphi">Không Duyệt</button>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- thêm check info  -->
	<div class="modal fade" id="add_check" data-toggle="modal" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close close_data" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title">Chi Tiết Chi Phí <i id="name_stt"> </i></h4>
	            </div>
	            <div class="modal-body">
	            	<h4 class="name_dx_check"></h4>
	            	<label>Người đề xuất:</label><i id="name_check"> </i>
	            	<label class="pull-right">Bộ Phận: <i id="roles_check"></i></label><br>
	            	<label>Thời gian đề xuất: <i id="date_check"> </i></label><br>
	            	<label>Thời gian cần: <i id="date_need_check"> </i></label><br>
	            	<label>Thời gian xuất tiền: <i id="date_money_check"> </i></label><br>
	            	<label>Mục đích: <i id="chuy_check"> </i></label><br>
	            	<div class="form-group col-md-6">
				    	<a onclick="addInputToForm()">Thêm Chi Phí</a>
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
	            	<div class="form-group col-md-12">
					    <input type="hidden" name="id" id="add_check_id">
                    </div>	
	            	<div class="show_image_check pull-left">
	            		
	            	</div>
	            </div>
	            <div class="modal-footer">
	            	<div class="modal-footer">
		                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		                <a href="#" onclick="addcheck()"  type="button" class="btn btn-primary">Lưu</a>
		            </div>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- sửa check info  -->
	<div class="modal fade" id="edit_check">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title">Sửa Chi Phí <i id="name_stt_edit"> </i></h4>
	            </div>
	            <div class="modal-body addCreate">
	            	<h4 class="name_check_edit"></h4>
	            	<input type="hidden" id="id_check_edit">
	            	<label>Người đề xuất:</label><i id="name_check_edit"> </i>
	            	<label class="pull-right">Bộ Phận: <i id="roles_check_edit"></i></label><br>
	            	<label>Thời gian đề xuất: <i id="date_check_edit"> </i></label><br>
	            	<label>Thời gian cần: <i id="date_need_check_edit"> </i></label><br>
	            	<label>Thời gian xuất tiền: <i id="date_money_check_edit"> </i></label><br>
	            	<label>Mục Đích: <i id="chuy_check_edit"> </i></label><br>
	            	<div class="form-group col-md-6">
				    	<a onclick="addInputToForm()">Thêm Chi Phí</a>
				    </div>
				    <input type="hidden" id="edit_id_check">
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
				    	<input type="number" min="1" step="any" name="total" id='tamung_edit' pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$">
				    </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="editchiphi()"  type="button" class="btn btn-primary">Lưu</a>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- add bank -->
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

	<!-- convert chi phí -->
	<div class="modal fade" id="edit_duyet">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title">Tạm Ứng</h4>
	            </div>
	            <div class="modal-body addCreate">
	            	<div class="form-group col-md-12">
				        <label>Đề Xuất: <i class="duyet_edit_name_dx">	</i></label>
				    </div>
	            	<div class="form-group col-md-12">
				        <label>Nhân Viên: <i class="duyet_edit_name">	</i></label>
				        <label class="pull-right">Bộ Phận: <i id="roles_duyet"></i></label><br>
		            	<label>Thời gian đề xuất: <i id="date_duyet"> </i></label><br>
		            	<label>Thời gian cần: <i id="date_need_duyet"> </i></label><br>
		            	<label>Thời gian xuất tiền: <i id="date_money_duyet"> </i></label><br>
		            	<label>Mục Đích: <i id="duyet_chuy"> </i></label><br>
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
				    <div class="form-group col-md-6">
				    	<label>Tổng Tiền:</label>
				    	<input type="number" min="1" step="any" disabled="" name="total" id='duyet_total_edit' pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$">
				    </div>
				    <div class="form-group col-md-6">
				    	<label>Tạm Chi:</label>
				    	<input type="number" min="1" step="any" disabled="" name="tam_ung_covert" id='tam_ung_covert' pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$">
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

	<!-- timeline -->
	<div class="modal fade" id="timeline">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title">Timeline</h4>
	            </div>
	            <div class="modal-body">
	            	<div class="show-timeline">
	            		
	            	</div>
	            	
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
<script type="text/javascript">
$('#status,#loaichiphi,#user_check,#user_dx,#status_select,#item,#des,#roles_select,#role_dx,#user_duyet').select2();
$('#money_date,#need_date').datetimepicker();

//comment
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

//duyet
$('.show_duyet').click(function () {
    var user = '{!! auth()->user()->id !!}';
    var check = $(this).data('user');
    if ($(this).data('loai') == 3) {
    	if(user == check){
    		$('.turn_status').removeClass('hidden');
    	}else{
    		$('.turn_status').addClass('hidden');
    	}
    }
    if ($(this).data('loai') == 5) {
    	if(user == 1 || user == 3){
    		$('.turn_status').removeClass('hidden');
    	}else{
    		$('.turn_status').addClass('hidden');
    	}
    }
    if ($(this).data('loai') == 4) {
    	if(user == 1 || user == 47 || user == 48 || user == 49){
    		$('.turn_status').removeClass('hidden');
    	}else{
    		$('.turn_status').addClass('hidden');
    	}
    }
    if ($(this).data('du') != null && $(this).data('idtamung') > 0) {
		$('.duyet_lai').removeClass('hide');
    	if(user == 1 || user == 3){
    		if($(this).data('du') >= 0){
    			$('.number_status').text('Thu $' + $(this).data('du') );
    			$('.id_tamung').text($(this).data('idtamung'));
    		}else{
    			var text = $(this).data('du').toString();
    			$('.number_status').text('Chi $' + text.substr(1, 100) );
    			$('.id_tamung').text($(this).data('idtamung'));

    		}
    	}
    }
	$('#id_comment').val($(this).data('id'));
	$('#loai').val($(this).data('loai'));
	$('#user').val($(this).data('user'));
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

//show data edit của đề xuất
$('.edit').click(function () {
	$('#edit_id').val($(this).data('id'));
    $.ajax({
        url:"/showChiPhi",
        type:'post',
        data: {
            id : $(this).data('id'),
        },
        success:function(data){
            $('#dexuat_edit').val(data.chiphi.name_dx);
            $('#loaichiphi_edit').val(data.chiphi.id_phanloai).attr('selected','selected');
            $('#status_edit').val(data.chiphi.status).attr('selected','selected');
            $('#user_duyet_edit').val(data.chiphi.user_duyet).attr('selected','selected');
            $('#user_check_edit').val(data.chiphi.user_check).attr('selected','selected');
            $('#user_dx_edit').val(data.chiphi.user_dx).attr('selected','selected');
			$('#role_dx_edit').val(data.chiphi.role_id).attr('selected','selected');
            $('#date_need_edit').val(data.chiphi.date_need);
            $('#date_money_edit').val(data.chiphi.date_money);            
            $('#chuy_edit').val(data.chiphi.chuy);
            if (data.chiphi.type == 0) {
            	$('#checkbox_edit').attr('checked','checked');
            }
            var img = '';
            $.each (data.image, function (key, value) {
                img += '<a href="'+value.link+'" target="_blank"><img src="'+value.link+'" width="180" target="_blank"></a><a href="/deletemedia/'+value.id+'" style="position: relative;"><span class="fa fa-trash" style="position: absolute;left: -10px;"></span></a>';
                $('.edit_image').html(img);
            });
        }
    });
});

//show data cua check
$('.add_check').click(function () {
	$('#add_check_id').val($(this).data('id'));
    $.ajax({
        url:"/showChiPhi",
        type:'post',
        data: {
            id : $(this).data('id'),
        },
        success:function(data){
        	var role = '';
            $('#name_check').text(data.chiphi.name);
            // console.log(data.chiphi.type);
            if(data.chiphi.type == 0){
	            $('#name_stt').text('Tạm Ứng');
            }
            $('.name_dx_check').text(data.chiphi.name_dx);
            $('#date_check').text(data.chiphi.created_at);
            $('#date_need_check').text(data.chiphi.date_need);
            $('#date_money_check').text(data.chiphi.date_money);
            $('#chuy_check').text(data.chiphi.chuy);
            $.each (data.role[0].roles, function (key, value) {
                if(value.id > 6) {
                	role += value.name;
                }
                $('#roles_check').text(role);
            });
            var img = '';
            $.each (data.image, function (key, value) {
                img += '<a href="'+value.link+'" target="_blank"><img src="'+value.link+'" width="180" target="_blank"></a><a href="/deletemedia/'+value.id+'" style="position: relative;"><span class="fa fa-trash" style="position: absolute;left: -10px;"></span></a>';
                $('.show_image_check').html(img);
            });
        }
    });
});

// add line de xuat
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
		$(this).parent().parent().remove();
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

//tính toán đề xuất
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

//add check
function addcheck() {
	var addcheck= '{{ route("addcheck") }}';
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
            line : data,
            total : $('#total').val(),
            tamung : $("#tamung").val(),
            id : $("#add_check_id").val(),
        },
        url: addcheck,
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

//showdata all
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
            if(data.chiphi.total > 0){
	            $('#total_show').text(format(data.chiphi.total)+'/'+format(data.chiphi.total_thuc));
            }
            $('.name_dx_show').text(data.chiphi.name_dx);
            $('#date_show').text(data.chiphi.created_at);
            $('#date_need_show').text(data.chiphi.date_need);
            $('#date_money_show').text(data.chiphi.date_money);
            $('#chuy_show').text(data.chiphi.chuy);
        }
    });
});

//format number
function format(num) {
  return num.toString().replace(/^[+-]?\d+/, function(int) {
    return int.replace(/(\d)(?=(\d{3})+$)/g, '$1,');
  });
}

//edit check
$('.edit_check').click(function () {
	$('#roles_check_edit').val($(this).data('id'));
    $.ajax({
        url:"/showChiPhi",
        type:'post',
        data: {
            id : $(this).data('id'),
        },
        success:function(data){
        	var role = '';
            $.each (data.role[0].roles, function (key, value) {
                if(value.id > 6) {
                	role += value.name;
                }
                $('#roles_check_edit').text(role);
            });
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
            if(data.chiphi.type == 0){
	            $('#name_stt_edit').text('Tạm Ứng');
            }
            $('#lines_edit').append(res);
            $('#tamung_edit').val(data.chiphi.tam_ung);
            $('#total_edit').val(data.chiphi.total);
            $('#id_check_edit').val(data.chiphi.id_cp);
            $('.name_check_edit').text(data.chiphi.name_dx);
            $('#name_check_edit').text(data.chiphi.name);
            $('#date_check_edit').text(data.chiphi.created_at);
            $('#date_need_check_edit').text(data.chiphi.date_need);
            $('#date_money_check_edit').text(data.chiphi.date_money);            
            $('#chuy_check_edit').text(data.chiphi.chuy);
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

//button duyet
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

//button không duyệt
$('.khongduyet_chiphi').click(function () {
    $.ajax({
        url:"/khongduyetChiPhi",
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

//showbank
$('.add_bank').click(function () {
	$('#bank_id_cp').val($(this).data('id'));
});

//addbank
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

//convert chi phí
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
                '<td><input type="hidden" value="'+value.id+'">'+stt+'</td>'+
                '<td>'+value.ten+'</td>'+
                '<td>'+value.so_luong+'</td>'+
                '<td>'+value.donvi+'</td>'+
                '<td>'+value.money+'</td>'+
                '<td>'+value.giamgia+'</td>'+
                '<td>'+value.thanh_tien+'</td>'+
                '<td><input type="text" name="soluong" class="soluong_edit" style="width:25px" value="'+value.so_luong+'"></td>'+
                '<td><input type="text" name="gia" class="gia_edit" style="width:100px" value="'+value.money+'"></td>'+                
                '<td><input type="text" name="thanhtien" class="thanhtien_conver" style="width:100px" value="'+value.money_thucte+'"></td>'+
                '<td><input type="text" name="note" placeholder="Nhập nội dung" value="'+content+'"></td>';
            });
            $('#lines_duyet').append(res);
            $('.duyet_edit_name').text(data.chiphi.name);
            $('.duyet_edit_name_dx').text(data.chiphi.name_dx);
            $('.duyet_edit_lcp').text(data.chiphi.name_lcp);
            $('.duyet_chuy').text(data.chiphi.chuy);
            $('#duyet_total_edit').val(data.chiphi.total_thuc);
            var role = '';
            $.each (data.role[0].roles, function (key, value) {
                if(value.id > 6) {
                	role += value.name;
                }
                $('#roles_duyet').text(role);
            });

            $('.name_check_edit').text(data.chiphi.name_dx);
            $('#date_duyet').text(data.chiphi.created_at);
            $('#tam_ung_covert').val(data.chiphi.tam_ung);
            $('#date_need_duyet').text(data.chiphi.date_need);
            $('#date_money_duyet').text(data.chiphi.date_money); 
            if(data.chiphi.status == 1) {
            	$('.duyet_edit_status').text("Khẩn Cấp");
            }
            if(data.chiphi.status == 2) {
            	$('.duyet_edit_status').text("Ưu Tiên");
            }
            if(data.chiphi.status == 3) {
            	$('.duyet_edit_status').text("Chờ");
            }
            
		    $(".gia_edit").on("keydown keyup", function() {
		        var sum = 0;
			    $(".gia_edit").each(function() {
			        if (!isNaN(this.value) && this.value.length != 0) {
			            var total =   $(this).parent().prev().children().val()* $(this).val() - $(this).parent().prev().prev().prev().children().text();
			            $(this).css("background-color", "#FEFFB0");
			            $(this).parent().next().children().val(total);
			            console.log($(this).parent().prev().children().val()* $(this).val());
			        }
			        else if (this.value.length != 0){
			            $(this).css("background-color", "red");
			        }
			    });
				$(".thanhtien_conver").each(function() {
			        if (!isNaN(this.value) && this.value.length != 0) {
			            sum += parseFloat(this.value);
			        }
			        
			    });

				$("input#duyet_total_edit").val(sum);
            	$('input#tam_ung_covert').val(sum);

		    });

        }
    });
});

//copy duyệt chi phí
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

//show timeline
$('.timeline').click(function () {
	var id = $(this).data('id');
    $.get("/timeline/"+id,function(data){
    	console.log(data);
        $(".show-timeline").html(data);
    });
});

</script>
@endsection
