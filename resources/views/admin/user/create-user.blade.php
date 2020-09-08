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
    		<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" placeholder="Name" id="name">
			</div>
    	</div>
    	<div class="col-md-6">
			<label>Email</label>
    		<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control" placeholder="Email" id="email">
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
                <input type="text" class="form-control" placeholder="Ngày Vào Công Ty" id="start">
            </div>
        </div>
        <div class="col-md-2">
            <label>Ngày Nghỉ</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control" placeholder="Ngày Nghỉ" id="end">
            </div>
        </div>
    	<div class="col-md-6">
            <label>Username</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" placeholder="Username" id="username">
            </div>
        </div>
    	<div class="col-md-6">
            <label>	Quyền </label>
    		<div class="form-group">
                <select class="form-control select2" id="roles">
                	@foreach($role as $value)
						<option value="{{$value->id}}">{{$value->name}}</option>
					@endforeach
                </select>
              </div>
    	</div>
        <div class="col-md-2">
            <label>Chứng Minh Thư</label>
            <input type="text" class="form-control" placeholder="Chứng minh thư" name="cmt" id="cmt">
        </div>
        <div class="col-md-2">
            <label>Nơi Cấp</label>
            <input type="text" class="form-control" placeholder="Nơi Cấp" id="noicap">
        </div>
        <div class="col-md-2">
            <label>Ngày Cấp</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control" placeholder="Ngày Cấp" id="ngaycap">
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <label>Giới Tính</label>
                <div class="radio">
                    <label><input type="radio" name="sex" checked value="0">Nam</label>
                    <label><input type="radio" name="sex" value="1">Nữ</label>
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <label>Dân Tộc</label>
                <div class="radio">
                    <label><input type="radio" name="dantoc" checked value="0">Không</label>
                    <label><input type="radio" name="dantoc" value="1">Có</label>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <label>Ngày Sinh</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control" placeholder="Ngày Sinh" id="birth">
            </div>
        </div>
        
        <div class="col-md-12">
            <label>Địa Chỉ Thường Trú</label>
            <input type="text" class="form-control" placeholder="Địa Chỉ Thường Trú" id="dctt">
        </div>
        <div class="col-md-12">
            <label>Địa Chỉ Tạm Trú</label>
            <input type="text" class="form-control" placeholder="Địa Chỉ Tạm Trú" id="dcnow">
        </div>
    	<div class="col-md-12">
    		<div class="form-group">
		    <select multiple="multiple" size="10" name="duallistbox_demo1[]" id="permission">
				@foreach($permission as $value)
					<option value="{{$value->id}}">{{$value->name}}</option>
				@endforeach
		    </select>
			</div>
    	</div>
    </div>
    <div class="pull-right">
    	<a href="#" onclick="addUser()" class="btn btn-success">Lưu</a>
    </div>
@endsection

@section('js')
<script src="{{asset('js/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('js/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('js/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">
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
    var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox();

	$('.select2').select2();
	function addUser() {
		var addUser= '{{ route("addUser") }}';
	    $.ajax({
	        data: {
	            name: $('#name').val(),
	            username: $('#username').val(),
	            email  : $('#email').val(),
	            password: $('#password').val(),
	            passwordAgain  : $('#passwordAgain').val(),
	            roles  : $('#roles').val(),
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
	        url: addUser,
	        type: 'POST',
	        success: function(data) {
	        	if(data.status === true) {
					$.bootstrapGrowl(data.message, { type: 'success' });
		            setTimeout(function(){
			           window.location.href = 'user'; 
					}, 200); 
	        	}
	        },
	    });
	}
</script>
@endsection
