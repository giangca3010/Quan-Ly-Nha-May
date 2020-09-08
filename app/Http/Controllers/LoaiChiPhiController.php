<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiChiPhi;

class LoaiChiPhiController extends Controller
{
	public function index()
	{
	    $name = 'Loại Chi Phí';
	    $action = 'Danh Sách';
	    $loaichiphi = LoaiChiPhi::get();
		
	    return view('admin.chiphi.loaichiphi',compact('name','action','loaichiphi'));
	}

	public function add(Request $request)
	{
		LoaiChiPhi::create($request->all());
		return response()->json([
            'status' => true,
            'message' => 'Thêm Thành Công'
        ], 200);
	}

	public function destroy($id)
	{
		LoaiChiPhi::find($id)->delete();
		return redirect('loaichiphi');
	}

	public function edit(Request $request)
	{
		$edit = LoaiChiPhi::find($request->id);
		$edit->name_lcp = $request->name_lcp;
		$edit->ma_sp = $request->ma_sp;
		$edit->sl_nk = $request->sl_nk;
		$edit->note = $request->note;
		$edit->save();
		return response()->json([
            'status' => true,
            'message' => 'Sửa Thành Công'
        ], 200);
	}
}
