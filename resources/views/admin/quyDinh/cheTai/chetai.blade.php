@extends("app")
@section("css")
<link rel="stylesheet" href="{{asset('js/select2/dist/css/select2.min.css')}}">	
@endsection
@section("content")
	<a href="{{asset('themCheTai')}}" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Thêm </a>
	<br>
	<br>
    <div class="row">
	        <div class="col-sm-12">
	            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
	                <thead>
	                    <tr role="row">
	                        <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >ID</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Tên chế tài</th>
	                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >Mô tả chế tài</th>
	                        <th>Thao Tác</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<div class="hidden">{{$stt = 1}}</div>
             		   	@foreach($allCheTai as $key => $ct)
	                	<tr role="row" class="odd">
	                		<td class="sorting_1">{{$stt}}</td>
	                		<td class="sorting_1">{{$ct->chetai_name}}</td>
	                		<td class="sorting_1">{{$ct->chetai_mota}}</td>
	                		<td class="sorting_1">
								<a href="/editCheTai/{{$ct->chetai_id}}" type="button" class="edit_data">
									<span class="fa fa-edit"></span>
								</a>
								<a onclick="return confirm('Bạn muốn xóa mục này?')" href="/deleteCheTai/{{$ct->chetai_id}}" type="button" class="delete_data">
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

