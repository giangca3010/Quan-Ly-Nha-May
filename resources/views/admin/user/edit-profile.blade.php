@extends("app")
@section("content")
<section class="content">

    <div class="row">
    	<div class="alert" id="message" style="display: none"></div>
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                	<form id="data-form" method="post" enctype="multipart/form-data">
	                    <img class="profile-user-img img-responsive img-circle" src="{{asset($info['avatar'])}}" id="image-trigger" alt="User profile picture" style="cursor: pointer">
	                    {{ csrf_field() }}
	                    <input type="hidden" class="form-control" value="{{$user->id}}" name="id" id="id_users">
	                    <input type="file" name="select_file" id="select_file" style="display: none" />
	                </form>
                    <h3 class="profile-username text-center">{{$info['name']}}</h3>
                    <p class="text-muted text-center">Nhân Viên Nội Thất Zip</p>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Ngày Sinh</b> <a class="pull-right">{{$info['birthday']}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Chứng Minh Thư</b> <a class="pull-right">{{$info['cmt']}}</a>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông Tin Chi Tiết</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-book margin-r-5"></i> Thêm</strong>
                    <p class="text-muted">
                        Giới Tính: @if($info['sex'] == 0) Nam @else Nữ @endif <br>
                        Dân Tộc: @if($info['dan_toc'] == 0) Không @else Có @endif <br>
                        @if($info['email'])Email: {{$info['email']}} @endif
                    </p>
                    <hr>
                    <strong><i class="fa fa-map-marker margin-r-5"></i> Địa chỉ thường trú</strong>
                    <p class="text-muted">{{$info['address_tt']}}</p>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">Cập Nhật</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="settings">
                        <form class="form-horizontal">
                        	<input type="hidden" class="form-control" value="{{$user->id}}" id="id_user">
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">username</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" value="{{$user->username}}" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Địa Chỉ Tạm Trú</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputAddress" placeholder="Nhập Địa Chỉ Thường Trú" value="{{$info['address_now']}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Mật Khẩu</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" id="password" placeholder="Mật Khẩu"></input>
                                </div>

                                <div class="col-sm-5">
                                    <input type="password" class="form-control" id="passwordAgain" placeholder="Xác Nhận Lại">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="button" onclick="editProfile()" class="btn btn-danger">Đồng Ý</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
	function editProfile() {
		var editProfile= '{{ route("editProfile") }}';
	    $.ajax({
	        data: {
	            password: $('#password').val(),
	            passwordAgain  : $('#passwordAgain').val(),
                now : $('#inputAddress').val(),
                id : $('#id_user').val(),
	        },
	        url: editProfile,
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

	$("#image-trigger").click(function(){
        $("#select_file").trigger('click');
    });
    $('#select_file').change(function() {
		var val = $("#select_file").val();
		// alert(val);
		if(val !== ''){
	        $.ajax({
			    url:'{{ route("addAvatar") }}', 
			    data:  new FormData($("#data-form")[0]),
			    dataType:'json', 
			    async:false, 
			    type:'post', 
			    processData: false, 
			    contentType: false, 
			    success:function(data) {
					$('#message').css('display', 'block');
					$('#message').html(data.message);
					$('#message').addClass(data.class_name);
					$('#image-trigger').remove();
					$('#data-form').html(data.uploaded_image);
			    },
			});
		}
	});
</script>
@endsection
