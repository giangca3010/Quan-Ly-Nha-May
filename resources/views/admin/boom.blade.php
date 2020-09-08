@extends("app")
@section("content")
    <a type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default"><span class="glyphicon glyphicon-plus"></span> Thêm Boom</a>
    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
	    <div class="row"></div>
	    <div class="row">
	        <div class="col-sm-12">
	            <table id="boomtable" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
	                <thead>
	                    <tr role="row">
	                        <th class="sorting_desc" tabindex="0" aria-controls="boomtable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Mã Boom</th>
	                        <th>Version</th>
	                        <th>Công Đoạn</th>
	                        <th>Định Mức</th>
	                        <th>Độ Trễ</th>
	                        <th>Thao Tác</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	@foreach($merge as $m)
	                	@if($m->parentSons->isNotEmpty())
                    	@foreach($m->parentSons as $k => $parent)
	                	<tr role="row" class="odd">
	                        <td class="sorting_1 {{$k ==  0 ? '' : 'hide' }}" rowspan="{{count($m->parentSons)}}">{{$m->name}}</td>
                        	<td class=" {{$k ==  0 ? '' : 'hide' }}" rowspan="{{count($m->parentSons)}}">
                        		<a class="show_version" data-toggle="modal" data-target="#create-version" data-id="{{$m->id}}" data-version="{{$parent->version}}">Version {{$parent->version}}</a>
                        	</td>
	                        <td>{{$parent->name}}</td>
	                        <td>{{$parent->dinhmuc}} Tiếng</td>
	                        <td>{{$parent->tre}} Tiếng</td>
	                        <td class="sorting_1 {{$k ==  0 ? '' : 'hide' }}" rowspan="{{count($m->parentSons)}}">
	                        	<a href="/editactionboom?id={{$m->id}}&menu_id={{$m->menu}}"><span class="fa fa-edit"></span></a>
		                        <a type="button" class="delete_data" data-id="{{$m->id}}">
	                        		<span class="fa fa-trash"></span>
	                        	</a>
	                        </td>
	                    </tr>
                    	@endforeach
                    	@else
                    	<tr role="row" class="odd">
	                        <td class="sorting_1">{{$m->name}}</td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td>
	                        	<a href="/editactionboom?id={{$m->id}}&menu_id={{$m->menu}}"><span class="fa fa-edit"></span></a>
	                        	<a type="button" class="delete_data" data-id="{{$m->id}}">
	                        		<span class="fa fa-trash"></span>
	                        	</a>
	                        </td>
	                    </tr>
                    	@endif
	                    @endforeach
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="modal-default">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Tạo Boom</h4>
	            </div>
	            <div class="modal-body">
	                <div class="form-group">
					    <label for="nameLenh">Tên Boom</label>
					    <input type="email" class="form-control" id="nameLenh" placeholder="Nhập Tên Boom">
					</div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	                <a href="#" onclick="addLenh()"  type="button" class="btn btn-primary">Lưu</a>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="create-version" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close button-close"  data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Thêm Verion Boom</h4>
	            </div>
	            <div class="modal-body">
	                <table class="table table-bordered">
	                	<thead>
	                		<td>Công Đoạn</td>
	                		<td>Định Mức</td>
	                		<td>Độ Trễ</td>
	                	</thead>
	                	<tbody>
	                		@foreach($merge as $m)
		                	@if($m->parentSons->isNotEmpty())
	                    	@foreach($m->parentSons as $k => $parent)
		                	<tr role="row" class="odd hidden hidden-all id-{{$m->id}}-{{$parent->version}}">
		                		<input type="hidden" name="count" id="versioncount" value="{{count($m->parentSons)}}">
		                		<input type="hidden" name="id" id="versionid" value="{{$m->id}}">
		                		<input type="hidden" name="verison" id="versionstt" value="{{$parent->version}}">
		                		<input type="hidden" name="verison" id="menu_id" value="{{$parent->menu}}">
		                		<input type="hidden" name="itemname"  id="itemname" value="{{$m->name}}">
		                        <td><input type="hidden" name="congdoan" value="{{$parent->id}}" >{{$parent->name}}</td>
		                        <td><input style="width: 50px;" type="text" name="dinhmuc" value="{{$parent->dinhmuc}}" id="dinhmuc{{count($m->parentSons) - $k}}"> Tiếng</td>
		                        <td><input style="width: 50px;" type="text" name="tre" value="{{$parent->tre}}" id="tre{{count($m->parentSons) - $k}}"> Tiếng</td>
		                    </tr>
	                    	@endforeach
	                    	@endif
		                    @endforeach
	                	</tbody>
	                </table>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left button-close" data-dismiss="modal" >Close</button>
	                <a href="#" onclick="addVersion()"  type="button" class="btn btn-primary">Thêm</a>
	            </div>
	        </div>
	    </div>
	</div>
@endsection

@section('js')
<script type="text/javascript">
$(function () {
    $('#boomtable').DataTable({
		'paging'      : true,
		'lengthChange': true,
		'searching'   : true,
		'ordering'    : true,
		'info'        : true,
		'autoWidth'   : false,
		"order": [[ 0, "desc" ]]
    })
})
function addLenh() {
	var addLenh= '{{ route("addLenh") }}';
	var search = window.location.search;
	var number = search.match(/\d+/);
    $.ajax({
        data: {
            name: $('#nameLenh').val(),
            menu_id : number.toString(),
        },
        url: addLenh,
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
$(".show_version").click(function() {
	var id = $(this).data('id');
	var version = $(this).data('version');
	$(".id-"+id+'-'+version).removeClass('hidden');
});
$(".button-close").click(function() {
	$(".hidden-all").addClass('hidden');
});
function addVersion() {
	var addVersion= '{{ route("addVersion") }}';
	var count = $('tr:not(.hidden) #versioncount').val();
	// alert(count);
    $.ajax({

        data: {
            id : $('tr:not(.hidden) #versionid').val(),
            count: $('tr:not(.hidden) #versioncount').val(),
            itemname: $('tr:not(.hidden) #itemname').val(), 
            version : $('tr:not(.hidden) #versionstt').val(),
            menu_id  : $('tr:not(.hidden) #menu_id').val(),
            dinhmuc7 : $('tr:not(.hidden) #dinhmuc7').val(),tre1 : $('tr:not(.hidden) #tre1').val(),
            dinhmuc1 : $('tr:not(.hidden) #dinhmuc1').val(),tre2 : $('tr:not(.hidden) #tre2').val(),
            dinhmuc2 : $('tr:not(.hidden) #dinhmuc2').val(),tre3 : $('tr:not(.hidden) #tre3').val(),
            dinhmuc3 : $('tr:not(.hidden) #dinhmuc3').val(),tre4 : $('tr:not(.hidden) #tre4').val(),
            dinhmuc4 : $('tr:not(.hidden) #dinhmuc4').val(),tre5 : $('tr:not(.hidden) #tre5').val(),
            dinhmuc5 : $('tr:not(.hidden) #dinhmuc5').val(),tre6 : $('tr:not(.hidden) #tre6').val(),
            dinhmuc6 : $('tr:not(.hidden) #dinhmuc6').val(),tre7 : $('tr:not(.hidden) #tre7').val(),
        },
        url: addVersion,
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
$('.delete_data').click(function () {
    	var destroy= '{{ route("destroy.boom") }}';
	    $.ajax({
	        data: {
	            id  : $(this).data('id'),
	        },
	        url: destroy,
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
</script>
@endsection