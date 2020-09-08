<?php
$currentUrl = url()->current();
?>
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href="{{asset('vendor/harimayco-menu/style.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="{{asset('js/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<div id="hwpwrap">
	<div class="custom-wp-admin wp-admin wp-core-ui js menu-max-depth-0 nav-menus-php auto-fold admin-bar">
		<div id="wpwrap">
			<div id="wpcontent">
				<div id="wpbody">
					<div id="wpbody-content">
						<div class="wrap">
							<div id="nav-menus-frame" style="margin-left: 0; margin-top: 0;">
								<div id="menu-management-liquid">
									<div id="menu-management">
										<form id="update-nav-menu" action="" method="post" enctype="multipart/form-data">
											<div class="menu-edit ">
												<div id="nav-menu-header">
													<div class="major-publishing-actions">
														<label class="menu-name-label howto open-label" for="menu-name"> <span>Name</span>
															<input name="menu-name" id="menu-name" type="text" class="menu-name regular-text menu-item-textbox" title="Enter menu name" value="@if(isset($indmenu)){{$indmenu->name}}@endif">
															<input type="hidden" id="idmenu" value="@if(isset($indmenu)){{$indmenu->id}}@endif" />
														</label>

														<div class="publishing-action">
															<a onclick="getmenus()" name="save_menu" id="save_menu_header" class="button button-primary menu-save">Lưu</a>
															<span class="spinner" id="spincustomu2"></span>
														</div>
													
													</div>
												</div>
												<div id="post-body">
													<div id="post-body-content">

														<ul class="menu ui-sortable" id="menu-to-edit">
															@if(isset($menus))
															@foreach($menus as $m)
															<li id="menu-item-{{$m->id}}" class="menu-item menu-item-depth-{{$m->depth}} menu-item-page menu-item-edit-inactive pending" style="display: list-item;">
																<dl class="menu-item-bar">
																	<dt class="menu-item-handle">
																		<span class="item-title"> 
																			<span class="menu-item-title"> 
																				<span id="menutitletemp_{{$m->id}}">{{$m->label}}</span> 
																				<span style="color: transparent;">|{{$m->id}}|</span> 
																			</span> 
																			<span class="is-submenu" style="@if($m->depth==0)display: none;@endif">
																				<?php echo date('H:i',strtotime($m->start_time)); ?> - 
																	        	<?php echo date('H:i',strtotime($m->end_time)); ?>
																			</span> 
																		</span>
																		<span class="item-controls"> 
																			<span class="item-type">Chi Tiết</span> 
																			<span class="item-order hide-if-js"> 
																				<a href="{{ $currentUrl }}?action=move-up-menu-item&menu-item={{$m->id}}&_wpnonce=8b3eb7ac44" class="item-move-up">
																					<abbr title="Move Up">↑</abbr>
																				</a> | 
																				<a href="{{ $currentUrl }}?action=move-down-menu-item&menu-item={{$m->id}}&_wpnonce=8b3eb7ac44" class="item-move-down">
																					<abbr title="Move Down">↓</abbr>
																				</a> 
																			</span> 
																			<a class="item-edit" id="edit-{{$m->id}}" title=" " href="{{ $currentUrl }}?edit-menu-item={{$m->id}}#menu-item-settings-{{$m->id}}"> </a>
																		</span>
																	</dt>
																</dl>

																<div class="menu-item-settings" id="menu-item-settings-{{$m->id}}">
																	<input type="hidden" class="edit-menu-item-id" name="menuid_{{$m->id}}" value="{{$m->id}}" />
																	@if($m->parent != 0)
																	<table class="table">
																	    <thead>
																			<tr>
																		        <th>Người</th>
																		        <th>Time</th>
																		        <th>Trễ</th>
																		        <th>Định Mức</th>
																			</tr>
																	    </thead>
																	    <tbody>
																			<tr>
																		        <td>Chiến</td>
																		        <td><?php echo date('H:i',strtotime($m->start_time)); ?> - 
																		        	<?php 
																		        	    if($m->end_time == null) {
																			        		$d="+".$m->dinhmuc."hours";
																			        		echo date('H:i',strtotime($m->start_time.$d));
																		        	    }else {
																		        	    	echo date('H:i',strtotime($m->end_time));
																		        	    }
																		        	?>
																	        	</td>
																		        <td>{{$m->tre}}</td>
																		        <td>{{$m->dinhmuc}}</td>
																			</tr>
																	    </tbody>
																	</table>
																	@endif
																	<p class="description description-thin">
																		<label for="edit-menu-item-title-{{$m->id}}"> Tên
																			<br>
																			<input type="text" id="idlabelmenu_{{$m->id}}" class="widefat edit-menu-item-title" name="idlabelmenu_{{$m->id}}" value="{{$m->label}}">
																		</label>
																	</p>

																	<p class="field-css-classes description description-thin">
																		<label for="edit-menu-item-classes-{{$m->id}}"> Định Mức
																			<br>
																			<input type="text" id="clases_menu_{{$m->id}}" class="widefat code edit-menu-item-classes" name="clases_menu_{{$m->id}}" value="{{$m->dinhmuc}}">
																		</label>
																	</p>

																	<p class="field-css-url description description-thin hidden">
																		<label for="edit-menu-item-url-{{$m->id}}"> Url
																			<br>
																			<input type="text" id="url_menu_{{$m->id}}" class="widefat code edit-menu-item-url" id="url_menu_{{$m->id}}" value="{{$m->link}}">
																		</label>
																	</p>

																	<div class="menu-item-actions description-wide submitbox">
																		<a class="item-cancel submitcancel hide-if-no-js button-secondary" id="cancel-{{$m->id}}" href="{{ $currentUrl }}?edit-menu-item={{$m->id}}&cancel=1424297719#menu-item-settings-{{$m->id}}">Hủy Thay Đổi</a>
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
												<div id="nav-menu-footer">
													<div class="major-publishing-actions">

														@if(request()->has('action'))
														<!-- <div class="publishing-action">
															<a onclick="createnewmenu()" name="save_menu" id="save_menu_header" class="button button-primary menu-save">Create menu</a>
														</div> -->
														@elseif(request()->has("menu"))
														<span class="delete-action"> <a class="submitdelete deletion menu-delete" onclick="deletemenu()" href="javascript:void(9)">Xóa Kế Hoạch</a> </span>			
														@else
														<div class="publishing-action">
															<a onclick="createnewmenu()" name="save_menu" id="save_menu_header" class="button button-primary menu-save">Create menu</a>
														</div>
														@endif
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
