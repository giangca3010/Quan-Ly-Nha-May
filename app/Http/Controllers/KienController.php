<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kien;
use App\Boom;

class KienController extends Controller
{
    public function index(Request $request)
    {
        $name = 'Kiện';
        $action = 'Danh Sách';
        $kien = Kien::where('menu',$request->menu_id)->get();
        $boom = Boom::where('parent',0)->where('menu',$request->menu_id)->pluck('name')->toArray();
        $item = collect(array_unique($boom));
        if(count($boom) != 0) {
            $version = Boom::where('name',$boom[0])->get();
        }else{
            $version = [];
        }
        return view('admin.kien',compact('name','action','kien','item','version'));
    }

    public function show($id)
    {
        $ver = Boom::where('name',$id)->get();
        foreach ($ver as $v)
        {
            echo "<option value='".$v->version."'> Version ".$v->version."</option>";
        }
    }

    public function store(Request $request)
    {
        $boom = Boom::where('parent',0)->where('name',$request->boom)->where('menu',$request->menu_id)->where('version',$request->ver)->get();
        $boomsons = Boom::where('parent',$boom[0]->id)->orderBy('sort', 'asc')->get();
        $merge = $boom->merge($boomsons);

        foreach ($merge as $key => $value) {
            $kien = new Kien;
            $idParent = Kien::where('parent', 0)->orderBy('id', 'desc')->first();
            if ($value->parent == 0) {
		        $kien->parent = 0;
	            $kien->sort = 0;  
	            $kien->name = $request->name;
            }else {
	            $kien->name = $value->name;
            	$kien->parent = $idParent->id;
	            $kien->sort = $value->sort;  
            }
            $kien->dinhmuc = $value->dinhmuc;
            $kien->tre = $value->tre;
            $kien->depth = $value->depth;
            $kien->status = $value->status;
        	$kien->opposites = $value->opposites;
            $kien->menu = $request->menu_id;
            $kien->note = $request->mota;
            $kien->save();
        }
        return response()->json([
            'status' => true,
            'message' => 'Cập Nhật Thành Công'
        ], 200);
    }

    public function destroy(Request $request)
    {
        Kien::where('id',$request->id)->delete();
        Kien::where('parent',$request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa Thành Công'
        ], 200);
    }
}
