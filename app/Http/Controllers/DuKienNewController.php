<?php

namespace App\Http\Controllers;

use App\DuKien;
use App\Boom;
use Illuminate\Http\Request;
use App\MenuItems;
use App\Lenh;
use Carbon\Carbon;
use App\QuyNgay;
use App\QuyNgayNew;
use App\Item;
use App\Kien;

class DuKienNewController extends Controller
{
    public function index()
    {
        $name = 'Kế Hoạch Dự Kiến';
        $action = 'Danh Sách';
        $dukien = DuKien::where('parent',0)->get();
        
        $merge = $dukien->map(function($value,$key)  {
            $value->parentSons =  $this->getsons($value->id);
            return $value;
        });

        $groupBy = $merge->groupBy(['lenh']);
        // dd($groupBy);
        $boom = Boom::where('parent',0)->pluck('name')->toArray();
        // dd(array_unique($boom));
        $item = collect(array_unique($boom));

        $version = Boom::where('name',$boom[0])->get();
        return view('admin.du-kien',compact('name','action','groupBy','item','version'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $item = Item::where('name',$request->item)->where('so_luong',$request->so_luong)->first();
        if ($item == null) {
            $dukien = new DuKien;
            $dukien->name = '';
            $dukien->lenh = $request->lenh;
            $dukien->item = $request->item;
            $dukien->mota = $request->mota;
            $dukien->so_luong = $request->so_luong;
            $dukien->date = $dt->toDateString();
            $dukien->start_time = $request->time_nhapkho;
            $dukien->date_nhapkho = date('Y-m-d',strtotime($request->date_nhapkho));
            $dukien->parent = 0;
            $dukien->dinhmuc =  '00:00';
            $dukien->tre = '00:00';
            $dukien->depth = 0;
            $dukien->status = 0;
            $dukien->opposites = 0;
            $dukien->menu = 1;
            $dukien->sort = 0; 
            $dukien->save();
            return response()->json([
                'status' => false,
                'message' => 'Cảnh báo! Lỗi không tìm thấy item'
            ], 200);
        }else{
            $boom = Kien::whereIn('id',json_decode($item->kien_id))->get();
            // dd($boom);
            $merge = $boom->map(function($value) {
                $boomsons = Kien::where('parent',$value->id)->get()->toArray();
                $group = array_merge([$value->toArray()],$boomsons);
                return $group;
            });

            foreach ($merge as $v) {
                foreach ($v as $key => $value) {
                    $dukien = new DuKien;
                    $dukien->name = $value['name'];
                    $dukien->lenh = $request->lenh;
                    $dukien->item = $request->item;
                    $dukien->mota = $request->mota;
                    $dukien->so_luong = $request->so_luong;
                    $dukien->date_nhapkho = date('Y-m-d',strtotime($request->date_nhapkho));
                    $idParent = DuKien::where('parent', 0)->orderBy('id', 'desc')->first();
                    $dukien->parent = ($value['parent'] == 0) ? 0 : $idParent->id;
                    $dukien->dinhmuc = $value['dinhmuc'];
                    $dukien->tre = $value['tre'];
                    $dukien->depth = $value['depth'];
                    $dukien->status = $value['status'];
                    $dukien->opposites = $value['opposites'];
                    if($value['status'] == 1 or $value['parent'] == 0) {
                        $dukien->start_time = $request->time_nhapkho;
                        $date_nk = date('Y-m-d',strtotime($request->date_nhapkho));
                        $dukien->date_time = date('Y-m-d H:i',$this->divisionDinhmuc($value['dinhmuc'],$request->time_nhapkho,$date_nk,1));
                    }
                    $dukien->menu = 1;
                    $dukien->date = $dt->toDateString();
                    if ($value['parent'] == 0) {
                        $dukien->sort = 0;
                    }else {
                        $sort = $value['parent'];
                        $dukien->sort = DuKien::getNextSortRoot(1,$sort);  
                    }
                    $dukien->save();
                }
            }
            return response()->json([
                'status' => true,
                'message' => 'Cập Nhật Thành Công'
            ], 200);
        }
    }

    public function show($iditem)
    {
        $version = Boom::where('name',$iditem)->get();
        foreach ($version as $v)
        {
            echo "<option value='".$v->version."'>Version ".$v->version."</option>";
        }

    }

    public function edit(Request $request)
    {
        // dd($request->all());
        $item = Item::findOrFail($request->id);
        $item->name = $request->name;
        $item->code = $request->name.'_'.$request->soluong;
        $item->so_luong = $request->soluong;
        $item->kien_id   = json_encode($request->kien);
        $item->note = $request->mota;
        $item->save();

        $get_dukien =  DuKien::where('item',$request->name)->where('so_luong',$request->soluong)->first();

        $boom = Kien::whereIn('id',$request->kien)->get();
        // dd($get_dukien);
        $merge = $boom->map(function($value) {
            $boomsons = Kien::where('parent',$value->id)->get()->toArray();
            $group = array_merge([$value->toArray()],$boomsons);
            return $group;
        });
        foreach ($merge as $v) {
            foreach ($v as $key => $value) {
                $dukien = new DuKien;
                $dukien->name = $value['name'];
                $dukien->lenh = $get_dukien->lenh;
                $dukien->item = $get_dukien->item;
                $dukien->mota = $request->mota;
                $dukien->so_luong = $request->soluong;
                $dukien->date_nhapkho = $get_dukien->date_nhapkho;
                $idParent = DuKien::where('parent', 0)->orderBy('id', 'desc')->first();
                $dukien->parent = ($value['parent'] == 0) ? 0 : $idParent->id;
                $dukien->dinhmuc = $value['dinhmuc'];
                $dukien->tre = $value['tre'];
                $dukien->depth = $value['depth'];
                $dukien->status = $value['status'];
                $dukien->opposites = $value['opposites'];
                if($value['status'] == 1 or $value['parent'] == 0) {
                    $dukien->start_time = $get_dukien->start_time;
                    $date_nk = $get_dukien->date_nhapkho;
                    $dukien->date_time = date('Y-m-d H:i',$this->divisionDinhmuc($value['dinhmuc'],$get_dukien->start_time,$date_nk,1));
                }
                $dukien->menu = 1;
                $dukien->date = $get_dukien->date;
                if ($value['parent'] == 0) {
                    $dukien->sort = 0;
                }else {
                    $sort = $value['parent'];
                    $dukien->sort = DuKien::getNextSortRoot(1,$sort);  
                }
                $dukien->save();
            }
        }

        DuKien::findOrFail($get_dukien->id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Thêm Thành Công'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DuKien  $duKien
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DuKien $duKien)
    {
        // dd($request->all());
        $dukien = DuKien::where('parent',0)->where('id',$request->id)->get();
        $dukiensons = DuKien::where('parent',$request->id)->get();
        $merge = $dukien->merge($dukiensons);
        // $changestatus = DuKien::find($request->id);
        // $changestatus->duyet = 1;
        // $changestatus->save();
        // dd($request->all());
        foreach ($merge as $key => $value) {
            $dukien = new MenuItems;
            $dukien->label = $value->name;
            $idParent = MenuItems::where('parent', 0)->orderBy('id', 'desc')->first();
            $dukien->parent = ($value->parent == 0) ? 0 : $idParent->id;
            $dukien->dinhmuc = $value->dinhmuc;
            $dukien->tre = $value->tre;
            $dukien->depth = $value->depth;
            $dukien->status = $value->status;
            if($request->status == 1) {
                if($key == 1) {
                    $dukien->end_time = $request->time;
                    $dukien->start_time = date('H:i',$this->divisionDinhmuc($value->dinhmuc,$request->time,$request->date,$key));
                    $dukien->start_date = date('Y-m-d',$this->divisionDinhmuc($value->dinhmuc,$request->time,$request->date,$key));
                    $dukien->end_date = $request->date;
                    $dukien->sort = $key;
                }
                if($key == 2) {
                    if ($value->opposites == 1) {
                        $time_tre = date('H:i',$this->divisionDinhmuc($value->tre,$request->time,$request->date,$key));
                        $date_tre = date('Y-m-d',$this->divisionDinhmuc($value->tre,$request->time,$request->date,$key));
                    }
                    if ($value->opposites == 0) {
                        $time_tre = date('H:i',$this->ai($value->tre,$request->time,$request->date,$key));
                        $date_tre = date('Y-m-d',$this->ai($value->tre,$request->time,$request->date,$key));
                    }
                    $dukien->start_time = $time_tre;
                    $dukien->start_date = $date_tre;
                    $dukien->end_time = date('H:i',$this->ai($value->dinhmuc,$time_tre,$date_tre,$key));
                    $dukien->end_date = date('Y-m-d',$this->ai($value->dinhmuc,$time_tre,$date_tre,$key));
                    $dukien->status = 1;
                    $dukien->sort = $key;  
                }
                if($key > 2) {
                    $cdctime = MenuItems::orderBy('id', 'desc')->first();
                    if ($value->opposites == 1) {
                        $time_tre = date('H:i',$this->divisionDinhmuc($value->tre,$cdctime->end_time,$cdctime->end_date,$key));
                        $date_tre = date('Y-m-d',$this->divisionDinhmuc($value->tre,$cdctime->end_time,$cdctime->end_date,$key));
                    }
                    if ($value->opposites == 0) {
                        $time_tre = date('H:i',$this->ai($value->tre,$cdctime->end_time,$cdctime->end_date,$key));
                        $date_tre = date('Y-m-d',$this->ai($value->tre,$cdctime->end_time,$cdctime->end_date,$key));
                    }
                    $dukien->start_time = $time_tre;
                    $dukien->start_date = $date_tre;
                    $dukien->end_time = date('H:i',$this->ai($value->dinhmuc,$time_tre,$date_tre,$key));
                    $dukien->end_date = date('Y-m-d',$this->ai($value->dinhmuc,$time_tre,$date_tre,$key));

                    // $dukien->end_time = date('H:i',$this->ai($value->dinhmuc,$cdctime->end_time,$cdctime->end_date,$key));
                    // $dukien->end_date = date('Y-m-d',$this->ai($value->dinhmuc,$cdctime->end_time,$cdctime->end_date,$key));
                    $dukien->sort = $key;  
                }
            }
             
            if($request->status == 0) {
                $getParent = Lenh::orderBy('position_order', 'desc')->first();
                if($key == 1) {
                    $cdctime = MenuItems::where('status', 1)->where('parent', $getParent->id_menu)->first();
                    $dukien->end_time = $cdctime->end_time;
                    $dukien->start_time = date('H:i',$this->divisionDinhmuc($value->dinhmuc,$cdctime->end_time,$cdctime->end_date,$key));
                    $dukien->start_date = date('Y-m-d',$this->divisionDinhmuc($value->dinhmuc,$cdctime->end_time,$cdctime->end_date,$key));
                    $dukien->end_date = $cdctime->end_date;
                    $dukien->sort = $key;  
                }
                if($key == 2) {
                    $cdctime = MenuItems::where('status', 1)->where('parent', $getParent->id_menu)->first();
                    if ($value->opposites == 1) {
                        $time_tre = date('H:i',$this->divisionDinhmuc($value->tre,$cdctime->end_time,$cdctime->end_date,$key));
                        $date_tre = date('Y-m-d',$this->divisionDinhmuc($value->tre,$cdctime->end_time,$cdctime->end_date,$key));
                    }
                    if ($value->opposites == 0) {
                        $time_tre = date('H:i',$this->ai($value->tre,$cdctime->end_time,$cdctime->end_date,$key));
                        $date_tre = date('Y-m-d',$this->ai($value->tre,$cdctime->end_time,$cdctime->end_date,$key));
                    }
                    $dukien->start_time = $time_tre;
                    $dukien->start_date = $date_tre;
                    $dukien->end_time = date('H:i',$this->ai($value->dinhmuc,$time_tre,$date_tre,$key));
                    $dukien->end_date = date('Y-m-d',$this->ai($value->dinhmuc,$time_tre,$date_tre,$key));
                    $dukien->sort = $key;  
                    $dukien->status = 1;
                }
                if($key > 2) {
                    $cdctime = MenuItems::orderBy('id', 'desc')->first();
                    if ($value->opposites == 1) {
                        $time_tre = date('H:i',$this->divisionDinhmuc($value->tre,$cdctime->end_time,$cdctime->end_date,$key));
                        $date_tre = date('Y-m-d',$this->divisionDinhmuc($value->tre,$cdctime->end_time,$cdctime->end_date,$key));
                    }
                    if ($value->opposites == 0) {
                        $time_tre = date('H:i',$this->ai($value->tre,$cdctime->end_time,$cdctime->end_date,$key));
                        $date_tre = date('Y-m-d',$this->ai($value->tre,$cdctime->end_time,$cdctime->end_date,$key));
                    }
                    $dukien->start_time = $time_tre;
                    $dukien->start_date = $date_tre;
                    $dukien->end_time = date('H:i',$this->ai($value->dinhmuc,$time_tre,$date_tre,$key));
                    $dukien->end_date = date('Y-m-d',$this->ai($value->dinhmuc,$time_tre,$date_tre,$key));
                    $dukien->sort = $key;  
                }
            } 
            $dukien->menu = 1;
            $dukien->save();
        }

        $lenh = new Lenh;
        $lenh->id_menu =  $this->getLenh($dukien->id,$merge);
        $lenh->position_order = Lenh::getNextSortRoot();
        $lenh->sort_order = Lenh::getNextSortRoot();
        $lenh->title = $merge[0]['name'];
        $lenh->boom = $merge[0]['item'].'_'.$merge[0]['so_luong'];
        $lenh->lenh = $merge[0]['lenh'];
        $lenh->date_nhapkho = $merge[0]['start_time'].' '.$merge[0]['date_nhapkho'];
        $lenh->save();

        return response()->json([
            'status' => true,
            'message' => 'Duyệt Thành Công'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DuKien  $duKien
     * @return \Illuminate\Http\Response
     */
    public function destroy(DuKien $duKien)
    {
        //
    }

    public function getsons($id)
    {
        return DuKien::where("parent", $id)->get();
    }

    public function findnearafterh1($time,$date,$id)
    {
        date_default_timezone_set('UTC'); 
        // dd($date);
        $query_date = QuyNgayNew::where('date',$date)->where('name_id',$id)->first();
        $moc = strtotime($query_date->end_am) - strtotime($time);
        if($moc < 0) {
            $near = $query_date->start_pm;
        }
        else{
            $near = $query_date->start_am;
        }
        return strtotime($date.''.$near);
    }

    public function divisionDinhmuc($dinhmuc,$start,$date,$id)
    {
        $near = $this->findnearafterh1($start,$date,$id);
        $dm = explode(':', $dinhmuc);
        date_default_timezone_set('UTC');
        $h1 = strtotime('+'.$dm[0].' hour +'.$dm[1].' minutes',$near) - strtotime($date.''.$start);
        // dd(date('Y-m-d H:i',strtotime('-'.$dm[0].' hour -'.$dm[1].' minutes',strtotime($date.''.$start))));
        if($h1 > 0) {
            $start1 = $this->start_div($near,$id);
            $end1 = $this->end_div($near,$id);
            $h2 = $h1 + $start1 - $end1;
            if ($h2 > 0) {
                $start2 = $this->start_div($start1,$id);
                $end2 = $this->end_div($start1,$id);
                $h3 = $h2 + $start2 - $end2;
                if ($h3 > 0) {
                    $start3 = $this->start_div($start2,$id);
                    $end3 = $this->end_div($start2,$id);
                    $h4 = $h3 + $start3 - $end3;
                    if ($h4 > 0) {
                        $start4 = $this->start_div($start3,$id);
                        $end4 = $this->end_div($start3,$id);
                        $h5 = $h4 + $start4 - $end4;
                        if ($h5 > 0) {
                            $start5 = $this->start_div($start4,$id);
                            $end5 = $this->end_div($start4,$id);
                            $h6 = $h5 + $start5 - $end5;
                            if ($h6 > 0) {
                                $start6 = $this->start_div($start5,$id);
                                $end6 = $this->end_div($start5,$id);
                                $h7 = $h6 + $start6 - $end6;
                                if ($h7 > 0) {
                                    $start7 = $this->start_div($start6,$id);
                                    $end7 = $this->end_div($start6,$id);
                                    $h8 = $h7 + $start7 - $end7;
                                    if ($h8 > 0) {
                                        $start8 = $this->start_div($start7,$id);
                                        $end8 = $this->end_div($start7,$id);
                                        $h9 = $h8 + $start8 - $end8;
                                        if ($h9 > 0) {
                                            $start9 = $this->start_div($start8,$id);
                                            $end9 = $this->end_div($start8,$id);
                                            $h10 = $h9 + $start9 - $end9;
                                            if ($h10 > 0) {
                                                $start10 = $this->start_div($start9,$id);
                                                $end10 = $this->end_div($start9,$id);
                                                $h11 = $h10 + $start10 - $end10;           
                                                if ($h11 > 0) {
                                                    $start11 = $this->start_div($start9,$id);
                                                    $end11 = $this->end_div($start9,$id);
                                                    $h12 = $h10 + $start10 - $end11;           
                                                    
                                                }else{
                                                    return $this->ketqua($h10,$end10,$id);
                                                }
                                            }else{
                                                return $this->ketqua($h9,$end9,$id);
                                            }            
                                            
                                        }else{
                                            return $this->ketqua($h8,$end8,$id);
                                        }         
                                        
                                    }else{
                                        return $this->ketqua($h7,$end7,$id);
                                    }         
                                    
                                }else{
                                    return $this->ketqua($h6,$end6,$id);
                                }         
                                
                            }else{
                                return $this->ketqua($h5,$end5,$id);
                            }         
                            
                        }else{
                            return $this->ketqua($h4,$end4,$id);
                        }          
                        
                    }else{
                        return $this->ketqua($h3,$end3,$id);
                    }       
                    
                }else{
                    return $this->ketqua($h2,$end2,$id);
                }
            }else{
                return $this->ketqua($h1,$end1,$id); 
            }
        } else {
            return strtotime('-'.$dm[0].' hour -'.$dm[1].' minutes',strtotime($date.''.$start));    
        }
    }

    public function ketqua($h,$near,$id)
    {
        $t = date('H:i',$h);
        date_default_timezone_set('UTC');
        $time = explode(':', $t);
        $hour = strtotime('-'.$time[0].' hour -'.$time[1].' minutes',$near);
        return $hour;
    }

    public function start_div($near,$id)
    {
        $date = date('Y-m-d',$near);
        date_default_timezone_set('UTC');
        $query_date = QuyNgayNew::where('date',$date)->where('name_id',$id)->first();
        // dd($query_date->end_am);
        $moc = strtotime($date.''.$query_date->end_am) - $near;
        // print_r(strtotime($query_date->end_am) - $near);
        if ($moc < 0 ) {
            $end = strtotime($date.' '.$query_date->start_am);
        }else {
            $query_next = QuyNgayNew::where('date',date('Y-m-d',strtotime('-1 day',strtotime($date))))->where('name_id',$id)->first();
            $end = strtotime($query_next->date.' '.$query_next->start_pm);
        }
        return $end;
    }

    public function end_div($near,$id)
    {
        $date = date('Y-m-d',$near);
        date_default_timezone_set('UTC');
        $query_date = QuyNgayNew::where('date',$date)->where('name_id',$id)->first();
        $moc = strtotime($date.''.$query_date->end_am) - $near;
        if ($moc < 0 ) {
            $start = strtotime($date.' '.$query_date->end_am);
        }else {
            $query_next = QuyNgayNew::where('date',date('Y-m-d',strtotime('-1 day',strtotime($date))))->where('name_id',$id)->first();
            $start = strtotime($query_next->date.' '.$query_next->end_pm);
        }
        return $start;
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
            // dd(strtotime($this->findnearstart($near,$stt)));
                // dd(date('Y-m-d H:i',strtotime($this->findnearstart($near,$stt)) - strtotime($this->findnearend($near,$stt))));
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

    public function getLenh($id,$count)
    {
        $idLenh = $id - count($count) + 1;
        return $idLenh;
    }
}
