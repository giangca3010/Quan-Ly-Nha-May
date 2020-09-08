@extends("app")
@section("content")
    <a href="{{asset('addRole')}}"  class="btn btn-success">Thêm</a>
    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
	    <div class="row"></div>
	    <div class="row">
	        <div class="col-sm-12">
	            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
	                <thead>
	                    <tr role="row">
	                        <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >ID</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Tên</th>
	                        <th>Thao Tác</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	@foreach($roleList as $k => $u)
		                	<tr role="row" class="odd">
		                		<td class="sorting_1">{{$k + 1}}</td>
		                		<td class="sorting_1">{{$u->name}}</td>
		                        <td class="sorting_1">
		                        	<a href="{{asset('editRole').'/'.$u->id}}"><span class="fa fa-edit"></span></a>
		                        </td>
		                    </tr>
	                    @endforeach
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>
@endsection

@section('js')
<script type="text/javascript">
	
</script>
@endsection
