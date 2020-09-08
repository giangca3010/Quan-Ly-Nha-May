<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\chetai;
use App\quytrinh;
use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
Session_start();


class QuyDinhController extends Controller
{
    public function quyDinh()
    {
    	$name = "Quy Định";
    	$action = "Danh sách";

        // $dataUsers = DB::table('users')->get();
        // $dataQT = DB::table('quytrinh')->get();
        // $dataCT = DB::table('chetai')->get();
        $allQuyDinh = DB::table('quydinh')->get();
        $QD = $allQuyDinh->map(function($value){

            return[
                'quyDinh_id' => $value -> quyDinh_id,
                'quyDinh_name' => $value -> quyDinh_name,
                'quyTrinh_id'=> quytrinh::find($value->quyTrinh_id)->attributesToArray()['ten_quy_trinh'],
                'noiDung' => $value -> noiDung,
                'cheTai_1'=> chetai::find($value->cheTai_1)->attributesToArray()['chetai_name'],
                'cheTai_2'=> empty($value->cheTai_2) ? '' : chetai::find($value->cheTai_2)->attributesToArray()['chetai_name'],
                'cheTai_3'=> empty($value->cheTai_3) ? '' : chetai::find($value->cheTai_3)->attributesToArray()['chetai_name'],
                'cheTai_4'=> empty($value->cheTai_4) ? '' : chetai::find($value->cheTai_4)->attributesToArray()['chetai_name'],
                'cheTai_5'=> empty($value->cheTai_5) ? '' : chetai::find($value->cheTai_5)->attributesToArray()['chetai_name'],
                'boPhanAd'=> role::whereIn('id',json_decode($value->roles_id_1))->get(),
                'boPhanGs'=> role::whereIn('id',json_decode($value->roles_id_2))->get(),
                'maGiamSat' => $value -> maGiamSat,
            ];
        });
        // dd($QD);
    	return view('admin.quyDinh.quyDinh.quyDinh', compact('name', 'action', 'QD', ));
    }

    public function addQuyDinh()
    {   

        $name = "Quy Định";
        $action = "Thêm";
        $dataQT = DB::table('quytrinh')->get();
        $dataCT = DB::table('chetais')->get();
        $dataRoles = DB::table('roles')->get();
        $allQuyDinh = DB::table('quydinh')->get();
    	
    	return view ('admin.quyDinh.quyDinh.addQuyDinh', compact('name', 'action', 'dataQT', 'dataCT', 'allQuyDinh', 'dataRoles'));
    }

    public function save_quy_Dinh(Request $Request){
        $quyDinh = array();
        $giamsat = json_encode($Request->boPhan2);

        // dd();

        $quyDinh['quyDinh_name'] = $Request -> quyDinh_name;
        $quyDinh['quyTrinh_id'] = $Request -> quyTrinh_id;
        $quyDinh['noiDung'] = $Request -> noiDung;
        $quyDinh['cheTai_1'] = $Request -> cheTai_1;
        $quyDinh['cheTai_2'] = $Request -> cheTai_2;
        $quyDinh['cheTai_3'] = $Request -> cheTai_3;
        $quyDinh['cheTai_4'] = $Request -> cheTai_4;
        $quyDinh['cheTai_5'] = $Request -> cheTai_5;
        $quyDinh['roles_id_1'] = json_encode($Request->boPhan1);
        $quyDinh['roles_id_2'] = $giamsat == 'null' ? '[]' : $giamsat;
        $quyDinh['maGiamSat'] = $Request -> maGiamSat;

        DB::table('quydinh') -> insert($quyDinh);
        
        return redirect('/quyDinh');
    }

    public function edit_quy_Dinh($quyDinh_id){
        $name = "Sửa Xin Nghỉ";
        $action = "Sửa";
        $dataQT = DB::table('quytrinh')->get();
        $dataCT = DB::table('chetais')->get();
        $dataRoles = DB::table('roles')->get();
        $allQuyDinh = DB::table('quydinh')->get();
        $editQuyDinh = DB::table('quydinh')
            ->where('quyDinh_id', '=', $quyDinh_id)
            ->first()
        ;
        return view('admin.quyDinh.quyDinh.editQuyDinh',['name'=>$name, 'action'=>$action, 'dataQT'=>$dataQT, 'dataRoles'=>$dataRoles, 'editQuyDinh'=>$editQuyDinh, 'dataCT'=>$dataCT] );
        // return view('admin.quyDinh.quyDinh.editQuyDinh');

    }




















}
