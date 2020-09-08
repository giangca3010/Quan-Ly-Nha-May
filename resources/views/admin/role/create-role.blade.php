@extends("app")
@section("css")
<link rel="stylesheet" href="{{asset('js/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-duallistbox.css')}}">
<script src="{{asset('js/jquery.bootstrap-duallistbox.min.js')}}"></script>
@endsection
@section("content")
    <div >
    	<div class="col-md-12">
			<label>Tên</label>
    		<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                <input type="text" class="form-control" id="name" placeholder="Name">
			</div>
    	</div>
    	<div class="col-md-12">
    		<div class="form-group">
		    <select multiple="multiple" size="10" name="duallistbox_demo1[]"  id="select-permission"> 
				@foreach($permission as $value)
					<option value="{{$value->id}}">{{$value->name}}</option>
				@endforeach
		    </select>
			</div>
    	</div>
    </div>
    <div class="pull-right">
    	<a href="#" onclick="addRole()" class="btn btn-success">Lưu</a>
    </div>
@endsection

@section('js')
<script src="{{asset('js/select2/dist/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
    var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox();
    $("#demoform").submit(function() {
        alert($('[name="duallistbox_demo1[]"]').val());
        return false;
    });
	$('.select2').select2();
	function addRole() {
		var addRole= '{{ route("addRole") }}';
	    $.ajax({
	        data: {
	            name: $('#name').val(),
	            permission  : $('#select-permission').val(),
	        },
	        url: addRole,
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
