@extends("app")
@section("css")
<link href="{{asset('vendor/harimayco-menu/style.css')}}" rel="stylesheet">
@endsection
@section("content")
    <div id="hwpwrap">
	<div class="custom-wp-admin wp-admin wp-core-ui js menu-max-depth-0 nav-menus-php auto-fold admin-bar">
		<div id="wpwrap">
			<div id="wpcontent">
				<div id="wpbody">
					<div id="wpbody-content">
						<div class="wrap">
							<div id="nav-menus-frame">
								<div id="menu-settings-column" class="metabox-holder">
									<div class="clear"></div>
									<form id="nav-menu-meta" action="" class="nav-menu-meta" method="post" enctype="multipart/form-data">
										<div id="side-sortables" class="accordion-container">
											<ul class="outer-border">
												<li class="control-section accordion-section  open add-page" id="add-page">
													<h3 class="accordion-section-title hndle" tabindex="0"> Thêm Thông Tin <span class="screen-reader-text">Press return or enter to expand</span></h3>
													<div class="accordion-section-content ">
														<div class="inside">
															<div class="customlinkdiv" id="customlinkdiv">
																<label class="howto" for="custom-menu-item-name"> <span>Tên</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																	<input id="custom-menu-item-name" name="name" type="text" class="regular-text menu-item-textbox input-with-default-title" title="Tên Công Đoạn Hoặc Tên Lệnh">
																</label>

																<label class="howto" for="custom-menu-item-name"> <span>Công Đoạn</span>&nbsp;&nbsp;&nbsp;
																	<select id="select-lenh">
																	<option value="0"></option>
																	@foreach($lenh as $l)
																	<option value="{{$l->id}}">{{$l->name}}</option>
																	@endforeach
																	</select>
																</label>

																<label class="howto" for="custom-menu-item-dinhmuc"> <span>Định Mức</span>  &nbsp;&nbsp;
																	<input id="custom-menu-item-dinhmuc" name="dinhmuc" type="text" class="regular-text menu-item-textbox input-with-default-title" title="Định Mức">
																</label>

																<label class="howto" for="custom-menu-item-tre"> <span>Độ Trễ</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																	<input id="custom-menu-item-tre" name="tre" type="text" class="menu-item-textbox " placeholder=" Thời Gian Trễ">
																</label>

																<label>
																	Công Đoạn Chính
																	<input id="custom-menu-item-chinh" name="chinh" type="checkbox" value="1">
																	<p class="text-red error-cdc hide">Đã có công đoạn chính</p>
											                    </label>

																<p class="button-controls">
																	<a href="#" onclick="add()" class="button-secondary submit-add-to-menu right" >Thêm</a>
																</p>

															</div>
														</div>
													</div>
												</li>

											</ul>
										</div>
									</form>
								</div>
								<div id="menu-management-liquid">
									<div id="menu-management">
										<form id="update-nav-menu" action="" method="post" enctype="multipart/form-data">
											<div class="menu-edit ">
												<div id="nav-menu-header">
													<div class="major-publishing-actions">
														<label class="menu-name-label howto open-label" for="menu-name"> <span>Action</span></label>
														
														@if(request()->has("menu"))
														<div class="publishing-action">
															<a onclick="getmenus()" name="save_menu" id="save_menu_header" class="button button-primary menu-save">Lưu</a>
															<span class="spinner" id="spincustomu2"></span>
														</div>
														@endif
													</div>
												</div>
												<div id="post-body">
													<div id="post-body-content">

														<ul class="menu ui-sortable" id="menu-to-edit">
															@if(isset($menus))
															@foreach($menus as $m)
															<li id="menu-item-{{$m->id}}" class="menu-item menu-item-depth-{{$m->depth}} menu-item-page menu-item-edit-inactive pending" style="display: list-item;">
																<dl class="menu-item-bar">
																	<dt class="menu-item-handle {{ ($m->status == 1) ? 'bg-success' : ''  }}">
																		<span class="item-title"> 
																			<span class="menu-item-title"> 
																				<span id="menutitletemp_{{$m->id}}">{{$m->name}}</span> 
																				<span style="color: transparent;">|{{$m->id}}|</span> 
																			</span> 
																			<span class="is-submenu" style="@if($m->depth==0)display: none;@endif">
																				{{$m->dinhmuc}} Tiếng
																			</span> 
																		</span>
																		<span class="item-controls"> 
																			<span class="item-type">Chi Tiết</span> 
																			<span class="item-order hide-if-js"> 
																				<a href="?action=move-up-menu-item&menu-item={{$m->id}}&_wpnonce=8b3eb7ac44" class="item-move-up">
																					<abbr title="Move Up">↑</abbr>
																				</a> | 
																				<a href="?action=move-down-menu-item&menu-item={{$m->id}}&_wpnonce=8b3eb7ac44" class="item-move-down">
																					<abbr title="Move Down">↓</abbr>
																				</a> 
																			</span> 
																			<a class="item-edit" id="edit-{{$m->id}}" title=" " href="?edit-menu-item={{$m->id}}#menu-item-settings-{{$m->id}}"> </a>
																		</span>
																	</dt>
																</dl>

																<div class="menu-item-settings" id="menu-item-settings-{{$m->id}}">
																	<input type="hidden" class="edit-menu-item-id" name="menuid_{{$m->id}}" value="{{$m->id}}" />
																	@if($m->parent != 0)
																	<table class="table">
																	    <thead>
																			<tr>
																				<th>Tên</th>
																		        <th>Độ Trễ</th>
																		        <th>Định Mức</th>
																			</tr>
																	    </thead>
																	    <tbody>
																			<tr>
																				<td>{{$m->name}}</td>
																		        <td>{{$m->tre}} Tiếng</td>
																		        <td>{{$m->dinhmuc}} Tiếng</td>
																			</tr>
																	    </tbody>
																	</table>
																	@endif
																	<p class="description description-thin">
																		<label for="edit-menu-item-title-{{$m->id}}"> Tên
																			<br>
																			<input type="text" id="idlabelmenu_{{$m->id}}" class="widefat edit-menu-item-title" name="idlabelmenu_{{$m->id}}" value="{{$m->name}}">
																		</label>
																	</p>
																	@if($m->parent != 0)
																	<p class="field-css-classes description description-thin">
																		<label for="edit-menu-item-classes-{{$m->id}}"> Định Mức
																			<br>
																			<input type="text" id="clases_menu_{{$m->id}}" class="widefat code edit-menu-item-classes" name="clases_menu_{{$m->id}}" value="{{$m->dinhmuc}}">
																		</label>
																	</p>

																	<p class="field-css-classes description description-thin">
																		<label for="edit-menu-item-classes-{{$m->id}}"> Độ Trễ
																			<br>
																			<input type="text" id="tre_{{$m->id}}" class="widefat code edit-menu-item-classes" name="tre_{{$m->id}}" value="{{$m->tre}}">
																		</label>
																	</p>
																	@endif
																	<div class="menu-item-actions description-wide submitbox">
																		<a class="item-cancel submitcancel hide-if-no-js button-secondary" id="cancel-{{$m->id}}" href="?edit-menu-item={{$m->id}}&cancel=1424297719#menu-item-settings-{{$m->id}}">Hủy Thay Đổi</a>
																		<span class="meta-sep hide-if-no-js"> | </span>
																		<a onclick="getmenus()" class="button button-primary updatemenu" id="update-{{$m->id}}" href="javascript:void(0)">Câp Nhật</a>

																	</div>

																</div>
																<ul class="menu-item-transport"></ul>
															</li>
															@endforeach
															@endif
														</ul>
														<div class="menu-settings">

														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>

						<div class="clear"></div>
					</div>

					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>

			<div class="clear"></div>
		</div>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
var menus = {
	"oneThemeLocationNoMenus" : "",
	"moveUp" : "Move up",
	"moveDown" : "Mover down",
	"moveToTop" : "Move top",
	"moveUnder" : "Move under of %s",
	"moveOutFrom" : "Out from under  %s",
	"under" : "Under %s",
	"outFrom" : "Out from %s",
	"menuFocus" : "%1$s. Element menu %2$d of %3$d.",
	"subMenuFocus" : "%1$s. Menu of subelement %2$d of %3$s."
};
function add() {
	var addactionboom= '{{ route("addactionboom") }}';
    $.ajax({
        data: {
            name: $('#custom-menu-item-name').val(),
            tre: $('#custom-menu-item-tre').val(),
            dinhmuc: $('#custom-menu-item-dinhmuc').val(),
            parent: $('#select-lenh').val(),
            status: $('#custom-menu-item-chinh').is(':checked')
        },

        url: addactionboom,
        type: 'POST',
        success: function(data) {
        	if(data.status === true) {
				$.bootstrapGrowl(data.message, { type: 'success' });
	            window.location.reload();
	            setTimeout(function(){
		           window.location.reload(); 
				}, 200); 
        	}
        	if(data.status === false) {
        		$.bootstrapGrowl(data.message, { type: 'danger' });
        		$('.error-cdc').removeClass('hide');
	        }
        },
    });
}
</script>
<script type="text/javascript" src="{{asset('vendor/harimayco-menu/scripts.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/harimayco-menu/scripts2.js')}}"></script>
@endsection