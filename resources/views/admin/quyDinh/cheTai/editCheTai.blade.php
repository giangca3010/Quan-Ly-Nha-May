  @extends("app")
  @section("css")
  <link rel="stylesheet" href="{{asset('js/select2/dist/css/select2.min.css')}}"> 
  @endsection
  @section("content")
  <!-- <div class="modal-body">
    <form role="form" method="post" action="{{URL::to('/saveCheTai')}}" id="data-nguyennhan" enctype="multipart/form-data">
          <div class="form-group">
            <label for="nameLenh">Tên chế tài</label>
            <input type="text" class="form-control" id="name" name="chetai_name" placeholder="Nhập tên chế tài">
          </div>
          <div class="form-group">
            <label for="nameLenh">Mô Tả</label>
            <textarea rows="8" type="text" class="form-control" id="note" name="chetai_mota" placeholder="Nhập hướng dẫn"></textarea>
          </div>
              <input type="submit" class="submit_nguyennhan pull-right" value="Create">
    </form>
</div> -->
<div id="container">
  <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" method="post">
                            {{csrf_field()}}
                            <!-- @csrf -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">TÊN CHẾ TÀI</label>
                                <input type="text" name="chetai_name" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên chế tài" value="{{$editCheTai->chetai_name}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">MÔ TẢ</label>
                                <textarea style="resize: none " rows="8" class="form-control" name="chetai_mota" id="exampleInputPassword1" placeholder="Nhập hướng dẫn">{{$editCheTai->chetai_mota}}</textarea>
                            </div>
                            <button type="submit" name="add_category_product" class="btn btn-info">Create</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>

  </div>
</div>
@endsection
