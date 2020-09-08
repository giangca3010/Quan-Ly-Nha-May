<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NguyenNhan;
use App\MaLoi;
use App\KiemTra;
use App\MediaTaiLieu;
use Illuminate\Support\Facades\Storage;
use App\GiaiPhap;

class QCController extends Controller
{
    public function index()
    {
    	$name = 'Mã Lỗi';
        $action = 'Danh Sách';   
        $kiemtra = KiemTra::all();
        $nguyennhan = NguyenNhan::all();
        $suachua = GiaiPhap::all();
        $getData = MaLoi::all()->toArray();
        if ($getData == []) {
        	$dataQC = [];
        }else{
	        foreach ($getData as $key => $value) {
                $id1 = [];$id2 = [];$id3 = [];
	            $get = MediaTaiLieu::select('link')->where('id_ma',$value['id'])->where('roles',0)->get();
	            $getMedia = $get->map(function ($item, $key) {
	                return $item->link;
	            });
                $getMedia = $get->map(function ($item, $key) {
                    return $item->link;
                });
                foreach ($kiemtra as $item) {
                    if(!empty($item['id_ma'])) {
                        $ss = array_search($value['id'],json_decode($item['id_ma']));
                        if (!is_bool($ss))  {
                            $id1[] = $item['id'];
                        }
                    }
                }
                foreach ($nguyennhan as $item) {
                    if(!empty($item['id_ma'])) {
                        $ss = array_search($value['id'],json_decode($item['id_ma']));
                        if (!is_bool($ss))  {
                            $id2[] = $item['id'];
                        }
                    }
                }
                foreach ($suachua as $item) {
                    if(!empty($item['id_ma'])) {
                        $ss = array_search($value['id'],json_decode($item['id_ma']));
                        if (!is_bool($ss))  {
                            $id3[] = $item['id'];
                        }
                    }
                }
                $getKiemTra = KiemTra::whereIn('id',$id1)->get();
                $getNguyenNhan = NguyenNhan::whereIn('id',$id2)->get();
                $getSuaChua = GiaiPhap::whereIn('id',$id3)->get();
	            $dataQC[$key] = array_merge($getData[$key],['link'=>$getMedia],['kiemtra' => $getKiemTra],['nguyennhan' => $getNguyenNhan],['suachua' => $getSuaChua]);
	        }
        }
        return view('admin.qc.maloi',compact('name','action','dataQC','kiemtra','nguyennhan','suachua'));
    }

    public function nguyennhan()
    {
    	$name = 'Nguyên Nhân';
        $action = 'Danh Sách';   
        $getData = NguyenNhan::all()->toArray();
        $maloi = MaLoi::all();
        if ($getData == []) {
            $dataQC = [];
        }else{
            foreach ($getData as $key => $value) {
                if($value['id_ma'] == null ){
                    $getMaLoi = [];
                }else{
                    $getMa = MaLoi::whereIn('id',json_decode($value['id_ma']))->get();
                    $getMaLoi = $getMa->map(function ($item, $key) {
                        return $item->code;
                    });
                }
                $dataQC[$key] = array_merge($getData[$key],['code'=>$getMaLoi]);
            }
        }  
        // dd($dataQC);
        return view('admin.qc.nguyennhan',compact('name','action','dataQC','maloi'));
    }

    public function shownguyennhan($id)
    {
        $nguyennhan = NguyenNhan::get();
        // dd($nguyennhan);
        foreach ($nguyennhan as $key => $value) {
            if($value['id_ma'] != null){
                $check = array_search($id, json_decode($value['id_ma']));
                if (!is_bool($check)) {
                    $list[] = $value['id'];
                }
            }   
        }
        if (isset($list)) {
            $all = NguyenNhan::whereIn('id',$list)->get();
            foreach ($all as $v)
            {
                echo "<option value='".$v->id."'> ".$v->name."</option>";
            }
        }else{
            echo "<option value=''></option>";
        }
    }

    public function showkiemtra($id)
    {
        $kiemtra = KiemTra::get();
        // dd($nguyennhan);
        foreach ($kiemtra as $key => $value) {
            if($value['id_ma'] != null){
                $check = array_search($id, json_decode($value['id_ma']));
                if (!is_bool($check)) {
                    $list[] = $value['id'];
                }
            }   
        }
        if (isset($list)) {
            $all = KiemTra::whereIn('id',$list)->get();
            foreach ($all as $v)
            {
                echo "<option value='".$v->id."'> ".$v->huong_dan."</option>";
            }
        }else{
            echo "<option value=''></option>";
        }
    }

    public function showgiaiphap($id)
    {
        $giaiphap = GiaiPhap::get();
        foreach ($giaiphap as $key => $value) {
            if($value['id_ma'] != null){
                $check = array_search($id, json_decode($value['id_ma']));
                if (!is_bool($check)) {
                    $list[] = $value['id'];
                }
            }   
        }
        if (isset($list)) {
            $all = GiaiPhap::whereIn('id',$list)->get();
            foreach ($all as $v)
            {
                echo "<option value='".$v->id."'> ".$v->huong_dan."</option>";
            }
        }else{
            echo "<option value=''></option>";
        }
    }

    public function kiemtra()
    {
    	$name = 'Kiểm Tra';
        $action = 'Danh Sách'; 
        $getData = KiemTra::all()->toArray();
        $maloi = MaLoi::all();
        if ($getData == []) {
        	$dataQC = [];
        }else{
	        foreach ($getData as $key => $value) {
	            $get = MediaTaiLieu::select('link')->where('id_ma',$value['id'])->where('roles',1)->get();
	            $getMedia = $get->map(function ($item, $key) {
	                return $item->link;
	            });
        		if($value['id_ma'] == null ){
        			$getMaLoi = [];
        		}else{
		            $getMa = MaLoi::whereIn('id',json_decode($value['id_ma']))->get();
		            $getMaLoi = $getMa->map(function ($item, $key) {
		                return $item->code;
		            });
        		}

	            $dataQC[$key] = array_merge($getData[$key],['link'=>$getMedia],['code'=>$getMaLoi]);
	        }
        }  
        return view('admin.qc.kiemtra',compact('name','action','dataQC','maloi'));
    }

    public function suachua()
    {
    	$name = 'Sửa Chữa';
        $action = 'Danh Sách'; 
        $getData = GiaiPhap::all()->toArray();
        $maloi = MaLoi::all();
        if ($getData == []) {
            $dataQC = [];
        }else{
            foreach ($getData as $key => $value) {
                $get = MediaTaiLieu::select('link')->where('id_ma',$value['id'])->where('roles',2)->get();
                $getMedia = $get->map(function ($item, $key) {
                    return $item->link;
                });
                if($value['id_ma'] == null ){
                    $getMaLoi = [];
                }else{
                    $getMa = MaLoi::whereIn('id',json_decode($value['id_ma']))->get();
                    $getMaLoi = $getMa->map(function ($item, $key) {
                        return $item->code;
                    });

                }

                $dataQC[$key] = array_merge($getData[$key],['link'=>$getMedia],['code'=>$getMaLoi]);
            }
        } 
        return view('admin.qc.giaiphap',compact('name','action','dataQC','maloi'));
    }

    public function addnguyennhan(Request $request)
    {
    	if($request->id == null) {
	    	$nguyennhan = new NguyenNhan();
            $nguyennhan->id_ma = $request->id_ma == null ? null : json_encode(array_values(array_filter($request->id_ma)));
	        $nguyennhan->name = request()->input("name");
	        $nguyennhan->note = request()->input("note");
	        $nguyennhan->save();
    	}else {
    		$nguyennhan = NguyenNhan::find($request->id);
            $nguyennhan->id_ma = $request->id_ma == null ? null : json_encode(array_values(array_filter($request->id_ma)));
    		$nguyennhan->name = request()->input("name");
	        $nguyennhan->note = request()->input("note");
	        $nguyennhan->save();
    	}
        return response()->json([
            'status' => true,
            'message' => 'Thao Tác Thành Công'
        ], 200);
    }

    public function deletenguyennhan(Request $request)
    {
    	$nguyennhan = NguyenNhan::find($request->id);
        $nguyennhan->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa Thành Công'
        ], 200);
    }

    public function addmaloi(Request $request)
    {
        // dd($request->all());
    	if($request->id == null) {
	    	$maloi = new MaLoi();
	        $maloi->name = request()->input("name");
	        $maloi->note = request()->input("note");
	        $maloi->code = request()->input("code");
	        $maloi->mucdo = request()->input("mucdo");
	        $maloi->bophan = request()->input("bophan");
	        $maloi->save();
	        if ($request->file != null) {
	            foreach($request->file as $file) {
	                if (is_file($file)) {
	                    $new_name = rand().'.'.$file->getClientOriginalExtension();
	                    Storage::disk('public_uploads')->putFileAs('tailieu', $file, $new_name);
	                    $media = new MediaTaiLieu;
	                    $media->roles = 0;
	        			$media->id_ma = $maloi->id;
	                    $media->link = '/storage/tailieu/'.$new_name;
	                    $media->save();
	                }

	            }
	        }
    	}else {
    		$maloi = MaLoi::find($request->id);
	        $maloi->name = request()->input("name");
	        $maloi->note = request()->input("note");
	        $maloi->code = request()->input("code");
	        $maloi->mucdo = request()->input("mucdo");
	        $maloi->bophan = request()->input("bophan");
            $array = explode(',', $request->kiemtra_old);
            $array1 = explode(',', $request->nguyennhan_old);
            $array2 = explode(',', $request->suachua_old);
            if($request->kiem_tra != []){
                foreach ($array as $k => $v) {
                    $check = array_search($v, array_filter($request->kiem_tra));
                    if(is_bool($check)){
                        $list[] = $v;
                    }
                }
                if (isset($list)) {
                    $delete = KiemTra::whereIn('id',$list)->get();
                    foreach ($delete as $key => $value) {
                        $messages = json_decode($value['id_ma']);
                        if (($key = array_search($request->id, $messages)) !== false) {
                            unset($messages[$key]);
                        }
                        $save = KiemTra::find($value['id']);
                        $save->id_ma = json_encode(array_values($messages));
                        $save->save();
                    }
                }
	            $idadd = array_diff(array_filter($request->kiem_tra), $array);
				$add = KiemTra::whereIn('id',$idadd)->get();
				foreach ($add as $key => $value) {
					$kiemtra = KiemTra::find($value['id']);
					$list_id = json_decode($value['id_ma']);
					$list_id[] = $request->id;
					$kiemtra->id_ma = json_encode($list_id);
					$kiemtra->save();
				}
            }else{
            	$delete = KiemTra::whereIn('id',$array)->get();
                foreach ($delete as $key => $value) {
                    $messages = json_decode($value['id_ma']);
                    if (($key = array_search($request->id, $messages)) !== false) {
                        unset($messages[$key]);
                    }
                    $save = KiemTra::find($value['id']);
                    $save->id_ma = json_encode(array_values($messages));
                    $save->save();
                }
            }

            if($request->nguyen_nhan != []){
                foreach ($array1 as $k => $v) {
                    $check = array_search($v, array_filter($request->nguyen_nhan));
                    if(is_bool($check)){
                        $list[] = $v;
                    }
                }
                if (isset($list)) {
                    $delete = NguyenNhan::whereIn('id',$list)->get();
                    foreach ($delete as $key => $value) {
                        $messages = json_decode($value['id_ma']);
                        if (($key = array_search($request->id, $messages)) !== false) {
                            unset($messages[$key]);
                        }
                        // dd($messages);
                        $save = NguyenNhan::find($value['id']);
                        $save->id_ma = json_encode(array_values($messages));
                        $save->save();
                    }
                }
                $idadd = array_diff(array_filter($request->nguyen_nhan), $array1);
                $add = NguyenNhan::whereIn('id',$idadd)->get();
                foreach ($add as $key => $value) {
                    $nguyennhan = NguyenNhan::find($value['id']);
                    $list_id = json_decode($value['id_ma']);
                    $list_id[] = $request->id;
                    // dd($list_id);
                    $nguyennhan->id_ma = json_encode($list_id);
                    $nguyennhan->save();
                }
            }else{
                $delete = NguyenNhan::whereIn('id',$array1)->get();
                foreach ($delete as $key => $value) {
                    $messages = json_decode($value['id_ma']);
                    if (($key = array_search($request->id, $messages)) !== false) {
                        unset($messages[$key]);
                    }
                    $save = NguyenNhan::find($value['id']);
                    $save->id_ma = json_encode(array_values($messages));
                    $save->save();
                }
            }

            if($request->sua_chua != []){
                foreach ($array2 as $k => $v) {
                    $check = array_search($v, array_filter($request->sua_chua));
                    if(is_bool($check)){
                        $list[] = $v;
                    }
                }
                if (isset($list)) {
                    $delete = GiaiPhap::whereIn('id',$list)->get();
                    foreach ($delete as $key => $value) {
                        $messages = json_decode($value['id_ma']);
                        if (($key = array_search($request->id, $messages)) !== false) {
                            unset($messages[$key]);
                        }
                        $save = GiaiPhap::find($value['id']);
                        $save->id_ma = json_encode(array_values($messages));
                        $save->save();
                    }
                }
                $idadd = array_diff(array_filter($request->sua_chua), $array2);
                $add = GiaiPhap::whereIn('id',$idadd)->get();
                foreach ($add as $key => $value) {
                    $kiemtra = GiaiPhap::find($value['id']);
                    $list_id = json_decode($value['id_ma']);
                    $list_id[] = $request->id;
                    $kiemtra->id_ma = json_encode($list_id);
                    $kiemtra->save();
                }
            }else{
                $delete = GiaiPhap::whereIn('id',$array2)->get();
                foreach ($delete as $key => $value) {
                    $messages = json_decode($value['id_ma']);
                    if (($key = array_search($request->id, $messages)) !== false) {
                        unset($messages[$key]);
                    }
                    $save = GiaiPhap::find($value['id']);
                    $save->id_ma = json_encode(array_values($messages));
                    $save->save();
                }
            }

	        if ($request->file != null) {
	            foreach($request->file as $file) {
	                if (is_file($file)) {
	                    $new_name = rand().'.'.$file->getClientOriginalExtension();
	                    Storage::disk('public_uploads')->putFileAs('tailieu', $file, $new_name);
	                    $media = new MediaTaiLieu;
	        			$media->id_ma = $maloi->id;
	        			$media->roles = 0;
	                    $media->link = '/storage/tailieu/'.$new_name;
	                    $media->save();
	                }

	            }
	        }
	        $maloi->save();
    	}
        return response()->json([
            'status' => true,
            'message' => 'Thao Tác Thành Công'
        ], 200);
    }

    public function deletemaloi(Request $request)
    {
    	$nguyennhan = MaLoi::find($request->id);
        $nguyennhan->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa Thành Công'
        ], 200);
    }

    public function addkiemtra(Request $request)
    {
    	if($request->id == null) {
	    	$kiemtra = new KiemTra();
	        $kiemtra->id_ma = $request->id_ma == null ? null : json_encode(array_values(array_filter($request->id_ma)));
	        $kiemtra->quy_trinh = request()->input("quytrinh");
	        $kiemtra->dinh_muc = request()->input("dinhmuc");
	        $kiemtra->huong_dan = request()->input("huongdan");
	        $kiemtra->nhan_vien = request()->input("nhanvien");
	        $kiemtra->save();
	        if ($request->file != null) {
	            foreach($request->file as $file) {
	                if (is_file($file)) {
	                    $new_name = rand().'.'.$file->getClientOriginalExtension();
	                    Storage::disk('public_uploads')->putFileAs('tailieu', $file, $new_name);
	                    $media = new MediaTaiLieu;
	                    $media->roles = 1;
	        			$media->id_ma = $kiemtra->id;
	                    $media->link = '/storage/tailieu/'.$new_name;
	                    $media->save();
	                }

	            }
	        }
    	}else {
    		$kiemtra = KiemTra::find($request->id);
	        $kiemtra->id_ma = $request->id_ma == null ? null : json_encode(array_values(array_filter($request->id_ma)));
	        $kiemtra->quy_trinh = request()->input("quytrinh");
	        $kiemtra->dinh_muc = request()->input("dinhmuc");
	        $kiemtra->huong_dan = request()->input("huongdan");
	        $kiemtra->nhan_vien = request()->input("nhanvien");
	        if ($request->file != null) {
	            foreach($request->file as $file) {
	                if (is_file($file)) {
	                    $new_name = rand().'.'.$file->getClientOriginalExtension();
	                    Storage::disk('public_uploads')->putFileAs('tailieu', $file, $new_name);
	                    $media = new MediaTaiLieu;
	        			$media->id_ma = $kiemtra->id;
	        			$media->roles = 1;
	                    $media->link = '/storage/tailieu/'.$new_name;
	                    $media->save();
	                }

	            }
	        }
	        $kiemtra->save();
    	}
        return response()->json([
            'status' => true,
            'message' => 'Thao Tác Thành Công'
        ], 200);
    }

    public function deletekiemtra(Request $request)
    {
    	$nguyennhan = KiemTra::find($request->id);
        $nguyennhan->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa Thành Công'
        ], 200);
    }


    public function addgiaiphap(Request $request)
    {
        // dd(json_encode($request->id_ma));
        if($request->id == null) {
            $giaiphap = new GiaiPhap();
            $giaiphap->id_ma = json_encode($request->id_ma);
            $giaiphap->quy_trinh = request()->input("quytrinh");
            $giaiphap->huong_dan = request()->input("huongdan");
            $giaiphap->nhan_vien = request()->input("nhanvien");
            $giaiphap->save();
            if ($request->file != null) {
                foreach($request->file as $file) {
                    if (is_file($file)) {
                        $new_name = rand().'.'.$file->getClientOriginalExtension();
                        Storage::disk('public_uploads')->putFileAs('tailieu', $file, $new_name);
                        $media = new MediaTaiLieu;
                        $media->roles = 2;
                        $media->id_ma = $giaiphap->id;
                        $media->link = '/storage/tailieu/'.$new_name;
                        $media->save();
                    }

                }
            }
        }else {
            $giaiphap = GiaiPhap::find($request->id);
            $giaiphap->id_ma = json_encode( request()->input("id_ma") );
            $giaiphap->quy_trinh = request()->input("quytrinh");
            $giaiphap->huong_dan = request()->input("huongdan");
            $giaiphap->nhan_vien = request()->input("nhanvien");
            if ($request->file != null) {
                foreach($request->file as $file) {
                    if (is_file($file)) {
                        $new_name = rand().'.'.$file->getClientOriginalExtension();
                        Storage::disk('public_uploads')->putFileAs('tailieu', $file, $new_name);
                        $media = new MediaTaiLieu;
                        $media->id_ma = $giaiphap->id;
                        $media->roles = 2;
                        $media->link = '/storage/tailieu/'.$new_name;
                        $media->save();
                    }

                }
            }
            $giaiphap->save();
        }
        return response()->json([
            'status' => true,
            'message' => 'Thao Tác Thành Công'
        ], 200);
    }

    public function deleteGiaiPhap(Request $request)
    {
        $giaiphap = GiaiPhap::find($request->id);
        $giaiphap->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa Thành Công'
        ], 200);
    }

    public function deleteimages(Request $request)
    {
        $ex = explode('/', $request->link);
        unset($ex[0],$ex[1]);
        $im = implode('/',$ex);
        MediaTaiLieu::where('roles',$request->type)->where('link',$request->link)->first()->delete();
        Storage::disk('public_uploads')->delete($im);
        return response()->json([
            'status' => true,
            'message' => 'Xóa Thành Công'
        ], 200);
    }
}
