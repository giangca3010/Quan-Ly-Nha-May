
@extends("app")
@section("content")

<section class="container">
	<div class="row">
		<form name="quy trinh" method="post" enctype="multipart/form-data" action="{{URL::to('/save-Quy-Trinh')}}" >
			@csrf
			<div class="row" >
				<div class="form-group col-md-4">
					<label for="name">Tên Quy Trình</label>
					<input type="text" class="form-control"  name="ten_quy_trinh" placeholder="Nhập Tên Quy Trình" value="">
				</div>
				<div class="form-group col-md-4">
					<label for="name">Ký Hiệu</label>
					<input type="text" class="form-control" name="kyhieu" placeholder="Nhập Ký Hiệu" value="">
				</div>
				<div class="form-group col-md-4">
					<label for="name">Link</label>
					<input type="file" class="form-control"  name="link" placeholder="Nhập Link" value="">
				</div>
				<button type="submit" class="btn btn-primary">Thêm</button>
				<a href="{{URL::to('/quyTrinh')}}" class="btn btn-primary">Thoát</a>
				
				<div></div>
			</div>
		</form>
	</div>
</section>
@endsection