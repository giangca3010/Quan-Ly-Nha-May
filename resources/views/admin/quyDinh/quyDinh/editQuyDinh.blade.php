@extends("app")
@section("css")
<link rel="stylesheet" href="{{asset('js/select2/dist/css/select2.min.css')}}"> 

@endsection
@section("content")
      
      <div class="container-fluid mt-3">
         <h4 class="mb-2">Complex Form</h4>
         <form method="post" action="">
            {{csrf_field()}}
            <div class="form-group">
               <label for="inputAddress">Tên quy định</label>
               <input name="quyDinh_name" type="text" class="form-control"
                  id="myAddress2" placeholder="Lý do nghỉ">
            </div>
            <div class="form-group">
               <label for="inputAddress">Quynh trình</label>
               <select name="quyTrinh_id" type="text" class="form-control"
                  id="myAddress" placeholder="Bộ phận">  
                  @foreach($dataQT as $qt) 
                    <option value="{{($qt->id)}}" @if($editQuyDinh->quyTrinh_id == $qt->id) selected ="selected" @endif>
                      {{($qt->ten_quy_trinh)}}
                    </option>
                  @endforeach
               </select>
            </div>
            <div class="form-group">
               <label for="inputAddress">Nội dung</label>
               <textarea rows="8" type="detain" class="form-control" name="noiDung" id="exampleInputPassword1" placeholder="Nhập hướng dẫn">{{($editQuyDinh->noiDung)}}</textarea>
            </div>
            
            <div class="row">
            	<div class="form-group col-sm-6">
    				<div class="input_fields_wrap ">
    					<span for="">Chế tài lần 1</span>
	      				<select type="text" class="form-control" name="cheTai_1">
                  @foreach($dataCT as $ct) 
                    <option value="{{($ct->cheTai_id)}}" @if($editQuyDinh->cheTai_1 == $ct->cheTai_id) selected ="selected" @endif>
                      {{($ct->chetai_name)}}
                    </option>
                  @endforeach
                </select><br>
    				</div>
    				<button class="add_field_button">Thêm</button>
               </div>
               <div class="form-group col-sm-6">
                  	
               </div>
               <!-- <div class="form-group col-sm-6">
               		<div class="form-group col-sm-6">
		                <label for="myEmail">Số ngày nghỉ</label>
		                <input name="ngayNghi" type="number" class="form-control"
	                     id="myPassword" placeholder="Số ngày nghỉ">
               		</div>
                  	<div class="form-group col-md-9 ">
        				<label for="">Link video chứng minh thư</label>
        				<div class="input_fields_wrap ">
        				<span>l1</span>
          				<select type="text" class="form-control" name="linkcm"></select><br>
        				</div>
        				<button class="add_field_button">Thêm</button>
     				</div>
               </div> -->
               <div class="form-group col-sm-6">
                    
               </div>
            </div>
            <div class="form-group">
               <label for="inputAddress2">Bộ phận áp dụng</label>
               <select name="roles_id_1" type="text" class="form-control"
                  id="myAddress" placeholder="Bộ phận">  
                  @foreach($dataRoles as $ro)
                     <option value="{{($ro->id)}}">
                        {{($ro->name)}}
                     </option>
                  @endforeach  
               </select>
            </div>
            <div class="form-group">
               <label for="inputAddress">Bộ phận giám sát</label>
               <select name="roles_id_2" type="text" class="form-control"
                  id="myAddress" placeholder="Bộ phận">   
                  @foreach($dataRoles as $ro)
                     <option value="{{($ro->id)}}">
                        {{($ro->name)}}
                     </option>
                  @endforeach 
               </select>
            </div>
            <div class="form-group">
               <label for="inputAddress">Mã giám sát</label>
               <select name="maGiamSat" type="text" class="form-control"
                  id="myAddress" placeholder="Bộ phận">   
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
 <script type="text/javascript">
    $(document).ready(function() {
  var max_fields      = 10; //maximum input boxes allowed
  var wrapper       = $(".input_fields_wrap"); //Fields wrapper
  var add_button      = $(".add_field_button"); //Add button ID
  
  var x = 1; //initlal text box count
  $(add_button).click(function(e){ //on add input button click
    e.preventDefault();
    if(x < max_fields){ //max input box allowed
      x++; //text box increment
      console.log(x);
      $(wrapper).append('<div class="input_fields_wrap "><span for="">Chế tài lần '+x+'</span><select type="text" class="form-control" name="linkcm">@foreach($dataCT as $ct) <option value="{{($ct->cheTai_id)}}" @if($editQuyDinh->cheTai_1 == $ct->cheTai_id) selected ="selected" @endif>{{($ct->chetai_name)}}</option>@endforeach</select><br></div>'); }});
  $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
  	
    e.preventDefault(); $(this).parent('div').remove(); x--;
  })
});
</script>
<<!-- div><span>l'+x+'</span><select type="text" class="form-control" name="mytext[]"/></select><a href="#" class="remove_field">Xoá</a></div> -->
@endsection