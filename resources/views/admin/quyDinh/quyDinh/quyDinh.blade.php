@extends("app")
@section("css")
<link rel="stylesheet" href="{{asset('js/select2/dist/css/select2.min.css')}}">	
<link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
@endsection
@section("content")
<a href="{{asset('add-Quy-Dinh')}}" class="btn btn-success">Thêm</a>
<div class="row">
		<div class="col-md-6">
	        <div>
	            <select id="myState" class="form-control">
                    
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
	                        <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Tên Quy Định</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Quy Trình</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Bộ phận áp dụng</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Bộ Phận GS</th>
	                        <th>Thao tác</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<div class="hidden" >{{$stt = 1}}</div>
             		   	@foreach($QD as $key => $qdn)
             		   	<tr role="row" class="odd">
             		   		<td>{{$stt}}</td>
             		   		<td class="sorting_1">{{$qdn['quyDinh_name']}}</td>
             		   		<td class="sorting_1">{{$qdn['quyTrinh_id']}}</td>
             		   		<td class="sorting_1">
             		   			@foreach($qdn['boPhanAd'] as  $ad)
             		   				- {{$ad['name']}}<br>
             		   			@endforeach
             		   		</td>
             		   		<td class="sorting_1">
             		   			@foreach($qdn['boPhanGs'] as  $gs)
             		   				- {{$gs['name']}}<br>
             		   			@endforeach
             		   		</td>
             		   		<td class="sorting_1">
             		   			<a href="/edit-Quy-Dinh/{{$qdn['quyDinh_id']}}" type="button" class="edit_data">
									<span class="fa fa-edit"></span>
								</a>
								<a href="/delete-Quy-dinh/{{$qdn['quyDinh_id']}}" onclick="return confirm('Bạn muốn xóa mục này?')"  type="button" class="delete_data">
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