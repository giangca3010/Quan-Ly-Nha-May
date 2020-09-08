<?php

namespace App\Http\Controllers;

use App\QuyNgayNew;
use Illuminate\Http\Request;
use App\CongDoan;
use Carbon\Carbon;

class QuyNgayNewController extends Controller
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
        $congdoan = CongDoan::all();

        $quyngay = QuyNgayNew::join('cong_doan', 'quy_ngay_news.name_id', '=', 'cong_doan.id')->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $group = $quyngay->groupBy(function($value){
            return $value->date;
        });
        // dd(Carbon::now()->startOfWeek()); 
        return view('admin.quyngay',compact('name','action','congdoan','group'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fillter(Request $request)
    {
        $name = 'Qũy Ngày';
        $action = 'Danh Sách';
        $congdoan = CongDoan::all();
        $ex = explode("-",$request->range);
        $start = new Carbon(date('Y-m-d',strtotime(trim($ex[0]))));
        $end = new Carbon(date('Y-m-d',strtotime(trim($ex[1]))));
        dd($start);

        $quyngay = QuyNgayNew::join('cong_doan', 'quy_ngay_news.name_id', '=', 'cong_doan.id')->whereBetween('date', [$start, $end])->get();
        dd($quyngay);
        $group = $quyngay->groupBy(function($value){
            return $value->date;
        });
        return view('admin.quyngay',compact('name','action','congdoan','group'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $congdoan = CongDoan::all()->count();
        $count = $congdoan + 1;
        if($request->date == null) {
            $date = QuyNgayNew::latest()->first();
            // dd($congdoan);
            $today = ($date == null) ? date('Y-m-d') : date('Y-m-d',strtotime($date->date . "+1 days"));
            for($j=1; $j < $count; $j++) {
                for ($i=0; $i < 500 ; $i++) { 
                    $quyngay = new QuyNgayNew;
                    $quyngay->date = date('Y-m-d',strtotime($today . "+".$i." days"));
                    if(date('l',strtotime($today . "+".$i." days")) == 'Sunday') {
                        $quyngay->start_am = '08:30';
                        $quyngay->end_am = '08:30';
                        $quyngay->start_pm = '17:30';
                        $quyngay->end_pm = '17:30';
                        $quyngay->start_up = '19:00';
                        $quyngay->end_up = '19:00';
                        $quyngay->time_work = '00:00';
                    }else{
                        $quyngay->start_am = '08:30';
                        $quyngay->start_pm = '13:00';
                        $quyngay->end_am = '12:00';
                        $quyngay->end_pm = '17:30';
                        $quyngay->start_up = '19:00';
                        $quyngay->end_up = '19:00';
                        $quyngay->time_work = '08:00';
                    }
                    $quyngay->menu = 1;
                    $quyngay->name_id = $j;
                    $quyngay->save();
                }
            }
        }else {
            // dd($request->date);
            $date = QuyNgayNew::where('date',date('Y-m-d',strtotime($request->date)))->first();
            if($date != null){
                $listId = QuyNgayNew::where('date','>',date('Y-m-d',strtotime($date->date . "-1 days")))->pluck('id');
                QuyNgayNew::destroy($listId);
            }
            $today = date('Y-m-d',strtotime($request->date));
            date_default_timezone_set('UTC');
            for($j=1; $j < $count; $j++) {
                for ($i=0; $i < 500 ; $i++) { 
                    $quyngay = new QuyNgayNew;
                    $quyngay->date = date('Y-m-d',strtotime($today . "+".$i." days"));
                    if(date('l',strtotime($today . "+".$i." days")) == 'Sunday') {
                        $quyngay->start_am = '08:30';
                        $quyngay->end_am = '08:30';
                        $quyngay->start_pm = '17:30';
                        $quyngay->end_pm = '17:30';
                        $quyngay->start_up = '19:00';
                        $quyngay->end_up = '19:00';
                        $quyngay->time_work = '00:00';
                    }elseif($request->start_am == null and $request->start_pm == null and $request->end_am == null and $request->end_pm == null){
                        $quyngay->start_am = '08:30';
                        $quyngay->start_pm = '13:00';
                        $quyngay->end_am = '12:00';
                        $quyngay->end_pm = '17:30';
                        $quyngay->start_up = '19:00';
                        $quyngay->end_up = '19:00';
                        $quyngay->time_work = '08:00';
                    }else{
                        $quyngay->start_am = $request->start_am;
                        $quyngay->start_pm = $request->start_pm;
                        $quyngay->end_am = $request->end_am;
                        $quyngay->end_pm = $request->end_pm;
                        $quyngay->start_up = $request->start_up;
                        $quyngay->end_up = $request->end_up;
                        $hour = strtotime($request->end_pm) + strtotime($request->end_pm) + strtotime($request->end_up) - strtotime($request->start_am) - strtotime($request->start_pm) - strtotime($request->start_up);
                        $quyngay->time_work = date('H:i',$hour);
                    }
                    $quyngay->menu = 1;
                    $quyngay->name_id = $j;
                    $quyngay->save();
                }   
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
     * @param  \App\QuyNgayNew  $quyNgayNew
     * @return \Illuminate\Http\Response
     */
    public function show(QuyNgayNew $quyNgayNew)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuyNgayNew  $quyNgayNew
     * @return \Illuminate\Http\Response
     */
    public function edit(QuyNgayNew $quyNgayNew)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QuyNgayNew  $quyNgayNew
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuyNgayNew $quyNgayNew)
    {
        // dd($request->all());
        date_default_timezone_set('UTC');
        if ($request->check == 'true') {
            $quyngay = QuyNgayNew::where('date',$request->date)->get();
            foreach ($quyngay as $key => $value) {
                if($request->pos == 1) {
                    $hour = strtotime($value->end_am) + strtotime($value->end_pm) + strtotime($value->end_up) - strtotime($request->time) - strtotime($value->start_pm) - strtotime($value->start_up);
                    $value->time_work = date('H:i',$hour);
                    $value->start_am = $request->time;
                }
                if($request->pos == 2) {
                    $hour = strtotime($value->end_am) + strtotime($value->end_pm) + strtotime($value->end_up) - strtotime($value->start_am) - strtotime($request->time) - strtotime($value->start_up);
                    $value->time_work = date('H:i',$hour);
                    $value->start_pm = $request->time;
                }
                if($request->pos == 3) {
                    $hour = strtotime($value->end_am) + strtotime($value->end_pm) + strtotime($value->end_up) - strtotime($value->start_am) - strtotime($value->start_pm) - strtotime($request->time);
                    $value->time_work = date('H:i',$hour);
                    $value->start_up = $request->time;
                }
                if($request->pos == 4) {
                    $hour = strtotime($request->time) + strtotime($value->end_pm) + strtotime($value->end_up) - strtotime($value->start_am) - strtotime($value->start_pm) - strtotime($value->start_up);
                    $value->time_work = date('H:i',$hour);
                    $value->end_am = $request->time;
                }
                if($request->pos == 5) {
                    $hour = strtotime($value->end_am) - strtotime($value->start_am) + strtotime($request->time) - strtotime($value->start_pm) + strtotime($value->end_up) - strtotime($value->start_up);
                    $value->time_work = date('H:i',$hour);
                    $value->end_pm = $request->time;
                }
                if($request->pos == 6) {
                    $hour = strtotime($value->end_am) + strtotime($value->end_pm) + strtotime($request->time) - strtotime($value->start_am) - strtotime($value->start_pm) - strtotime($value->start_up);
                    $value->time_work = date('H:i',$hour);
                    $value->end_up = $request->time;
                }
                $value->save();        
            }
        }else {
            $quyngay = QuyNgayNew::where('name_id',$request->name_id)->where('date',$request->date)->first();
            if($request->pos == 1) {
                $hour = strtotime($quyngay->end_am) + strtotime($quyngay->end_pm) + strtotime($quyngay->end_up) - strtotime($request->time) - strtotime($quyngay->start_pm) - strtotime($quyngay->start_up);
                $quyngay->time_work = date('H:i',$hour);
                $quyngay->start_am = $request->time;
            }
            if($request->pos == 2) {
                $hour = strtotime($quyngay->end_am) + strtotime($quyngay->end_pm) + strtotime($quyngay->end_up) - strtotime($quyngay->start_am) - strtotime($request->time) - strtotime($quyngay->start_up);
                        $quyngay->time_work = date('H:i',$hour);
                $quyngay->start_pm = $request->time;
            }
            if($request->pos == 3) {
                $hour = strtotime($quyngay->end_am) + strtotime($quyngay->end_pm) + strtotime($quyngay->end_up) - strtotime($quyngay->start_am) - strtotime($quyngay->start_pm) - strtotime($request->time);
                $quyngay->time_work = date('H:i',$hour);
                $quyngay->start_up = $request->time;
            }
            if($request->pos == 4) {
                $hour = strtotime($request->time) + strtotime($quyngay->end_pm) + strtotime($quyngay->end_up) - strtotime($quyngay->start_am) - strtotime($quyngay->start_pm) - strtotime($quyngay->start_up);
                $quyngay->time_work = date('H:i',$hour);
                $quyngay->end_am = $request->time;
            }
            if($request->pos == 5) {
                $hour = strtotime($quyngay->end_am) - strtotime($quyngay->start_am) + strtotime($request->time) - strtotime($quyngay->start_pm) + strtotime($quyngay->end_up) - strtotime($quyngay->start_up);
                $quyngay->time_work = date('H:i',$hour);
                $quyngay->end_pm = $request->time;
            }
            if($request->pos == 6) {
                $hour = strtotime($quyngay->end_am) + strtotime($quyngay->end_pm) + strtotime($request->time) - strtotime($quyngay->start_am) - strtotime($quyngay->start_pm) - strtotime($quyngay->start_up);
                $quyngay->time_work = date('H:i',$hour);
                $quyngay->end_up = $request->time;
            }
            $quyngay->save();
        }
        // dd($quyngay);
        return response()->json([
            'status' => true,
            'message' => 'Cập Nhật Thành Công'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QuyNgayNew  $quyNgayNew
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuyNgayNew $quyNgayNew)
    {
        //
    }
}
