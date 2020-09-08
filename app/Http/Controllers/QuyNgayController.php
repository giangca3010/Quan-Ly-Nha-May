<?php

namespace App\Http\Controllers;

use App\QuyNgay;
use Illuminate\Http\Request;

class QuyNgayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name = 'Qũy Ngày';
        $action = 'Danh Sách';
        $quyngay = QuyNgay::orderBy("id", "desc")->get();

        return view('admin.quy-ngay',compact('name','action','quyngay'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // dd($request->all());
        if($request->date == null) {
            $date = QuyNgay::latest()->first();
            $today = ($date == null) ? date('Y-m-d') : date('Y-m-d',strtotime($date->date . "+1 days"));
            for ($i=0; $i < 500 ; $i++) { 
                $quyngay = new QuyNgay;
                $quyngay->date = date('Y-m-d',strtotime($today . "+".$i." days"));
                if(date('l',strtotime($today . "+".$i." days")) == 'Sunday') {
                    $quyngay->start_am = '00:00';
                    $quyngay->start_pm = '00:00';
                    $quyngay->end_am = '00:00';
                    $quyngay->end_pm = '00:00';
                }else{
                    $quyngay->start_am = '08:00';
                    $quyngay->start_pm = '13:00';
                    $quyngay->end_am = '12:00';
                    $quyngay->end_pm = '17:30';
                }
                $quyngay->save();
            }
        }else {
            // dd($request->date);
            $date = QuyNgay::where('date',date('Y-m-d',strtotime($request->date)))->first();
            if($date != null){
                $listId = QuyNgay::where('date','>',date('Y-m-d',strtotime($date->date . "-1 days")))->pluck('id');
                QuyNgay::destroy($listId);
            }
            $today = date('Y-m-d',strtotime($request->date));
            // dd($today);
            for ($i=0; $i < 500 ; $i++) { 
                $quyngay = new QuyNgay;
                $quyngay->date = date('Y-m-d',strtotime($today . "+".$i." days"));
                if(date('l',strtotime($today . "+".$i." days")) == 'Sunday') {
                    $quyngay->start_am = '00:00';
                    $quyngay->start_pm = '00:00';
                    $quyngay->end_am = '00:00';
                    $quyngay->end_pm = '00:00';
                }elseif($request->start_am == '00:00' and $request->start_pm == '00:00' and $request->end_am == '00:00' and $request->end_pm == '00:00'){
                    $quyngay->start_am = '08:00';
                    $quyngay->start_pm = '13:00';
                    $quyngay->end_am = '12:00';
                    $quyngay->end_pm = '17:30';
                }else{
                    $quyngay->start_am = $request->start_am;
                    $quyngay->start_pm = $request->start_pm;
                    $quyngay->end_am = $request->end_am;
                    $quyngay->end_pm = $request->end_pm;
                }
                $quyngay->save();
            }    
        }
        return response()->json([
                'status' => true,
                'message' => 'Cập Nhật Thành Công'
            ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QuyNgay  $quyNgay
     * @return \Illuminate\Http\Response
     */
    public function show(QuyNgay $quyNgay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuyNgay  $quyNgay
     * @return \Illuminate\Http\Response
     */
    public function edit(QuyNgay $quyNgay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QuyNgay  $quyNgay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuyNgay $quyNgay)
    {
        $quyngay = QuyNgay::find($request->id);
        $quyngay->start_am = $request->start_am;
        $quyngay->start_pm = $request->start_pm;
        $quyngay->end_am = $request->end_am;
        $quyngay->end_pm = $request->end_pm;
        $quyngay->save();
        return response()->json([
                'status' => true,
                'message' => 'Thêm Thành Công'
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QuyNgay  $quyNgay
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuyNgay $quyNgay)
    {
        //
    }
}
