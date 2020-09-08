<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\chetai;
use Spatie\Permission\Models\Role;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
Session_start();

class CheTaiController extends Controller
{

//---<CHE TAI>
	public function cheTai()
	{
		$name = "Chế Tài";
		$action ="Danh sách";
		$allCheTai = DB::table('chetai')-> get();
		return view('admin.quyDinh.cheTai.chetai',compact('name','action'), ['allCheTai'=>$allCheTai]);
		
	}

	// public function themCheTai()
	// {
	// 	$name = "Thêm chế tài";
	// 	$action ="Danh sách";
	// 	return view('admin.quyDinh.cheTai.themCheTai', compact('name', 'action'));
	// }
	// public function saveCheTai(Request $request)
 //    {

 //        $rawData = request() -> all();
 //        DB::table('chetai')->insert(
 //            [
 //                'chetai_name' => $rawData['chetai_name'],
 //                'chetai_mota' => $rawData['chetai_mota'],

 //            ]);
 //        return redirect('/cheTai');
 //    }

 //    public function editCheTai($chetai_id){
 //    	$name = "Chế Tài";
	// 	$action ="Sửa";
	// 	$editCheTai = DB::table('chetai')
	// 		->where('chetai_id','=', $chetai_id)
	// 		->first()
	// 	;
	// 	return view('admin.quyDinh.cheTai.editCheTai', 
	// 		['editCheTai'=>$editCheTai, 'name'=>$name, 'action'=>$action]);
 //    }

 //    public function updateEditCheTai($chetai_id){
 //    	$rawData = request() -> input();
 //    	$dataUpdate = [
 //    		'chetai_name' => $rawData['chetai_name'],
 //            'chetai_mota' => $rawData['chetai_mota'],
 //    	];
 //    	DB::table('chetai')
 //            ->where('chetai_id', '=', $chetai_id)
 //            ->update($dataUpdate)
 //        ;
 //        return redirect('/cheTai');
 //    }

 //    public function deleteCheTai($chetai_id)
 //    {
 //    	DB::table('chetai')
	//     	->where('chetai_id', '=', $chetai_id)
	//     	->delete()
 //    	;
 //    	return redirect('/cheTai');
 //    }
//!!!</CHE TAI>


//---<XIN NGHI>

    public function xinNghi(){
    	$name = "Xin Nghỉ";
		$action ="Danh sách";
		$dataUsers = DB::table('users')->get();
		$allXinNghi = DB::table('xinNghi')-> get();
		$xin = $allXinNghi->map(function($value){
			return [
				'ngayNghi' => $value->ngayNghi,
				'login' => \Auth::user()->id,
				'xinNghi_id' => $value->xinNghi_id,
				'soDienThoai' => $value->soDienThoai,
				'lyDo' => $value->lyDo,
				'banGiao' => $value->banGiao,
				'ngayXinNghi' => $value->ngayXinNghi,
				'status_xinNghi' => $value->status_xinNghi,
				'ketThucNgay' => $value->ketThucNgay,
				'trangThaiNghi' => $value->trangThaiNghi,
				'user1'=> User::find($value->id_user1)->attributesToArray()['name'],
				'user2'=> User::find($value->id_user2)->attributesToArray()['name'],
				'user3'=> User::find($value->id_user3)->attributesToArray()['name'],
				'id_roles'=> Role::find($value->id_roles)->attributesToArray()['name'],
				'id_user1'=> $value->id_user1,
				'id_user2'=> $value->id_user2,
				'id_user3'=> $value->id_user3,
			
			];
		});

		// dd($xin);
		return view('admin.quyDinh.xinNghi.xinNghi',compact('name','action', 'xin', 'dataUsers'));
    }

    public function themXinNghi(){
    	$name = "Tạo đơn xin nghỉ";
		$action ="Danh sách";
		$dataUsers = DB::table('users')->get();
		$dataRoles = DB::table('roles')->get();
		$allXinNghi = DB::table('xinNghi')-> get();

		return view('admin.quyDinh.xinNghi.themXinNghi', compact('name', 'action', 'dataUsers', 'dataRoles', 'allXinNghi'));
    }

    public function saveXinNghi(Request $request){
        $xinNghi = array();
        $xinNghi['id_user1'] = $request -> name_user1;
        $xinNghi['id_roles'] = $request -> name_boPhan;
        $xinNghi['id_user2'] = $request -> name_user2;
        $xinNghi['ngayNghi'] = $request -> ngayNghi ;
        $xinNghi['soDienThoai'] = $request -> soDienThoai;
        $xinNghi['lyDo'] = $request -> lyDo;
        $xinNghi['banGiao'] = $request -> banGiao;
        $xinNghi['id_user3'] = $request -> name_user3;
        $xinNghi['ngayXinNghi'] = $request -> ngayXinNghi;
        $xinNghi['ketThucNgay'] = $request -> ketThucNgay;
        $xinNghi['trangThaiNghi'] = $request -> trangThaiNghi;

        DB::table('xinNghi')->insert($xinNghi);
        return redirect('/xinNghi');
    }

    public function editXinNghi($xinNghi_id){
    	$name = "Sửa Xin Nghỉ";
		$action ="Sửa";
		$dataUsers = DB::table('users')->get();
		$dataRoles = DB::table('roles')->get();
		$allXinNghi = DB::table('xinNghi')-> get();
		$editXinNghi = DB::table('xinNghi')
			->where('xinNghi_id','=', $xinNghi_id)
			->first()
		;
		// dd($editXinNghi);
		return view('admin.quyDinh.xinNghi.editXinNghi', 
			['editXinNghi'=>$editXinNghi, 'name'=>$name, 'action'=>$action, 'dataUsers'=> $dataUsers, 'dataRoles'=>$dataRoles],  );
    }

    public function deleteXinNghi($xinNghi_id){
    	DB::table('xinNghi')
	    	->where('xinNghi_id', '=', $xinNghi_id)
	    	->delete()
    	;
    	return redirect('/xinNghi');
    }

    public function nhanBanGiao($xinNghi_id){
		$status_xinNghi = DB::table('xinNghi')
			->where('xinNghi_id', $xinNghi_id)
			->update('status_xinNghi' == 1);
			return redirect('/xinNghi');
    }

    public function duyetXinNghi($xinNghi_id){
		$status_xinNghi = DB::table('xinNghi')
			->where('xinNghi_id', $xinNghi_id)
			->update('status_xinNghi' == 2);
			return redirect('/xinNghi');
    }



    




//!!!</XIN NGHI>

}
