@extends("app")
@section('css')
<link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
@endsection
@section("content")
    <a type="button"  data-toggle="modal" data-target="#modal-lich"><span class="glyphicon glyphicon-plus"></span> Action</a>
    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
	    <div class="row"></div>
	    <div class="row">
	        <div class="col-sm-12">
	            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
	                <thead>
	                    <tr role="row">
	                        <th class="sorting_asc hidden" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >ID</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Ngày</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Ca Sáng</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Ca Chiều</th>
	                        <th>Thao Tác</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	@foreach($quyngay as $key=>$qn)
	                	<tr role="row" class="odd {{ ( \Carbon\Carbon::parse($qn->date)->format('l') == 'Sunday' ) ? 'bg-danger' : '' }}">
	                		<td class="sorting_1 hidden">{{ $key }}</td>
	                        <td class="sorting_1">{{ \Carbon\Carbon::parse($qn->date)->format('l d-m-Y') }}</td>
	                        <td>
	                        	<p>{{ ( \Carbon\Carbon::parse($qn->date)->format('l') == 'Sunday' ) ? 'Nghỉ' : date('H:i',strtotime($qn->start_am)).'-'.date('H:i',strtotime($qn->end_am)) }}</p>
	                        </td>
	                        <td>
	                        	<p>{{ ( \Carbon\Carbon::parse($qn->date)->format('l') == 'Sunday' ) ? 'Nghỉ' : date('H:i',strtotime($qn->start_pm)).'-'.date('H:i',strtotime($qn->end_pm)) }}</p>
	                        </td>
	                        <td>
	                        	<a class="showdata" type="button" data-toggle="modal" data-target="#modal-qn" data-start-am="{{$qn->start_am}}" data-start-pm="{{$qn->start_pm}}" data-end-am="{{$qn->end_am}}" data-end-pm="{{$qn->end_pm}}" data-date="{{$qn->date}}" data-id="{{$qn->id}}">
	                        		<span class="fa fa-edit"></span>
	                        	</a>
	                        </td>
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
	                <h4 class="modal-title">Sửa ngày: <span></span> </h4>
	            </div>
	            <div class="modal-body">
	                <div class="bootstrap-timepicker">
	                	<input type="hidden" id="id_qn">
					    <div class="form-group col-md-6">
					        <label>Buổi Sáng Bắt Đầu:</label>
					        <div class="input-group">
					            <input type="text" class="form-control timepicker" id="start_am">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					        </div>
					    </div>
					    <div class="form-group col-md-6">
					        <label>Buổi Sáng Nghỉ Trưa:</label>
					        <div class="input-group">
					            <input type="text" class="form-control timepicker" id="end_am">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					        </div>
					    </div>
					    <div class="form-group col-md-6">
					        <label>Buổi Chiều Bắt Đầu:</label>
					        <div class="input-group">
					            <input type="text" class="form-control timepicker" id="start_pm">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					        </div>
					    </div>
					    <div class="form-group col-md-6">
					        <label>Giờ Nghỉ:</label>
					        <div class="input-group">
					            <input type="text" class="form-control timepicker" id="end_pm">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					        </div>
					    </div>
					</div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="changeDate()"  type="button" class="btn btn-primary">Lưu</a>
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
    					<div class="form-group col-md-6">
					        <label>Buổi Sáng Bắt Đầu:</label>
					        <div class="input-group">
					            <input type="text" class="form-control timepicker" id="start_am_add">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					        </div>
					    </div>
					    <div class="form-group col-md-6">
					        <label>Buổi Sáng Nghỉ Trưa:</label>
					        <div class="input-group">
					            <input type="text" class="form-control timepicker" id="end_am_add">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					        </div>
					    </div>
					    <div class="form-group col-md-6">
					        <label>Buổi Chiều Bắt Đầu:</label>
					        <div class="input-group">
					            <input type="text" class="form-control timepicker" id="start_pm_add">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					        </div>
					    </div>
					    <div class="form-group col-md-6">
					        <label>Giờ Nghỉ:</label>
					        <div class="input-group">
					            <input type="text" class="form-control timepicker" id="end_pm_add">
					            <div class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					            </div>
					        </div>
					    </div>
    				</div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="addDate()"  type="button" class="btn btn-primary">Lưu</a>
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
	$('#datepicker').datepicker({
		autoclose: true,
		format: 'dd-mm-yyyy'
    });
	$('.timepicker').timepicker({ 
		showInputs: true, 
		showMeridian: false,
		'timeFormat': 'H:i'
	}).val('00:00');
    $('.showdata').click(function(){
        $('#start_am').val($(this).data('start-am'));
        $('#end_am').val($(this).data('end-am'));
        $('#start_pm').val($(this).data('start-pm'));
        $('#end_pm').val($(this).data('end-pm'));
        $(".modal-title span").text($(this).data('date'));
        $("#id_qn").val($(this).data('id'));
    });
    function changeDate() {
		var changeDate= '{{ route("changeDate") }}';
	    $.ajax({
	        data: {
	            start_am: $('#start_am').val(),
	            end_am  : $('#end_am').val(),
	            start_pm: $('#start_pm').val(),
	            end_pm  : $('#end_pm').val(),
	            id  : $('#id_qn').val(),
	        },
	        url: changeDate,
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
	function addDate() {
		var addDate= '{{ route("addtime") }}';
	    $.ajax({
	        data: {
	            start_am: $('#start_am_add').val(),
	            end_am  : $('#end_am_add').val(),
	            start_pm: $('#start_pm_add').val(),
	            end_pm  : $('#end_pm_add').val(),
	            date    : $('#datepicker').val(),
	        },
	        url: addDate,
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