<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Kien;
use App\DuKien;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $name = 'Item';
        $action = 'Danh Sách';
        $kien = Kien::where('parent',0)->where('menu',$request->menu_id)->get();
		
		$item = Item::where('menu',$request->menu_id)->get();
		$map = $item->map(function ($value){
			if ($value->kien_id != 'null') {
				$value->list_kien = Kien::whereIn('id',json_decode($value->kien_id))->get();
			}
			return $value;
		});        
        return view('admin.item',compact('name','action','kien','map'));
    }

    public function store(Request $request)
    {
        $item = new Item;
        $item->name = $request->name;
        $item->menu = $request->menu_id;
        $item->code = $request->name.'_'.$request->soluong;
        $item->so_luong = $request->soluong;
        $item->kien_id	 = json_encode($request->kien);
        $item->note = $request->mota;
        $item->save();
        return response()->json([
            'status' => true,
            'message' => 'Thêm Thành Công'
        ], 200);
    }

    public function destroy(Request $request)
    {
        $item = Item::find($request->id);
        $item->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa Thành Công'
        ], 200);
    }
}
