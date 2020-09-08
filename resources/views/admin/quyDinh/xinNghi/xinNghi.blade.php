@extends("app")
@section("css")
<link rel="stylesheet" href="{{asset('js/select2/dist/css/select2.min.css')}}">	
<link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
@endsection
@section("content")
	<a href="{{asset('themXinNghi')}}" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Thêm </a>
	<br>
	<br>
	<div class="row">
		<div class="col-md-6">
	        <div>
	            <select id="myState" class="form-control">
                    @foreach($dataUsers as $nv)
	                     <option value="{{($nv->id)}}">
	                        {{($nv->name)}}
	                     </option>
                  	@endforeach 
	          	</select>
	        </div>
		</div>
		<div class="col-md-6">
	        <div class="input-group">
	            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	            <input type="text" name="datetimes" class="form-control" placeholder="Ngày Nghỉ" id="datetimes">
	        </div>
		</div>
		
	</div>
	<br>
	<div class="row">
	        <div class="col-sm-12">
	            <table id="example2" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
	                <thead>
	                    <tr role="row">
	                    	<th>STT</th>
	                        <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Người tạo</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Phòng</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Thời gian</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Lý do</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Bàn giao</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Bắt đầu</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Kết thúc</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Chế độ</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Tình trạng</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Xem đơn</th>
	                        <th>Thao tác</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<div class="hidden">{{$stt = 1}}</div>
             		   	@foreach($XN as $key => $ct)
	                	<tr role="row" class="odd">	
	                		<td>{{$stt}}</td>
	                		<td class="sorting_1">{{$ct['user1']}}</td>
	                		<td class="sorting_1">{{$ct['id_roles']}}</td>
	                		<td class="sorting_1">{{$ct['ngayNghi']}} ngày</td>
	                		<td class="sorting_1">{{$ct['lyDo']}}</td>
	                		<td class="sorting_1">Bàn giao cho "{{$ct['user3']}}"</td>
	                		<td class="sorting_1">{{$ct['ngayXinNghi']}}</td>
	                		<td class="sorting_1">{{$ct['ketThucNgay']}}</td>
	                		<td class="sorting_1">
								<?php
                                    if($ct['trangThaiNghi']==5){
                                		echo("Không lương");
                                    }else if($ct['trangThaiNghi']==6){
                                    	echo("Chế độ");
                                    }else if($ct['trangThaiNghi']==7){
                                    	echo("Nghỉ việc");
                                	}
                                    ?>
	                		</td>
	                		<td class="sorting_1">
	                			@if($ct['login']==$ct['id_user1']&&$ct['status_xinNghi']==0)
		                			<a href="#" type="button" class="edit_data">
										<option value="0" class="fa fa-edit">Chờ xét duyệt</option>
									</a>
								@endif

								@if($ct['login']==$ct['id_user3']&&$ct['status_xinNghi']==0)
		                			<a style="color: green" href="/nhan-ban-giao/{{$ct['xinNghi_id']}}" type="button" class="edit_data">
										<option value="1" class="fa fa-edit">Nhận bàn giao</option>
									</a>
								@endif

								@if($ct['login']==$ct['id_user2']&&$ct['status_xinNghi']==1)
		                			<a style="color: red" href="/duyet-xin-nghi/{{$ct['xinNghi_id']}}" type="button" class="edit_data">
										<option value="2" class="fa fa-edit">Duyệt xin nghỉ</option>
									</a>
								@endif
								@if($ct['login']==$ct['id_user1']&&$ct['status_xinNghi']==2)
									Đã duyệt đơn
								@endif
									
	                		</td>
	                		<td class="sorting_1">{{$ct['user2']}}</td>
	                		<td class="sorting_1">
                				@if($ct['login']==$ct['id_user1']&&$ct['status_xinNghi']==0)
		                			<a href="/editXinNghi/{{$ct['xinNghi_id']}}" type="button" class="edit_data">
										<span class="fa fa-edit"></span>
									</a>
									<a onclick="return confirm('Bạn muốn xóa mục này?')" href="/deleteXinNghi/{{$ct['xinNghi_id']}}" type="button" class="delete_data">
										<span class="fa fa-trash"></span>
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
<script>
	
		$('input[name="datetimes"]').daterangepicker({
			// timePicker: true,
			startDate: moment().startOf('isoWeek'),
			endDate: moment().endOf('isoWeek'),
			locale: {
				format: 'D/M/Y'
			},
			ranges: {
		        'Today': [moment(), moment()],
		        'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
		        'Last 7 Days': [moment().subtract('days', 6), moment()],
		        'Last 30 Days': [moment().subtract('days', 29), moment()],
		        'This Month': [moment().startOf('month'), moment().endOf('month')],
		        'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
		    },
		});
		  $(function () {
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>

@endsection