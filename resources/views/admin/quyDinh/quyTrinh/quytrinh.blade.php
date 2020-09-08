@extends("app");
@section("content")
<a href="{{asset('add-Quy-Trinh')}}" class="btn btn-success">Thêm</a>
<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
	<div class="row">
		<div class="col-sm-12">
			<table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
				<thead>
					<tr>
						<th>ID</th>
						<th>Tên Quy Trinh</th>
						<th>Ký Hiệu</th>
						<th>Link</th>
						<th>Thao Tác</th>
					</tr>
				</thead>
				<body>
					<div class="hidden">{{$stt = 1}}</div>
					@foreach ($quytrinh as $key => $qt)
					<tr>
						<td>{{$stt}}</td>
						<td>{{$qt->ten_quy_trinh}}</td>
						<td>{{$qt->kyhieu}}</td>
						<td><a href="{{$qt->link}}">Tài liệu</a></td>
						<td>
							<a class="fa fa-edit" href="/edit-quy-trinh/{{$qt->id}}" type="edit" ><i class="fas fa-pencil-ruler"></i></a>		

							<a class="fa fa-trash red" href="/delete-quy-trinh/{{$qt->id}}" onclick="return confirm('Ban co muon xoa khong')"></a>
						</td>

					</tr>
					<div class="hidden">{{$stt += 1}}</div>
					@endforeach 
				</body>
			</table>
		</div>
	</div>
</div>

@endsection