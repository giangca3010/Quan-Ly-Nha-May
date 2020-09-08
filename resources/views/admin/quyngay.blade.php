@extends("app")
@section('css')
<link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
@endsection
@section("content")
	<div class="col-md-6">
    	<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lich">
    		<span class="glyphicon glyphicon-plus"></span> Action
    	</a>
    </div>
	<div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <input type="text" name="datetimes" class="form-control" placeholder="Ngày Nghỉ" id="datetimes">
        </div>
	</div>
	<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
	    <div class="row"></div>
	    <div class="row">
	        <div class="col-sm-12">
	            <table id="quyngay_new" class="table table-bordered dataTable" role="grid" aria-describedby="example1_info">
	                <thead>
	                    <tr role="row">
	                        <th class="sorting hidden" tabindex="0" aria-controls="quyngay_new" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">id</th>
	                        <th>Ngày</th>
	                        @foreach($congdoan as $cd)
	                        <th colspan="3" >{{$cd->name}}</th>
	                        @endforeach
	                        <th class="hidden">Thao Tác</th>
	                    </tr>
	                </thead>
	                <tbody>
	                		@foreach($group as $key => $g)
		                	<tr role="row" class="odd {{App\Common::checkdatenow($key)}}" rowspan="2">
		                		<td class="hidden"></td>
		                		<td class="sorting_1" >{{ \Carbon\Carbon::parse($key)->format('l d-m-Y') }} </td>
		                		@foreach($g as $k => $time)
		                        <td>
		                        	<p>
		                        		<a type="button" class="showdata" data-toggle="{{App\Common::checkdate($key,$time->start_am)}}" data-target="#modal-qn" data-time='{{$time->start_am}}' data-name-id="{{$time->id}}" data-date="{{$key}}" data-pos="1">
		                        			{{date('H:i',strtotime($time->start_am))}}
		                        		</a>
	                        		</p>
		                        	<p>
		                        		<a type="button" class="showdata" data-toggle="{{App\Common::checkdate($key,$time->start_pm)}}" data-target="#modal-qn" data-time='{{$time->start_pm}}' data-name-id="{{$time->id}}" data-date="{{$key}}" data-pos="2">
		                        			{{date('H:i',strtotime($time->start_pm))}}
		                        		</a>
	                        		</p>
		                        	<p>
		                        		<a type="button" class="showdata" data-toggle="{{App\Common::checkdate($key,$time->start_up)}}" data-target="#modal-qn" data-time='{{$time->start_up}}' data-name-id="{{$time->id}}" data-date="{{$key}}" data-pos="3">
		                        			{{date('H:i',strtotime($time->start_up))}}
		                        		</a>
	                        		</p>
		                        </td>
		                        <td>
		                        	<p>
		                        		<a type="button" class="showdata" data-toggle="{{App\Common::checkdate($key,$time->end_am)}}" data-target="#modal-qn" data-time='{{$time->end_am}}' data-name-id="{{$time->id}}" data-date="{{$key}}" data-pos="4">
		                        			{{date('H:i',strtotime($time->end_am))}}
		                        		</a>
	                        		</p>
	                        		<p>
	                        			<a type="button" class="showdata" data-toggle="{{App\Common::checkdate($key,$time->end_pm)}}" data-target="#modal-qn" data-time='{{$time->end_pm}}' data-name-id="{{$time->id}}" data-date="{{$key}}" data-pos="5">
	                        				{{date('H:i',strtotime($time->end_pm))}}
	                        			</a>
                        			</p>
		                        	<p>
		                        		<a type="button" class="showdata" data-toggle="{{App\Common::checkdate($key,$time->end_up)}}" data-target="#modal-qn" data-time='{{$time->end_up}}' data-name-id="{{$time->id}}" data-date="{{$key}}" data-pos="6">
		                        			{{date('H:i',strtotime($time->end_up))}}
		                        		</a>
	                        		</p>
		                        </td>
		                        <td>
		                        	<p>
	                        			{{date('H:i',( \App\Common::time_work($time->start_am,$time->end_am)))}}
	                        		</p>
		                        	<p>
	                        			{{date('H:i',( \App\Common::time_work($time->start_pm,$time->end_pm)))}}
	                        		</p>
		                        	<p>
	                        			{{date('H:i',( \App\Common::time_work($time->start_up,$time->end_up)))}}
	                        		</p>
		                        </td>
		                        @endforeach
		                        <td class="hidden"></td>
		                	</tr>
	                    @endforeach
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="modal-qn">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Ngày: <span></span> </h4>
	            </div>
	            <div class="modal-body">
	                <div class="bootstrap-timepicker">
	                	<div class="form-group col-md-12">
	                		<label>Tích <input type="checkbox" name="r3" class="flat-red"  id="check"> nếu muốn thay đổi toàn bộ các công đoạn khác</label><br/>
							
	                	</div>
					    <div class="form-group col-md-12">
					        <label>Sửa:</label>
					        <div class="input-group">
					        	<input type="hidden" class="form-control" id="name_id">
					        	<input type="hidden" class="form-control" id="date">
					            <input type="hidden" class="form-control" id="pos">
					            <input type="text" class="form-control" id="time">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					        </div>
					    </div>
					</div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="changeTime()"  type="button" class="btn btn-primary">Lưu</a>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="modal-lich">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Action Qũy Ngày</h4>
	            </div>
	            <div class="modal-body">
					<div class="box-body">
					    <div class="form-group col-md-12">
					        <label>Date:</label>
					        <div class="input-group date ">
					            <div class="input-group-addon">
					                <i class="fa fa-calendar"></i>
					            </div>
					            <input type="text" class="form-control pull-right" id="datepicker">
					        </div>
    					</div>
				        <div class="col-md-12"><label>Sáng</label></div>
    					<div class="form-group col-md-6">
					        <div class="input-group">
					            <input type="text" class="form-control timepicker" id="start_am_add">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					        </div>
					    </div>
					    <div class="form-group col-md-6">
					        <div class="input-group">
					            <input type="text" class="form-control timepicker" id="end_am_add">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					        </div>
					    </div>
				        <div class="col-md-12"><label>Chiều</label></div>
					    <div class="form-group col-md-6">
					        <div class="input-group">
					            <input type="text" class="form-control timepicker" id="start_pm_add">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					        </div>
					    </div>
					    <div class="form-group col-md-6">
					        <div class="input-group">
					            <input type="text" class="form-control timepicker" id="end_pm_add">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					        </div>
					    </div>
					    <div class="col-md-12"><label>Tăng Ca</label></div>
					    <div class="form-group col-md-6">
					        <div class="input-group">
					            <input type="text" class="form-control timepicker" id="start_up_add" value="19:00">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					        </div>
					    </div>
					    <div class="form-group col-md-6">
					        <div class="input-group">
					            <input type="text" class="form-control timepicker" id="end_up_add" value="19:00">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					        </div>
					    </div>
    				</div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="addtime()"  type="button" class="btn btn-primary">Lưu</a>
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
<script>
	$(function() {
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
		$('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
			var time    = $('input[name="datetimes"]').val();
			var fillter = '{{ route("fillter") }}';
		    $.ajax({
		        data: {
		            range : time,
		        },
		        url: fillter,
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
	});
	$(function () {
	    $('#quyngay_new').DataTable({
			'paging'      : true,
			'lengthChange': true,
			'searching'   : true,
			'ordering'    : true,
			'info'        : true,
			'autoWidth'   : false,
			'lengthMenu'  : [[7, 14, 50, -1], [7, 14, 50, "All"]]
	    })
	})
	$('#datepicker').datepicker({
		autoclose: true,
		format: 'dd-mm-yyyy'
    });
    $('.showdata').click(function(){
    	$('#pos').val($(this).data('pos'));
    	$('#date').val($(this).data('date'));
        $('#name_id').val($(this).data('name-id'));
        $('#time').val($(this).data('time'));
        $(".modal-title span").text($(this).data('date'));
    });
    function changeTime() {
		var updatetimenew= '{{ route("updatetimenew") }}';
	    $.ajax({
	        data: {
	            pos: $('#pos').val(),
	            name_id  : $('#name_id').val(),
	            time: $('#time').val(),
	            date  : $('#date').val(),
	            check: $("#check").prop("checked")
	        },
	        url: updatetimenew,
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
	function addtime() {
		var addtime= '{{ route("addtimenew") }}';
	    $.ajax({
	        data: {
	            start_am: $('#start_am_add').val(),
	            end_am  : $('#end_am_add').val(),
	            start_pm: $('#start_pm_add').val(),
	            end_pm  : $('#end_pm_add').val(),
	            start_up: $('#start_up_add').val(),
	            end_up  : $('#end_up_add').val(),
	            date    : $('#datepicker').val(),
	        },
	        url: addtime,
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