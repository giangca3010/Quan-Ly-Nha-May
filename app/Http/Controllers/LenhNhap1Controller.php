<?php
//code theo sort
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Lenh;
use App\MenuItems;
use App\QuyNgay;
use App\QuyNgayNew;

class LenhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lenh = Lenh::orderBy("position_order", "asc")->Join('admin_menu_items', 'sorting_items.id_menu', '=', 'admin_menu_items.parent')->get();
        $menu = MenuItems::where("menu", 1)->orderBy("sort", "asc")->Join('sorting_items', 'admin_menu_items.parent', '=', 'sorting_items.id_menu')->get();

        $merge = $menu->groupBy(function ($value)  {
            return $value->position_order;
        });

        $sort = $merge->sortBy(function($value, $key) {
            return $key;
        });
        $name = 'Kế Hoạch';
        $action = 'Danh Sách';   
        // dd($sort);
        return view('admin.lenh',compact('lenh','menu','sort','name','action'));
    }

    public function move(Request $request)
    {
        $sort_old = Lenh::pluck('position_order');

        $i=1;
        foreach($request->position as $k=>$v){
            $lenh = Lenh::find($v);
            $lenh->position_order=$i;
            $lenh->save();
            $i++;
        }
        $sort_new = Lenh::pluck('position_order');
        for ($i=1; $i < count($sort_new) ; $i++) { 
            if($sort_new[$i] != $sort_old[$i]){
                $sort = $sort_new[$i];
                break;
            }
        }
        return $sort;
        
        // dd($parent);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addlenh()
    {
        // return view('addlenh');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        $id = Lenh::where('position_order',$request->id_menu)->first();
        $parent = Lenh::where('id','>=',$id->id)->orderBy('position_order', 'asc')->pluck('id_menu');
        // dd($parent);
        // $after = Lenh::where('menu','<',$parent[0])
        foreach ($parent as $key => $value) {
            $all = MenuItems::where('parent',$value)->get();
            foreach ($all as $k => $v) {
                $lenh = MenuItems::where('parent',$v->parent)->where('sort',$v->sort)->first();
                if($v->sort == 2) {
                    $cdctime = MenuItems::where('status', 1)->where('parent',$this->findafter($v->parent))->first();
                    $lenh->start_time = $cdctime->end_time;
                    $lenh->end_time = date('H:i',$this->ai($v->dinhmuc,$cdctime->end_time,$cdctime->end_date,$v->sort));
                    $lenh->start_date = $cdctime->end_date;
                    $lenh->end_date = date('Y-m-d',$this->ai($v->dinhmuc,$cdctime->end_time,$cdctime->end_date,$v->sort));
                }
                if($v->sort > 2) {
                    $sort = $v->sort - 1;
                    // echo $sort;
                    $cdctime = MenuItems::where('sort', $sort)->where('parent',$v->parent)->first();
                    $lenh->start_time = $cdctime->end_time;
                    $lenh->end_time = date('H:i',$this->ai($v->dinhmuc,$cdctime->end_time,$cdctime->end_date,$v->sort));
                    $lenh->start_date = $cdctime->end_date;
                    $lenh->end_date = date('Y-m-d',$this->ai($v->dinhmuc,$cdctime->end_time,$cdctime->end_date,$v->sort));
                }
                $lenh->save();
            }
        }
    }

    public function findafter($parent)
    {
        // dd($parent);
        $find_id = Lenh::where('id_menu',$parent)->first();
        $find = Lenh::where('position_order',$find_id->position_order - 1)->first();
        // dd($find_id->sort);
        return $find->id_menu;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $return =  Lenh::All();
        foreach ($return as $key => $value) {
            $lenh = Lenh::find($value->id);
            $lenh->position_order = $lenh->sort_order;
            $lenh->save();
        }
        return response()->json([
            'status' => true,
            'message' => 'Hủy Thành Công'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r)
    {
        // dd($r->all());
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $all = MenuItems::where('parent',$r->parent)->count();
        $lenh = MenuItems::where('sort',$r->sort)->where('parent',$r->parent)->first();
        if($r->status == 1) {
            $lenh->start_date = $dt->toDateString();
            $lenh->start_time = $dt->toTimeString();
            $lenh->end_time = date('H:i',$this->ai($lenh->dinhmuc,$dt->toTimeString(),$dt->toDateString(),$r->sort));
            // $lenh->start_time = '09:15';
            // $lenh->end_time = date('H:i',$this->ai($lenh->dinhmuc,'09:15',$dt->toDateString(),$r->sort));
            $lenh->end_date = date('Y-m-d',$this->ai($lenh->dinhmuc,$dt->toTimeString(),$dt->toDateString(),$r->sort));
        }
        if($r->status == 2) {
            $lenh->end_time = $dt->toTimeString();
            $lenh->end_date = $dt->toDateString();
            // $lenh->end_time = '09:15';
            // $lenh->end_date = $dt->toDateString();
        }
        $lenh->save();

        $max = $all - $r->sort;
        for ($i=0; $i < $max; $i++) { 
            $find = $r->sort + 1 + $i;
            $findpre = $r->sort + $i;
            $update = MenuItems::where('sort',$find)->where('parent',$r->parent)->first();
            $cdctime = MenuItems::where('sort', $findpre)->where('parent',$r->parent)->first();
            $update->start_time = $cdctime->end_time;
            $update->end_time = date('H:i',$this->ai($update->dinhmuc,$cdctime->end_time,$cdctime->end_date,$r->sort));
            $update->start_date = $cdctime->end_date;
            $update->end_date = date('Y-m-d',$this->ai($update->dinhmuc,$cdctime->end_time,$cdctime->end_date,$r->sort));
            $update->save();
        }
        if ($r->sort == 2) {
            $stt = Lenh::where('id',$r->id)->first();
            $orderBy = Lenh::where('position_order','>',$stt->position_order)->get();
            // dd($orderBy);
            foreach ($orderBy as $value) {
                $updateLenh = MenuItems::where('parent',$value->id_menu)->where('sort','>',1)->get();
                // dd($updateLenh);
                foreach ($updateLenh as $k => $val) {
                    $insert = MenuItems::where('sort',$val->sort)->where('parent',$val->parent)->first();
                    if($val->sort == 2) {
                        $cdctime = MenuItems::where('parent',$r->parent)->where('status',1)->first();
                        // dd($cdctime->end_time);
                        $insert->start_time = $cdctime->end_time;
                        $insert->end_time = date('H:i',$this->ai($val->dinhmuc,$cdctime->end_time,$cdctime->end_date,$val->sort));
                        $insert->start_date = $cdctime->end_date;
                        $insert->end_date = date('Y-m-d',$this->ai($val->dinhmuc,$cdctime->end_time,$cdctime->end_date,$val->sort));
                    }
                    if($val->sort > 2) {
                        $after = $val->sort - 1;
                        $cdctime = MenuItems::where('sort',$after)->where('parent',$val->parent)->first();
                        $insert->start_time = $cdctime->end_time;
                        $insert->end_time = date('H:i',$this->ai($val->dinhmuc,$cdctime->end_time,$cdctime->end_date,$val->sort));
                        $insert->start_date = $cdctime->end_date;
                        $insert->end_date = date('Y-m-d',$this->ai($val->dinhmuc,$cdctime->end_time,$cdctime->end_date,$val->sort));
                    }
                    $insert->save();
                }
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Cập Nhật Thành Công'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function findnearstart($time,$id)
    {
        $date = date('Y-m-d',strtotime($time));
        $near = date('H:i',strtotime($time));
        $check = QuyNgayNew::where('date',$date)->where('name_id',$id)->first();
        $checkpm = strtotime($check->end_pm) - strtotime($near);
        $checkam = strtotime($check->end_am) - strtotime($near);
        if($checkpm == 0) {
            $query_next = QuyNgayNew::where('date',date('Y-m-d',strtotime('+1 day',strtotime($date))))->where('name_id',$id)->first();
            $start_next = $query_next->date.' '.$query_next->start_am;
        }
        if($checkam == 0) {
            $start_next = $date.' '.$check->start_pm;
        }
        return $start_next;
        // dd(strtotime($start_next));
    }


    public function findnearend($time,$id)
    {
        $date = date('Y-m-d',strtotime($time));
        $near = date('H:i',strtotime($time));
        $check = QuyNgayNew::where('date',$date)->where('name_id',$id)->first();
        $checkpm = strtotime($check->end_pm) - strtotime($near);
        $checkam = strtotime($check->end_am) - strtotime($near);
        if($checkpm == 0) {
            $query_next = QuyNgayNew::where('date',date('Y-m-d',strtotime('+1 day',strtotime($date))))->where('name_id',$id)->first();
            $end_next = $query_next->date.' '.$query_next->end_am;
        }
        if($checkam == 0) {
            $end_next = $date.' '.$check->end_pm;
        }
        return $end_next;
    }

    public function findnearh1($time,$date,$id)
    {
        $time =  explode(':', $time);
        $query_date = QuyNgayNew::where('date',$date)->where('name_id',$id)->first();
        $moc = explode(':', $query_date->end_am);
        if($time[0] >= $moc[0]) {
            $near = $query_date->end_pm;
        }
        else{
            $near = $query_date->end_am;
        }
        return $date.' '.$near;
    }

    public function ai($dinhmuc,$time,$date,$stt)
    {
        $near = $this->findnearh1($time,$date,$stt);
        $dm = explode(':', $dinhmuc);
        $h1 = strtotime('+'.$dm[0].' hour +'.$dm[1].' minutes',strtotime($date.''.$time)) - strtotime($near); 
        if($h1 < 0) {
            $end = strtotime('+'.$dm[0].' hour +'.$dm[1].' minutes',strtotime($date.''.$time));
            return $end;
        }else {
            $h2 = $h1 +  strtotime($this->findnearstart($near,$stt)) - strtotime($this->findnearend($near,$stt));
            if($h2 < 0){
                $end = $h1 + strtotime($this->findnearstart($near,$stt));
                return $end;
            }else {
                $near1 = $this->findnearend($near,$stt);
                $h3 = $h2 +  strtotime($this->findnearstart($near1,$stt)) - strtotime($this->findnearend($near1,$stt));
                if($h3 < 0){
                    $end = $h2 + strtotime($this->findnearstart($near1,$stt));
                    return $end;
                }else {
                    $near2 = $this->findnearend($near1,$stt);
                    $h4 = $h3 +  strtotime($this->findnearstart($near2,$stt)) - strtotime($this->findnearend($near2,$stt));
                    if($h4 < 0){
                        $end = $h3 + strtotime($this->findnearstart($near2,$stt));
                        return $end;
                    }else {
                        $near3 = $this->findnearend($near2,$stt);
                        $h5 = $h4 +  strtotime($this->findnearstart($near3,$stt)) - strtotime($this->findnearend($near3,$stt));
                        if($h5 < 0){
                            $end = $h4 + strtotime($this->findnearstart($near3,$stt));
                            return $end;
                        }else {
                            $near4 = $this->findnearend($near3,$stt);
                            $h6 = $h5 +  strtotime($this->findnearstart($near4,$stt)) - strtotime($this->findnearend($near4,$stt));
                            if($h6 < 0){
                                $end = $h5 + strtotime($this->findnearstart($near4,$stt));
                                return $end;
                            }else {
                                $near5 = $this->findnearend($near4,$stt);
                                $h7 = $h6 +  strtotime($this->findnearstart($near5,$stt)) - strtotime($this->findnearend($near5,$stt));
                                if($h7 < 0){
                                    $end = $h6 + strtotime($this->findnearstart($near5,$stt));
                                    return $end;
                                }else {
                                    $near6 = $this->findnearend($near5,$stt);
                                    $h8 = $h7 +  strtotime($this->findnearstart($near6,$stt)) - strtotime($this->findnearend($near6,$stt));
                                    if($h8 < 0){
                                        $end = $h7 + strtotime($this->findnearstart($near6,$stt));
                                        return $end;
                                    }else {
                                        $near7 = $this->findnearend($near6,$stt);
                                        $h9 = $h8 +  strtotime($this->findnearstart($near7,$stt)) - strtotime($this->findnearend($near7,$stt));
                                        if($h9 < 0){
                                            $end = $h8 + strtotime($this->findnearstart($near7,$stt));
                                            return $end;
                                        }else {
                                            $near8 = $this->findnearend($near7,$stt);
                                            $h10 = $h9 +  strtotime($this->findnearstart($near8,$stt)) - strtotime($this->findnearend($near8,$stt));
                                            if($h10 < 0){
                                                $end = $h9 + strtotime($this->findnearstart($near8,$stt));
                                                return $end;
                                            }else {
                                                $near9 = $this->findnearend($near8,$stt);
                                                $h11 = $h10 +  strtotime($this->findnearstart($near9,$stt)) - strtotime($this->findnearend($near9,$stt));
                                                if($h11 < 0){
                                                    $end = $h10 + strtotime($this->findnearstart($near9,$stt));
                                                    return $end;
                                                }else {
                                                    $near10 = $this->findnearend($near9,$stt);
                                                    $h12 = $h11 +  strtotime($this->findnearstart($near10,$stt)) - strtotime($this->findnearend($near10,$stt));
                                                    if($h12 < 0){
                                                        $end = $h11 + strtotime($this->findnearstart($near10,$stt));
                                                        return $end;
                                                    }else {
                                                        $near11 = $this->findnearend($near10,$stt);
                                                        $h13 = $h12 +  strtotime($this->findnearstart($near11,$stt)) - strtotime($this->findnearend($near11,$stt));
                                                        if($h13 < 0){
                                                            $end = $h12 + strtotime($this->findnearstart($near11,$stt));
                                                            return $end;
                                                        }else {
                                                            $near11 = $this->findnearend($near10,$stt);
                                                            $h13 = $h12 +  strtotime($this->findnearstart($near11,$stt)) - strtotime($this->findnearend($near11,$stt));
                                                            if($h13 < 0){
                                                                $end = $h12 + strtotime($this->findnearstart($near11,$stt));
                                                                return $end;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                
            }
        }
    }
}
