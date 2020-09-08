@extends("app")
@section("content")
	
<section class="container">
	<div class="row">
		<form  method="post" enctype="multipart/form-data" action="" >
			@csrf
			<div class="row" >
				<div class="form-group col-md-4">
					<label for="name">Tên Quy Trình</label>
					<input type="text" class="form-control"  name="ten_quy_trinh" placeholder="Nhập Tên Quy Trình" value="{{ $editQuyTrinh->ten_quy_trinh }}">

				</div>
				<div class="form-group col-md-4">
					<label for="kyhieu">Ký Hiệu</label>
					<input type="text" class="form-control" name="kyhieu" placeholder="Nhập Ký Hiệu" value="{{$editQuyTrinh->kyhieu}}">
				</div>
				<div class="form-group col-md-4">
					<label for="link">Link</label>
					<input type="file" class="form-control" name="link" placeholder="Nhập Link" >
				</div>
				<button type="submit" class="btn btn-primary">Sửa</button>
				<a href="/quyTrinh" class="btn btn-primary">Thoát</a>
				<div></div>
			</div>
		</form>
	</div>
</section>

@endsection
