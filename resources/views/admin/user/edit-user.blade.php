@extends("app")
@section("css")
<link rel="stylesheet" href="{{asset('js/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-duallistbox.css')}}">
<script src="{{asset('js/jquery.bootstrap-duallistbox.min.js')}}"></script>
@endsection
@section("content")
    <div >
    	<div class="col-md-6">
			<label>Họ và Tên</label>
            <input type="hidden" class="form-control" id="id" value="{{$id}}">
    		<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" placeholder="Name" id="name" value="{{$user->name}}">
			</div>
    	</div>
    	<div class="col-md-6">
			<label>Email</label>
    		<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control" placeholder="Email" id="email" value="{{$user->email}}">
			</div>
    	</div>
    	<div class="col-md-4">
            <label>PassWord</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="password" class="form-control" placeholder="Password" id="password">
            </div>
        </div>
        <div class="col-md-4">
            <label>PassWord Again</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="password" class="form-control" placeholder="Nhập lại password" id="passwordAgain">
            </div>
        </div>
        <div class="col-md-2">
            <label>Ngày Vào</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control" placeholder="Ngày Vào Công Ty" id="start" value="{{date('d-m-Y',strtotime($user->start_work))}}">
            </div>
        </div>
        <div class="col-md-2">
            <label>Ngày Nghỉ</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control" placeholder="Ngày Nghỉ" id="end" value="{{date('d-m-Y',strtotime($user->end_work))}}">
            </div>
        </div>
        <div class="col-md-6">
            <label>Username</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" placeholder="Username" id="username" value="{{$user->username}}">
            </div>
        </div>
    	<div class="col-md-6">
    		<div class="form-group">
                <label>	Quyền </label>
                <select class="form-control select2" id="roles">
                	@foreach($roles as $value)
						<option value="{{$value->id}}" @if($userRole == $value->name) selected="selected" @endif>{{$value->name}}</option>
					@endforeach
                </select>
              </div>
    	</div>
        <div class="col-md-2">
            <label>Chứng Minh Thư</label>
            <input type="text" class="form-control" placeholder="Chứng minh thư" name="cmt" id="cmt" value="{{$user->cmt}}">
        </div>
        <div class="col-md-2">
            <label>Nơi Cấp</label>
            <input type="text" class="form-control" placeholder="Nơi Cấp" id="noicap" value="{{$user->address_cmt}}">
        </div>
        <div class="col-md-2">
            <label>Ngày Cấp</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control" placeholder="Ngày Cấp" id="ngaycap" value="{{date('d-m-Y',strtotime($user->date_cmt))}}">
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <label>Giới Tính</label>
                <div class="radio">
                    <label><input type="radio" name="sex" @if($user->sex == 0) checked @endif value="0">Nam</label>
                    <label><input type="radio" name="sex" @if($user->sex == 1) checked @endif value="1">Nữ</label>
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <label>Dân Tộc</label>
                <div class="radio">
                    <label><input type="radio" name="dantoc" @if($user->dantoc == 0) checked @endif value="0">Không</label>
                    <label><input type="radio" name="dantoc" @if($user->dantoc == 0) checked @endif value="1" value="1">Có</label>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <label>Ngày Sinh</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control" placeholder="Ngày Sinh" id="birth" value="{{date('d-m-Y',strtotime($user->birthday))}}">
            </div>
        </div>
        
        <div class="col-md-12">
            <label>Địa Chỉ Thường Trú</label>
            <input type="text" class="form-control" placeholder="Địa Chỉ Thường Trú" id="dctt" value="{{$user->address_tt}}">
        </div>
        <div class="col-md-12">
            <label>Địa Chỉ Tạm Trú</label>
            <input type="text" class="form-control" placeholder="Địa Chỉ Tạm Trú" id="dcnow" value="{{$user->address_now}}">
        </div>
    	<div class="col-md-12">
    		<div class="form-group">
		    <select multiple="multiple" size="10" name="duallistbox_demo1[]" id="permission">
				@foreach($permission as $value)
                    {{$selected = in_array( $value->name, $selected_p ) ? ' selected="selected" ' : ''}}    
					   <option value="{{$value->id}}" {{$selected}}>{{$value->name}}</option>
				@endforeach
		    </select>
			</div>
    	</div>
    </div>
    <div class="pull-right">
    	<a href="#" onclick="editUser()" class="btn btn-success">Lưu</a>
    </div>
@endsection

@section('js')
<script src="{{asset('js/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('js/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('js/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">
    var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox();
    $('#ngaycap').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    $('#birth').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    $('#start').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    $('#end').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
	$('.select2').select2();
	function editUser() {
		var editUser= '{{ route("editUser") }}';
	    $.ajax({
	        data: {
	            name: $('#name').val(),
                username: $('#username').val(),
	            email  : $('#email').val(),
	            password: $('#password').val(),
	            passwordAgain  : $('#passwordAgain').val(),
	            roles  : $('#roles').val(),
                permission : $('#permission').val(),
                id : $('#id').val(),

                birth : $('#birth').val(),
                dcnow : $('#dcnow').val(),
                dctt : $('#dctt').val(),
                ngaycap : $('#ngaycap').val(),
                noicap : $('#noicap').val(),
                cmt : $('#cmt').val(),
                sex : $('input[name=sex]:checked').val(),
                dantoc : $('input[name=dantoc]:checked').val(),
                start : $('#start').val(),
                end : $('#end').val(),
	        },
	        url: editUser,
	        type: 'POST',
	        success: function(data) {
	        	if(data.status === true) {
					$.bootstrapGrowl(data.message, { type: 'success' });
		            setTimeout(function(){
			           window.location.href = '/user'; 
					}, 200); 
	        	}
	        },
	    });
	}
</script>
@endsection
