@extends("app")
@section("css")
<link rel="stylesheet" href="{{asset('js/select2/dist/css/select2.min.css')}}"> 

@endsection
@section("content")
      
      <div class="container-fluid mt-3">
         <h4 class="mb-2">Complex Form</h4>
         <form method="post" action="{{URL::to('/saveXinNghi')}}">
            {{csrf_field()}}
            <div class="form-group">
               <label for="inputAddress">Tên nhân viên</label>
               <select name="name_user1" type="text" class="form-control"
                  id="myAddress" placeholder="Tên nhân viên">
                  @foreach($dataUsers as $nv)
                     <option value="{{($nv->id)}}">
                        {{($nv->name)}}
                     </option>
                  @endforeach                   
               </select>
            </div>
            <div class="form-group">
               <label for="inputAddress">Tên bộ phận</label>
               <select name="name_boPhan" type="text" class="form-control"
                  id="myAddress" placeholder="Bộ phận">
                  @foreach($dataRoles as $bp)
                     <option value="{{($bp->id)}}">
                        {{($bp->name)}}
                     </option>
                  @endforeach       
               </select>
            </div>
            <div class="form-group">
               <label for="inputAddress">Nhân viên phê duyệt</label>
               <select name="name_user2" type="text" class="form-control"
                  id="myAddress" placeholder="#">
                  @foreach($dataUsers as $nv)
                     <option value="{{($nv->id)}}">
                        {{($nv->name)}}
                     </option>
                  @endforeach    
               </select>
            </div>
            <div class="row">
               <div class="form-group col-sm-6">
                  <label for="myEmail">Số ngày nghỉ</label>
                  <input name="ngayNghi" type="number" class="form-control"
                     id="myPassword" placeholder="Số ngày nghỉ">
               </div>
               <div class="form-group col-sm-6">
                  <label for="myPassword">Số điện thoại</label>
                  <input name="soDienThoai" type="number" class="form-control"
                     id="myPassword" placeholder="Nhập số điện thoại">
               </div>
            </div>
            <div class="form-group">
               <label for="inputAddress2">Lý do nghỉ</label>
               <input name="lyDo" type="text" class="form-control"
                  id="myAddress2" placeholder="Lý do nghỉ">
            </div>
            <div class="form-group">
               <label for="inputAddress2">Công việc bàn giao</label>
               <input name="banGiao" type="text" class="form-control"
                  id="myAddress2" placeholder="Nội dung bàn giao">
            </div>
            <div class="form-group">
               <label for="inputAddress">Người nhận bàn giao</label>
               <select name="name_user3" type="text" class="form-control"
                  id="myAddress" placeholder="Người nhận bàn giao">
                     @foreach($dataUsers as $nv)
                        <option value="{{($nv->id)}}">
                           {{($nv->name)}}
                        </option>
                     @endforeach 
                  </select>
            </div>
            <div class="row">
               <div class="col-sm-6">
                  <label for="myEmail">
                     Ngày xin nghỉ
                  </label>
                  <div class="input-group">
                     <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                     </span>
                     <input type="date" name="ngayXinNghi" class="form-control" placeholder="Ngày Nghỉ" id="datetimes">
                  </div>
               </div>
               
               <div class="col-sm-6">
                  <label for="myEmail">
                     Ngày Kết thúc
                  </label>
                  <div class="input-group">
                     <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                     </span>
                     <input type="date" name="ketThucNgay" class="form-control" placeholder="Ngày Nghỉ" id="datetimes">
                  </div>
               </div>
            </div>
            <br>
            <h5 style="float: left;">Trạng thái nghỉ</h5>
            <div class="form-group">
               <select name="trangThaiNghi" class="form-control input-sm m-bot15">
                  <label for="exampleInputPassword1">Hiển thị</label>
                  <option value="5">Không lương</option>
                  <option value="6">Chế độ</option>
                  <option value="7">Nghỉ việc</option>
               </select>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{URL::to('/xinNghi')}}" class="btn btn-primary">Thoát</a>
         </form>
      </div>
      

@endsection
@section('js')
<script src="{{asset('js/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('js/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('js/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('js/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script src="{{asset('js/moment/min/moment.min.js')}}"></script>
<script src="{{asset('js/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('js/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('js/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script>
   
      $('input[name="datetimes"]').daterangepicker({
         // timePicker: true,
         startDate: moment().startOf('isoWeek'),
         endDate: moment().endOf('isoWeek'),
         locale: {
            format: 'D/M/Y'
         },
         ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
              'Last 7 Days': [moment().subtract('days', 6), moment()],
              'Last 30 Days': [moment().subtract('days', 29), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
          },
      });
        $(function () {
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>

@endsection