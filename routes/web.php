<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix'=>'/','middleware'=>'Login'],function(){
	Route::get('/', 'DashboardController@index');

	Route::get('/ke-hoach', 'MenuController@index');
	Route::post('/start','MenuController@start');
	Route::post('/end','MenuController@end');

	Route::get('/lenh','LenhController@index');
	Route::get('/hoanthien','LenhController@index_ht');
	Route::post('/changelenh','LenhController@update')->name('changelenh');
	Route::post('/ajaxmove','LenhController@move');
	Route::post('/updateLenh','LenhController@show');
	Route::post('/cancelMove','LenhController@edit')->name('cancelMove');
	Route::post('/tamdunglenh','LenhController@tamdunglenh')->name('tamdunglenh');
	Route::get('/savePos','LenhController@store')->name('savePos');
	Route::post('/unlock','LenhController@unlock')->name('unlock');
	Route::post('/removeLenh','LenhController@removeLenh')->name('removeLenh');
	Route::post('/createdk','LenhController@createdk')->name('createdk');
	Route::post('/nhapkho','LenhController@nhapkho')->name('nhapkho');
	Route::post('/note','LenhController@note')->name('note');
	Route::post('/showNote','LenhController@showNote')->name('showNote');
	Route::post('/qc','LenhController@qc')->name('qc');
	Route::post('/showQC','LenhController@showQC')->name('showQC');
	Route::post('/duyetqc','LenhController@duyetqc')->name('duyetqc');
	Route::post('/addVattu','LenhController@addVattu')->name('addVattu');
	Route::post('/showVatTu','LenhController@showVatTu')->name('showVatTu');
	Route::post('/qclenh','LenhController@qclenh')->name('qclenh');
	Route::post('/actiontimeqc','LenhController@actiontimeqc')->name('actiontimeqc');
	Route::post('/action','LenhController@action');

	Route::get('/boom','BoomController@index');
	// Route::get('/actionboom','BoomController@create')->name('actionboom');
	Route::post('/addactionboom','BoomController@store')->name('addactionboom');
	Route::post('/addVersion','BoomController@addVersion')->name('addVersion');
	Route::get('/editactionboom','BoomController@show');
	Route::post('/addLenh','BoomController@addLenh')->name('addLenh');
	Route::post('/updateboom','BoomController@update')->name('updateboom');
	Route::post('/moveboom','BoomController@edit')->name('moveboom');
	Route::post('/deleteboom','BoomController@destroy')->name('destroy.boom');

	Route::get('/quyngay','QuyNgayController@index');
	Route::post('/addtime','QuyNgayController@store')->name('addtime');
	Route::post('/changeDate','QuyNgayController@update')->name('changeDate');

	
	Route::post('/duyet','DuKienController@update')->name('duyet');
	Route::get('/dukien','DuKienController@index');
	Route::post('/addboom','DuKienController@store')->name('addboom');
	Route::get('/loadversion/{iditem}','DuKienController@show');
	Route::post('/edititem','DuKienController@edit')->name('edititem');
	Route::post('/import','DuKienController@import')->name('import');

	Route::get('/quyngaynew','QuyNgayNewController@index');
	Route::post('/quyngay','QuyNgayNewController@fillter')->name('fillter');
	Route::post('/addtimenew','QuyNgayNewController@store')->name('addtimenew');
	Route::post('/updatetimenew','QuyNgayNewController@update')->name('updatetimenew');

	Route::get('/user','UserController@index')->name('user');
	Route::get('/addUser','UserController@create');
	Route::post('/addUser','UserController@store')->name('addUser');
	Route::get('/editUser/{id}','UserController@edit');
	Route::post('/editUser','UserController@update')->name('editUser');
	Route::get('/editProfile/{id}_{username}','UserController@profile');
	Route::post('/editProfile','UserController@postprofile')->name('editProfile');
	Route::post('/add-image','UserController@avatar')->name('addAvatar');

	Route::get('/kien','KienController@index');
	Route::post('/addkien','KienController@store')->name('addkien');
	Route::get('version/{id}','KienController@show');
	Route::post('/deletekien','KienController@destroy')->name('destroy.kien');

	Route::get('/item','ItemController@index');
	Route::post('/additem','ItemController@store')->name('additem');
	Route::post('/deleteitem','ItemController@destroy')->name('destroy.item');

	Route::get('/role','RoleController@index')->name('roles.index');
	Route::get('/addRole','RoleController@create');
	Route::post('/addRole','RoleController@store')->name('addRole');
	Route::get('/editRole/{id}','RoleController@edit');
	Route::post('/editRole','RoleController@update')->name('editRole');
//QC
	Route::get('/maloi','QCController@index');
	Route::get('/nguyennhan','QCController@nguyennhan');
	Route::get('/kiemtra','QCController@kiemtra');
	Route::get('/suachua','QCController@suachua');
	Route::post('/addNguyenNhan','QCController@addnguyennhan')->name('action.nguyennhan');
	Route::post('/deleteNguyenNhan','QCController@deletenguyennhan')->name('delete.nguyennhan');
	Route::post('/addMaLoi','QCController@addmaloi')->name('action.maloi');
	Route::post('/deleteMaLoi','QCController@deletemaloi')->name('delete.maloi');
	Route::post('/addKiemTra','QCController@addkiemtra')->name('action.kiemtra');
	Route::post('/deleteKiemTra','QCController@deletekiemtra')->name('delete.kiemtra');
	Route::post('/addGiaiPhap','QCController@addgiaiphap')->name('action.giaiphap');
	Route::post('/deleteGiaiPhap','QCController@deletegiaiphap')->name('delete.giaiphap');
	Route::get('/findnguyennhan/{id}','QCController@shownguyennhan');
	Route::get('/findkiemtra/{id}','QCController@showkiemtra');
	Route::get('/findgiaiphap/{id}','QCController@showgiaiphap');
	Route::post('/deleteImgage','QCController@deleteimages')->name('delete.images');

//Quy định
	//Chế tài
	Route::get('/themCheTai','CheTaiController@themCheTai');
	Route::post('/saveCheTai','CheTaiController@saveCheTai');
	Route::get('/cheTai','CheTaiController@cheTai');
	Route::get('/editCheTai/{chetai_id}','CheTaiController@editCheTai');
	Route::post('/editCheTai/{chetai_id}','CheTaiController@updateEditCheTai');
	Route::get('/deleteCheTai/{chetai_id}','CheTaiController@deleteCheTai');



	//NGhỉ phép
	Route::get('/themXinNghi','XinNghiController@themXinNghi');
	Route::post('/saveXinNghi','XinNghiController@savexinNghi');
	Route::get('/xinNghi','XinNghiController@xinNghi');
	Route::get('/editXinNghi/{xinNghi_id}','XinNghiController@editXinNghi');
	Route::post('/editXinNghi/{xinNghi_id}','XinNghiController@updateEditXinNghi');
	Route::get('/deleteXinNghi/{xinNghi_id}','XinNghiController@deleteXinNghi');
	Route::get('/nhan-ban-giao/{xinNghi_id}','XinNghiController@nhanBanGiao');
	Route::get('/duyet-xin-nghi/{xinNghi_id}','XinNghiController@duyetXinNghi');

	//Quy trình
	Route::get('/quyTrinh','QuyTrinhController@quyTrinh');
	Route::get('/add-Quy-Trinh','QuyTrinhController@addQuyTrinh');
	Route::post('/save-Quy-Trinh','QuyTrinhController@save_quy_trinh');
	Route::get('/edit-quy-trinh/{id}','QuyTrinhController@edit_quy_trinh');
	Route::post('/edit-quy-trinh/{id}','QuyTrinhController@update_quy_trinh');
	Route::get('/delete-quy-trinh/{id}','QuyTrinhController@delete_quy_trinh');

	//Quy định
	Route::get('/quyDinh','QuyDinhController@quyDinh');
	Route::get('/add-Quy-Dinh','QuyDinhController@addQuyDinh');
	Route::post('/save-Quy-Dinh','QuyDinhController@save_quy_Dinh');
	Route::get('/edit-Quy-Dinh/{id}','QuyDinhController@edit_quy_Dinh');
	Route::post('/edit-Quy-Dinh/{quyDinh_id}','QuyDinhController@update_quy_Dinh');
	Route::get('/delete-Quy-Dinh/{quyDinh_id}','QuyDinhController@delete_quy_Dinh');


//CHi phí
	Route::get('/chiphi','ChiPhiController@index');
	Route::get('/show_tamung/{id}','ChiPhiController@showtamung');
	Route::post('/addchiphitu','ChiPhiController@addchiphitu')->name('addCP');

	Route::post('/mediaCP','ChiPhiController@media');
	// Route::post('/addbank','ChiPhiController@addbank')->name('addbank');
	Route::post('/search','ChiPhiController@search')->name('search');
	Route::post('/filterStatus','ChiPhiController@filterStatus');
	Route::post('/addComment','ChiPhiController@addComment');
	// Route::post('/duyethai','ChiPhiController@duyethai')->name('duyethai');
	Route::post('/importItem','ChiPhiController@import')->name('import');
	// Route::post('/duyetChiPhi','ChiPhiController@duyetChiPhi');
	// Route::post('/khongduyetChiPhi','ChiPhiController@khongduyetChiPhi');
	Route::post('/showComment','ChiPhiController@showComment');
	Route::get('/deletemedia/{id}','ChiPhiController@deletemedia');
	Route::post('/addchiphi','ChiPhiController@add')->name('addchiphi');
	Route::post('/editchiphi','ChiPhiController@edit')->name('editchiphi');
	// Route::post('/showChiPhi','ChiPhiController@showChiPhi');
	// Route::get('/destroychiphi/{id}','ChiPhiController@destroy');
	// Route::get('/sendchiphi/{id}','ChiPhiController@sendchiphi');
	Route::get('/loaichiphi','LoaiChiPhiController@index');
	Route::post('/addloaichiphi','LoaiChiPhiController@add')->name('addloaichiphi');
	Route::post('/editloaichiphi','LoaiChiPhiController@edit')->name('editloaichiphi');
	Route::get('/destroyloaichiphi/{id}','LoaiChiPhiController@destroy');

	Route::get('/vatlieu','VatLieuController@index');
	Route::get('/showline/{id}','VatLieuController@showline');
	Route::get('/showncc/{id}','VatLieuController@showncc');

	Route::post('/editChiPhi','ChiPhiNewController@edit')->name('addChiPhi');
	Route::post('/addChiPhi','ChiPhiNewController@add')->name('addChiPhi');
	Route::get('/chiphinew','ChiPhiNewController@index');
	Route::post('/showChiPhi','ChiPhiNewController@showChiPhi');
	Route::get('/destroychiphi/{id}','ChiPhiNewController@destroy');
	Route::get('/sendchiphi/{id}','ChiPhiNewController@sendchiphi');
	Route::get('/sendchiphil2/{id}','ChiPhiNewController@sendchiphil');
	Route::post('/duyetChiPhi','ChiPhiNewController@duyetChiPhi');
	Route::post('/khongduyetChiPhi','ChiPhiNewController@khongduyetChiPhi');
	Route::post('/addcheck','ChiPhiNewController@addcheck')->name('addcheck');
	Route::post('/duyethai','ChiPhiNewController@duyethai')->name('duyethai');
	Route::post('/addbank','ChiPhiNewController@addbank')->name('addbank');
	Route::get('/timeline/{id}','ChiPhiNewController@timeline')->name('timeline');

	Route::get('/kehoachmua','MuaHangController@index');
	Route::get('/showitems','MuaHangController@showitems');
	Route::get('/showdates','MuaHangController@showdates');
	Route::get('export', 'MuaHangController@export')->name('export');
	Route::post('/importkho','MuaHangController@importkho')->name('importkho');
	Route::post('/showtarget','MuaHangController@showtarget')->name('showtarget');

	Route::get('/target','TargetController@index');
	Route::post('/adddinhmuc','TargetController@add')->name('adddinhmuc');

});
Route::group(['middleware' => config('menu.middleware')], function () {
    $path = rtrim(config('menu.route_path'));
    Route::post($path . '/addcustommenu', array('as' => 'haddcustom', 'uses' => 'MenuController@addcustommenu'));
    Route::post($path . '/deleteitemmenu', array('as' => 'hdeleteitem', 'uses' => 'MenuController@deleteitemmenu'));
    Route::post($path . '/deletemenug', array('as' => 'hdeleteg', 'uses' => 'MenuController@deletemenug'));
    Route::post($path . '/createnewmenu', array('as' => 'hcreatenew', 'uses' => 'MenuController@createnewmenu'));
    Route::post($path . '/generatemenucontrol', array('as' => 'hgeneratecontrol', 'uses' => 'MenuController@generatemenucontrol'));
    Route::post($path . '/updateitem', array('as' => 'hupdate', 'uses' => 'MenuController@updateitem'));
});
 
Route::get('register', 'Auth\RegisterController@getRegister');
Route::post('register', 'Auth\RegisterController@postRegister');
 
Route::get('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@index']);
Route::post('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@postLogin']);
Route::get('logout', [ 'as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});