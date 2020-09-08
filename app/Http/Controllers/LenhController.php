<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Lenh;
use App\MenuItems;
use App\Comment;
use App\QuyNgay;
use App\QuyNgayNew;
use App\DuKien;
use App\CongDoan;
use App\Kien;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Item;
use App\NhapKho;
use App\VatTu;
use App\Media;
use App\QC;
use App\MediaVatTu;
use App\Edit;
use App\TimeQC;
use App\MaLoi;
use App\NguyenNhan;
use App\KiemTra;
use App\GiaiPhap;
use Illuminate\Support\Facades\Storage;

class LenhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menu = Lenh::pluck('id_menu','lenh_link');
        foreach ($menu as $lenh => $value) {
            foreach (json_decode($value) as $key => $item) {
                $position = Lenh::where('lenh_link',$lenh)->first();
                $list =  MenuItems::where('lenh_link',$lenh)->orderBy("sort", "asc")->where('parent',$item)->leftJoin('sorting_items', 'admin_menu_items.lenh_name', '=', 'sorting_items.lenh_link')->leftJoin('vat_tu', 'admin_menu_items.id_kehoach', '=', 'vat_tu.id_parent_vt')->join('nhap_kho', function ($join) {
                        $join->on('admin_menu_items.id_kehoach', '=', 'nhap_kho.id_parent')->where('status_nk',0);
                    })->leftJoin('edit_tomoc', 'admin_menu_items.parent', '=', 'edit_tomoc.id_parent')->leftJoin('time_qc', 'admin_menu_items.parent', '=', 'time_qc.parent_id')->get();
                $sort[$position['position_order']][$key] = $list->keyBy(function ($item) {
                    $item['qcnew'] = QC::where('id_parent',$item['parent'])->get();
                    return $this->url_title($item['label']);
                });
            }
        }
        $getCD = CongDoan::where('id_menu', 1)->where('id','<',6)->get();
        if(isset($sort)) {
            ksort($sort);
        }else {
            $sort = [];
        }
        // dd($sort[37][0]);
        if ($request->select == null) {
            $select = array();
        }else{
            $select = $request->select;
        }
        $maxCD = MenuItems::max('sort');
        $name = 'Kế Hoạch';
        $action = 'Danh Sách';   
        $loi = MaLoi::All();
        $nguyennhan = NguyenNhan::All();
        $kiemtra = KiemTra::All();
        $giaiphap = GiaiPhap::All();
        return view('admin.lenh',compact('menu','sort','name','action','getCD','select','loi','nguyennhan','giaiphap','kiemtra'));
    }

    public function index_ht(Request $request)
    {
        $menu = Lenh::pluck('id_menu','lenh_link');
        foreach ($menu as $lenh => $value) {
            foreach (json_decode($value) as $key => $item) {
                $position = Lenh::where('lenh_link',$lenh)->first();
                $list =  MenuItems::where('lenh_link',$lenh)->orderBy("sort", "asc")->where('parent',$item)->leftJoin('sorting_items', 'admin_menu_items.lenh_name', '=', 'sorting_items.lenh_link')->leftJoin('vat_tu', 'admin_menu_items.id_kehoach', '=', 'vat_tu.id_parent_vt')->join('nhap_kho', function ($join) {
                        $join->on('admin_menu_items.id_kehoach', '=', 'nhap_kho.id_parent')->where('status_nk',1);
                    })->leftJoin('edit_tomoc', 'admin_menu_items.parent', '=', 'edit_tomoc.id_parent')->leftJoin('time_qc', 'admin_menu_items.parent', '=', 'time_qc.parent_id')->get();
                $sort[$position['position_order']][$key] = $list->keyBy(function ($item) {
                    $item['qcnew'] = QC::where('id_parent',$item['parent'])->get();
                    return $this->url_title($item['label']);
                });
            }
        }
        $getCD = CongDoan::where('id_menu', 1)->where('id','<',6)->get();
        if(isset($sort)) {
            ksort($sort);
        }else {
            $sort = [];
        }
        // dd($sort);
        if ($request->select == null) {
            $select = array();
        }else{
            $select = $request->select;
        }
        $maxCD = MenuItems::max('sort');
        $name = 'Hoàn Thiện';
        $action = 'Danh Sách';   
        $loi = MaLoi::All();
        $nguyennhan = NguyenNhan::All();
        $kiemtra = KiemTra::All();
        $giaiphap = GiaiPhap::All();
        return view('admin.lenh',compact('menu','sort','name','action','getCD','select','loi','nguyennhan','giaiphap','kiemtra'));
    }

    public function actiontimeqc(Request $request)
    {
        // dd($request->all());
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $time = new QC;
        $time->start_datetime = $dt->toDateTimeString();
        $time->id_parent = $request->parent;
        $time->save();
        return response()->json([
            'status' => true,
            'message' => 'Lưu Thành Công',
        ], 200);

    }

    public function action(Request $request)
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $check = Edit::where('id_parent',$request->parent)->first();
        if($check == null){
            $save = new Edit;
            $save->id_parent = $request->parent;
        }else{
            $save = $check;
        }
        if ($request->stt == 1) {
            if ($request->status == 0) {
                $save->start_one = $dt->toDateTimeString();
            }else{
                $save->end_one = $dt->toDateTimeString();
            }
        }
        if ($request->stt == 2) {
            if ($request->status == 0) {
                $save->start_two = $dt->toDateTimeString();
            }else{
                $save->end_two = $dt->toDateTimeString();
            }
        }
        if ($request->stt == 3) {
            if ($request->status == 0) {
                $save->start_three = $dt->toDateTimeString();
            }else{
                $save->end_three = $dt->toDateTimeString();
            }
        }
        $save->save();
        return response()->json([
            'status' => true,
            'message' => 'Cập Nhật Thành Công',
        ], 200);
        
    }

    public function showNote(Request $request)
    {
        $find = MenuItems::where('parent',$request->parent)->where('sort',$request->sort)->first();
        $conment = Comment::where('id_lenh',$find['id'])->where('type',$request->type)->join('users','comments.user_id', '=', 'users.id')->get();
        return response()->json($conment, 200);
    }

    public function duyetqc(Request $request)
    {
        $qc = QC::find($request->id);
        $qc->status = $request->status;
        $qc->name_duyet = \Auth::user()->name;
        $qc->save();
        $start = MenuItems::where('parent',$qc['id_parent'])->get();
        // dd($start);
        foreach ($start as $key => $value) {
            $new = MenuItems::find($value['id']);
            $new->qc = $new->qc.' '.Carbon::now('Asia/Ho_Chi_Minh');
            // dd($new->qc.'/'.Carbon::now('Asia/Ho_Chi_Minh'));
            $new->save(); 
        }
        $meger = array_merge($request->all(),['name'=>\Auth::user()->name]);
        return response()->json($meger, 200);
    }

    public function qc(Request $request)
    {
        $qc = QC::find($request->id);
        $qc->so_luong = $request->tong;
        $qc->dat = $request->dat;
        $qc->id_parent = $request->parent;
        $qc->khong_dat = $request->notdat;
        $qc->ma_loi = $request->maloi;
        $qc->status = $request->type;
        $qc->nguyen_nhan = $request->nguyennhan;
        $qc->kiem_tra = $request->kiemtra;
        $qc->phuong_phap = $request->giaiphap;
        $qc->name_qc = \Auth::user()->name;
        $qc->end_datetime = Carbon::now('Asia/Ho_Chi_Minh');
        $qc->save();
        if ($request->file != null) {
            foreach($request->file as $file) {
                if (is_file($file)) {
                    $new_name = rand().'.'.$file->getClientOriginalExtension();
                    Storage::disk('public_uploads')->putFileAs('qc', $file, $new_name);
                    $media = new Media;
                    $media->id_qc = $qc->id;
                    $media->link = '/storage/qc/'.$new_name;
                    $media->save();
                }

            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Lưu Thành Công',
        ], 200);
    }

    public function showQC(Request $request)
    {
        $getData = QC::where('id_parent',$request->parent)->where('id',$request->id)->first()->toArray();
        $get = Media::select('link')->where('id_qc',$getData['id'])->get();
        $getMedia = $get->map(function ($item, $key) {
            return $item->link;
        });
        $kiemtra = $getData['kiem_tra'] == null ? '' : KiemTra::find($getData['kiem_tra']);
        $nguyennhan = $getData['nguyen_nhan'] == null ? '' : NguyenNhan::find($getData['nguyen_nhan']);
        $giaiphap = $getData['phuong_phap'] == null ? '' : GiaiPhap::find($getData['phuong_phap']);
        $maloi = $getData['ma_loi'] == null ? '' : MaLoi::find($getData['ma_loi']);
        $all = array_merge($getData,['link'=>$getMedia],['giaiphap'=>$giaiphap],['nguyennhan'=>$nguyennhan],['kiemtra'=>$kiemtra],['maloi'=>$maloi]);
        // dd($all);
        return response()->json($all, 200);
    }

    public function move(Request $request)
    {
        $countLenh = Lenh::All()->count();
        $getId = range(1, $countLenh);
        // dd($range);
        $sort_old = Lenh::pluck('position_order');
        // $getId = Lenh::All()->pluck('id');
        $r = array_values(array_filter($request->position,'strlen')); 
        for ($i=0; $i < count($r) ; $i++) { 
            if($getId[$i] != $r[$i]){
                $id = $getId[$i];
                break;
            }
        }
        $getParent = Lenh::where('position_order',$id)->first();

        $check = MenuItems::whereIn('parent',json_decode($getParent->id_menu))->pluck('status_kehoach')->toArray();
        $count = count(array_filter($check,'strlen'));
        if($count == 0){
            $remove = Lenh::whereIn('position_order',$r)->update(['position_order'=> null]);
            foreach($r as $k=>$v){
                $sort_stt = $k + 1;
                $get_id = Lenh::where('sort_order',$v)->first();
                $lenh = Lenh::find($get_id['id']);
                $lenh->position_order=$sort_stt;
                $lenh->save();
            }
            $sort_new = Lenh::pluck('position_order');
            for ($i=1; $i < count($sort_new) ; $i++) { 
                if($sort_new[$i] != $sort_old[$i]){
                    $sort = $sort_new[$i];
                    break;
                }
            }
            $getList = Lenh::where('position_order','>',$sort - 1)->pluck('id_menu');
            $merged=[];
            foreach(json_decode($getList) as $array){
                $merged = array_merge($merged, json_decode($array));
            }
            $checkv2 = MenuItems::whereIn('parent',$merged)->pluck('status_kehoach')->toArray();
            $count_action = count(array_filter($checkv2,'strlen'));
            if($count_action == 0){
                return $sort;
            }
            else{
                $return =  Lenh::All();
                foreach ($return as $key => $value) {
                    $lenh = Lenh::find($value->id);
                    $lenh->position_order = $lenh->sort_order;
                    $lenh->save();
                }
                return 'không được';
            }
        }
        else{
            return 'không được';
        }
    }

    public function unlock(Request $request)
    {
        // dd($request->all());
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $removeLenh = Lenh::where('position_order',$request->sort)->first();
        $menu_new = array_diff( json_decode($removeLenh->id_menu), array($request->id) );
        $update_lenh = Lenh::where('position_order',$request->sort)->first();
        $implode= implode(",", $menu_new);
        $update_lenh->id_menu = '['.$implode.']';
        $update_lenh->save();
        $removeParent = MenuItems::find($request->id);
        $removeSons = MenuItems::where('parent',$request->id)->pluck('id');
        $removeParent->delete();
        MenuItems::whereIn('id',json_decode($removeSons))->delete();

        $parent = Lenh::where('position_order','>=',$request->sort)->orderBy('position_order', 'asc')->pluck('id_menu');
        $gop=[];
        foreach(json_decode($parent) as $array){
            $gop = array_merge($gop, json_decode($array));
        }
        foreach ($gop as $key => $value) {
            $all = MenuItems::where('parent',$value)->get();
            $idAfter = [];
            foreach ($all as $k => $v) {
                $lenh = MenuItems::where('parent',$v->parent)->where('sort',$v->sort)->first();
                $idSort = MenuItems::where('parent',$v->parent)->where('status',1)->first();
                if($v->sort < $idSort->sort) {
                    $idAfter[$v->sort] = $v->parent;
                }
                $cdctime = MenuItems::where('status', 1)->where('parent',$this->findafter($v->parent))->first();
                if($v->status == 1) {
                    $lenh->start_time = $cdctime->end_time;
                    $lenh->end_time = date('H:i',$this->ai($v->dinhmuc,$cdctime->end_time,$cdctime->end_date,$v->sort));
                    $lenh->start_date = $cdctime->end_date;
                    $lenh->end_date = date('Y-m-d',$this->ai($v->dinhmuc,$cdctime->end_time,$cdctime->end_date,$v->sort));
                    $lenh->timeChinh = $cdctime->id;
                }
                if($v->sort > $idSort->sort) { // sửa lại nếu cần sửa theo id
                    $cdttime = MenuItems::where('sort',$v->sort - 1)->where('parent',$v->parent)->first();
                    $lenh->start_time = $cdttime->end_time;
                    $lenh->end_time = date('H:i',$this->ai($v->dinhmuc,$cdttime->end_time,$cdttime->end_date,$v->sort));
                    $lenh->start_date = $cdttime->end_date;
                    $lenh->end_date = date('Y-m-d',$this->ai($v->dinhmuc,$cdttime->end_time,$cdttime->end_date,$v->sort));
                    $lenh->timeChinh = $cdctime->id;
                }
                $lenh->save();
            }
            if (isset($idAfter)) {
                if (is_array($idAfter) || is_object($idAfter)){
                    if(count($idAfter) != 0){
                        krsort($idAfter);
                        // dd($idAfter);
                        foreach ($idAfter as $sort => $v) {
                            $dukien = MenuItems::where('parent',$v)->where('sort', $sort)->first();
                            if ($dukien['status_kehoach'] == null) {
                                $cdctime = MenuItems::where('parent',$v)->where('sort', $sort + 1)->first();
                                $dukien->end_time = $cdctime->start_time;
                                $dukien->start_time = date('H:i',$this->divisionDinhmuc($dukien->dinhmuc,$cdctime->start_time,$cdctime->start_date,$dukien->sort));
                                $dukien->start_date = date('Y-m-d',$this->divisionDinhmuc($dukien->dinhmuc,$cdctime->start_time,$cdctime->start_date,$dukien->sort));
                                $dukien->end_date = $cdctime->start_date;
                                $dukien->sort = $dukien->sort;
                                $dukien->timeChinh = $cdctime->id;
                                $dukien->save();
                            }
                        }
                    }
                }
            }
        }

        $boom = DuKien::where('name',$request->kien)->where('lenh',$request->lenh)->get();
        $var_lenh = $request->lenh;
        $merge = $boom->map(function($value) use ($var_lenh) {
            $boomsons = DuKien::where('parent',$value->id)->where('lenh',$var_lenh)->get()->toArray();
            $group = array_merge([$value->toArray()],$boomsons);
            return $group;
        });
        // dd($merge);
        foreach ($merge as $v) {
            foreach ($v as $key => $value) {
                $dukien = new DuKien;
                $dukien->name = $value['name'];
                $dukien->lenh = $request->lenh;
                $dukien->lenh_tach = $request->lenh.'_'.$request->sort; // nếu tách riêng thì đặt code khác $request->item
                $dukien->item = $value['item'];
                $dukien->mota = 'Tách từ item '.$value['item'];
                $dukien->so_luong = $request->soluong;
                $idParent = DuKien::where('parent', 0)->orderBy('id', 'desc')->first();
                $dukien->parent = ($value['parent'] == 0) ? 0 : $idParent->id;
                $dukien->dinhmuc = $value['dinhmuc'];
                $dukien->tre = $value['tre'];
                $dukien->depth = $value['depth'];
                $dukien->status = $value['status'];
                $dukien->opposites = $value['opposites'];
                $dukien->date_nhapkho = $value['date_nhapkho'];
                if($value['status'] == 1 or $value['parent'] == 0) {
                    $dukien->start_time = $value['start_time'];
                    $dukien->date_time = $value['date_time'];
                }
                $dukien->menu = 1;
                $dukien->date = $dt->toDateString();
                if ($value['parent'] == 0) {
                    $dukien->sort = 0;
                }else {
                    $dukien->sort = $value['sort'];  
                }
                $dukien->save();
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Lưu Thành Công'
        ], 200);
    }

    public function removeLenh(Request $request)
    {
        // dd($request->all());
        $Lenh = Lenh::where('lenh_link',$request->lenh_link)->where('position_order',$request->sort)->first();
        $findId = MenuItems::find($request->id);
        $enable = DuKien::where('id',$findId->id_kehoach)->update(['duyet' => 0]);

        Lenh::find($Lenh->id)->delete();
        MenuItems::whereIn('id',json_decode($Lenh->id_menu))->delete(); // xóa parent
        foreach (json_decode($Lenh->id_menu) as $key => $value) {
            $id[] = MenuItems::where('parent',$value)->pluck('id');
        }
        foreach ($id as $k => $v) {
            MenuItems::whereIn('id',$v)->delete();
        }

        $parent = Lenh::where('position_order','>',$request->sort)->orderBy('position_order', 'asc')->pluck('id_menu');
        $gop=[];
        foreach(json_decode($parent) as $array){
            $gop = array_merge($gop, json_decode($array));
        }
        foreach ($gop as $key => $value) {
            $all = MenuItems::where('parent',$value)->get();
            $idAfter = [];
            foreach ($all as $k => $v) {
                $lenh = MenuItems::where('parent',$v->parent)->where('sort',$v->sort)->first();
                $idSort = MenuItems::where('parent',$v->parent)->where('status',1)->first();
                if($v->sort < $idSort->sort) {
                    $idAfter[$v->sort] = $v->parent;
                }
                $cdctime = MenuItems::where('status', 1)->where('parent',$this->findafter($v->parent))->first();
                if($v->status == 1) {
                    $lenh->start_time = $cdctime->end_time;
                    $lenh->end_time = date('H:i',$this->ai($v->dinhmuc,$cdctime->end_time,$cdctime->end_date,$v->sort));
                    $lenh->start_date = $cdctime->end_date;
                    $lenh->end_date = date('Y-m-d',$this->ai($v->dinhmuc,$cdctime->end_time,$cdctime->end_date,$v->sort));
                    $lenh->timeChinh = $cdctime->id;
                }
                if($v->sort > $idSort->sort) { // sửa lại nếu cần sửa theo id
                    $cdttime = MenuItems::where('sort',$v->sort - 1)->where('parent',$v->parent)->first();
                    $lenh->start_time = $cdttime->end_time;
                    $lenh->end_time = date('H:i',$this->ai($v->dinhmuc,$cdttime->end_time,$cdttime->end_date,$v->sort));
                    $lenh->start_date = $cdttime->end_date;
                    $lenh->end_date = date('Y-m-d',$this->ai($v->dinhmuc,$cdttime->end_time,$cdttime->end_date,$v->sort));
                    $lenh->timeChinh = $cdctime->id;
                }
                $lenh->save();
            }
            if (isset($idAfter)) {
                if (is_array($idAfter) || is_object($idAfter)){
                    if(count($idAfter) != 0){
                        krsort($idAfter);
                        // dd($idAfter);
                        foreach ($idAfter as $sort => $v) {
                            $dukien = MenuItems::where('parent',$v)->where('sort', $sort)->first();
                            if ($dukien['status_kehoach'] == null) {
                                $cdctime = MenuItems::where('parent',$v)->where('sort', $sort + 1)->first();
                                $dukien->end_time = $cdctime->start_time;
                                $dukien->start_time = date('H:i',$this->divisionDinhmuc($dukien->dinhmuc,$cdctime->start_time,$cdctime->start_date,$dukien->sort));
                                $dukien->start_date = date('Y-m-d',$this->divisionDinhmuc($dukien->dinhmuc,$cdctime->start_time,$cdctime->start_date,$dukien->sort));
                                $dukien->end_date = $cdctime->start_date;
                                $dukien->sort = $dukien->sort;
                                $dukien->timeChinh = $cdctime->id;
                                $dukien->save();
                            }
                        }
                    }
                }
            }
        }

        $reset = Lenh::where('position_order','>',$request->sort)->orderBy('position_order', 'asc')->get();
        foreach ($reset as $key => $value) {
            $update = Lenh::find($value->id);
            $update->position_order = $value->position_order - 1;
            $update->sort_order = $value->position_order - 1;
            $update->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Lưu Thành Công'
        ], 200);
    }

    public function tamdunglenh(Request $r)
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh');

        $lenh = MenuItems::where('sort',$r->sort)->where('parent',$r->parent)->first();
        $lenh->end_time = $dt->toTimeString();
        $lenh->end_date = $dt->toDateString();
        $lenh->status_kehoach = 3;
        $lenh->sl_dsx = $r->sl_dsx;
        $lenh->save();

        return response()->json([
            'status' => true,
            'message' => 'Cập Nhật Thành Công',
            'select'  => $r->select,
            'parent' => $r->parent,
        ], 200);
    }

    public function createdk(Request $request)
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $getSL = MenuItems::where('lenh_name',$request->lenhname)->min('sl_dsx');
        $soluong_new = $request->soluong - $getSL;
        $heso = (integer)$request->soluong / $getSL;
        $checkItem = Item::where('name',$request->item)->where('so_luong',$soluong_new)->get();
        if($checkItem->isEmpty()){
            $All = MenuItems::where('lenh_name',$request->lenhname)->join('sorting_items', 'admin_menu_items.lenh_name', '=', 'sorting_items.lenh_link')->get();
            foreach ($All as $key => $value) {
                $dukien = new DuKien;
                $dukien->name = $value->label;
                $dukien->lenh = $request->lenh;
                $dukien->lenh_tach = $request->lenh.'_'.$soluong_new;
                $dukien->item = $request->item;
                $dukien->mota = 'Tạo từ lệnh '.$request->lenh.' số lượng '.$request->soluong;
                $dukien->so_luong = $soluong_new;
                $dukien->date = $dt->toDateString();
                $dukien->start_time = date('H:i',strtotime($value->date_nhapkho));
                $dukien->date_nhapkho = date('Y-m-d',strtotime($value->date_nhapkho));
                if($value->parent > 0){
                    $dukien->parent = DuKien::where('parent',0)->orderBy('id','desc')->first()->id;
                }else{
                    $dukien->parent = $value->parent;
                }
                $tach = explode(":", $value->dinhmuc);
                $time = $tach[0]*3600 + $tach[1]*60;
                $second_new = $time / $heso;
                $min = ($time - $second_new) / 60;
                $hour = $second_new / 3600;
                if($hour < 3601) {
                    $dukien->dinhmuc = '00:'.round($min);
                }else{
                    $dukien->dinhmuc = $hour.':'.round($min);
                }
                $dukien->tre = $value->tre;
                $dukien->depth = $value->depth;
                $dukien->status =  $value->status;
                $dukien->opposites = 0;
                $dukien->menu = 1;
                $dukien->sort = $value->sort; 
                $dukien->save();
            }
        }else{
            $item = Item::where('name',$request->item)->where('so_luong',$soluong_new)->first();
            $nhapkho = Lenh::where('lenh_link',$request->lenhname)->first();
            $boom = Kien::whereIn('id',json_decode($item->kien_id))->get();
            $merge = $boom->map(function($value) {
                $boomsons = Kien::where('parent',$value->id)->get()->toArray();
                $group = array_merge([$value->toArray()],$boomsons);
                return $group;
            });

            foreach ($merge as $v) {
                foreach ($v as $key => $getNext) {
                    $dukien = new DuKien;
                    $dukien->name = $getNext['name'];
                    $dukien->lenh = $request->lenh;
                    $dukien->lenh_tach =$request->lenh;
                    $dukien->item = $request->item;
                    $dukien->mota = 'Tạo từ lệnh '.$request->lenh.' số lượng '.$request->soluong;
                    $dukien->so_luong = $soluong_new;
                    $dukien->date_nhapkho = date('Y-m-d',strtotime($nhapkho->date_nhapkho));
                    $idParent = DuKien::where('parent', 0)->orderBy('id', 'desc')->first();
                    $dukien->parent = ($getNext['parent'] == 0) ? 0 : $idParent->id;
                    $dukien->dinhmuc = $getNext['dinhmuc'];
                    $dukien->tre = $getNext['tre'];
                    $dukien->depth = $getNext['depth'];
                    $dukien->status = $getNext['status'];
                    $dukien->opposites = $getNext['opposites'];
                    if($getNext['status'] == 1) {
                        $dukien->start_time =  date('H:i',strtotime($nhapkho->date_nhapkho));
                        $date_nk = date('Y-m-d',strtotime($nhapkho->date_nhapkho));
                        $dukien->date_time = date('Y-m-d H:i',$this->divisionDinhmuc($getNext['dinhmuc'], date('H:i',strtotime($nhapkho->date_nhapkho)),$date_nk,$getNext['sort']));
                    }
                    $dukien->menu = 1;
                    $dukien->date = $dt->toDateString();
                    if ($getNext['parent'] == 0) {
                        $dukien->start_time =  date('H:i',strtotime($nhapkho->date_nhapkho));
                        $date_nk = date('Y-m-d',strtotime($nhapkho->date_nhapkho));
                        $dukien->date_time = date('Y-m-d H:i',$this->divisionDinhmuc($getNext['dinhmuc'], date('H:i',strtotime($nhapkho->date_nhapkho)),$date_nk,1));
                        $dukien->sort = 0;
                    }else {
                        $dukien->sort = $getNext['sort'];  
                    }
                    $dukien->save();
                }
            }
        }
    }

    public function note(Request $request)
    {
        $content = MenuItems::where('parent',$request->id)->where('sort',$request->sort)->first();
        $import = new Comment;
        $import->id_lenh = $content['id'];
        $import->user_id = \Auth::user()->id;
        $import->content = $request->content;
        $import->type = $request->type;
        $import->save();
        return response()->json([
            'status' => true,
            'message' => 'Cập Nhật Thành Công',
        ], 200);
    }

    public function showVatTu(Request $request){
        $check = VatTu::where('id_parent_vt',$request->kehoach)->first();
        if($request->stt == 1) {
            $data = json_decode($check['tailieu_mot']);
            $user = $check['user_id1'];
        }
        if($request->stt == 2) {
            $data = json_decode($check['tailieu_hai']);
            $user = $check['user_id2'];
        }
        if($request->stt == 3) {
            $data = json_decode($check['tailieu_ba']);
            $user = $check['user_id3'];
        }
        $idMedia = MediaVatTu::where('id_lenh',$request->kehoach)->whereIn('id',$data)->pluck('link');
        $all = array_merge(['user' => $user],['link'=>$idMedia]);
        // dd($all);
        return response()->json($all, 200);
    }

    public function addVattu(Request $request)
    {
        // dd($request->all());
        $dt = Carbon::now('Asia/Ho_Chi_Minh');

        if ($request->uploadfile != null) {
            foreach($request->uploadfile as $file) {
                if (is_file($file)) {
                    $new_name = rand().'.'.$file->getClientOriginalExtension();
                    Storage::disk('public_uploads')->putFileAs('vt', $file, $new_name);
                    $media = new MediaVatTu;
                    $media->id_lenh = $request->kehoach;
                    $media->link = '/storage/vt/'.$new_name;
                    $media->save();
                }
            }
        }

        $check = VatTu::where('id_parent_vt',$request->kehoach)->get();
        if($check->isEmpty()) {
            $idMedia = MediaVatTu::where('id_lenh',$request->kehoach)->pluck('id');
            $nhapkho = new VatTu;
            $nhapkho->id_parent_vt = $request->kehoach;
            if ($request->xuatdu == 1) {
                $nhapkho->status_vt = 1;
            }
            $nhapkho->lan_mot_vt = $request->vattu;
            $nhapkho->time_mot_vt = $dt;
            $nhapkho->tailieu_mot = json_encode($idMedia);
            $nhapkho->user_id1 = \Auth::user()->name;
            $nhapkho->save();
        }else {
            $nhapkho = VatTu::where('id_parent_vt',$request->kehoach)->first();
            if($nhapkho->lan_mot_vt == null){
                $idMedia = MediaVatTu::where('id_lenh',$request->kehoach)->pluck('id');
                $nhapkho->id_parent_vt = $request->kehoach;
                if ($request->xuatdu == 1) {
                    $nhapkho->status_vt = 1;
                }
                $nhapkho->lan_mot_vt = $request->vattu;
                $nhapkho->time_mot_vt = $dt;
                $nhapkho->tailieu_mot = json_encode($idMedia);
                $nhapkho->user_id1 = \Auth::user()->name;
                $nhapkho->save();
            }else{
                if($nhapkho->lan_hai_vt == null){
                    $idMedia = MediaVatTu::where('id_lenh',$request->kehoach)->whereNotIn('id',json_decode($nhapkho['tailieu_mot']))->pluck('id');
                    $nhapkho->id_parent_vt = $request->kehoach;
                    if ($request->xuatdu == 1) {
                        $nhapkho->status_vt = 1;
                    }
                    $nhapkho->lan_hai_vt = $request->vattu;
                    $nhapkho->time_hai_vt = $dt;
                    $nhapkho->tailieu_hai = json_encode($idMedia);
                    $nhapkho->user_id2 = \Auth::user()->name;
                    $nhapkho->save();
                }else{
                    if($nhapkho->lan_ba_vt == null){
                        $idMedia = MediaVatTu::where('id_lenh',$request->kehoach)->whereNotIn('id',json_decode($nhapkho['tailieu_mot']))->whereNotIn('id',json_decode($nhapkho['tailieu_hai']))->pluck('id');
                        $nhapkho->id_parent_vt = $request->kehoach;
                        $nhapkho->status_vt = 1;
                        $nhapkho->lan_ba_vt = $request->vattu;
                        $nhapkho->time_ba_vt = $dt;
                        $nhapkho->tailieu_ba = json_encode($idMedia);
                        $nhapkho->user_id3 = \Auth::user()->name;
                        $nhapkho->save();
                    }
                }
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Lưu Thành Công'
        ], 200);
    }

    public function nhapkho(Request $request)
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        
        if ($request->loai == 2) {
            $nhapkho = NhapKho::where('id_parent',$request->id_kehoach)->first();
            if($request->sl_nhapkho == null) {
                if($nhapkho->lan_mot == null){
                    $nhapkho->status_nk = 1;
                    $nhapkho->lan_mot = $request->soluong;
                    $nhapkho->time_mot = $dt;
                    $nhapkho->save();
                }else{
                    if($nhapkho->lan_hai == null){
                        $nhapkho->status_nk = 1;
                        $nhapkho->lan_hai = $request->soluong - $nhapkho->lan_mot;
                        $nhapkho->time_hai = $dt;
                        $nhapkho->save();
                    }else{
                        if($nhapkho->lan_ba == null){
                            $nhapkho->status_nk = 1;
                            $nhapkho->lan_ba = $request->soluong - $nhapkho->lan_hai - $nhapkho->lan_mot;
                            $nhapkho->time_ba = $dt;
                            $nhapkho->save();
                        }else{
                            if($nhapkho->lan_bon == null){
                                $nhapkho->status_nk = 1;
                                $nhapkho->lan_bon = $request->soluong - $nhapkho->lan_ba - $nhapkho->lan_hai - $nhapkho->lan_mot;
                                $nhapkho->time_bon = $dt;
                                $nhapkho->save();
                            }else{
                                if($nhapkho->lan_nam == null){
                                    $nhapkho->status_nk = 1;
                                    $nhapkho->lan_nam = $request->soluong - $nhapkho->lan_bon - $nhapkho->lan_ba - $nhapkho->lan_hai - $nhapkho->lan_mot;
                                    $nhapkho->time_nam = $dt;
                                    $nhapkho->save();
                                }
                            }
                        }
                    }
                }
            }else{
                if($nhapkho->lan_mot == null) {
                    $nhapkho->lan_mot = $request->sl_nhapkho;
                    $nhapkho->time_mot = $dt;
                    $nhapkho->save();
                }else{
                    if($nhapkho->lan_hai == null){
                        $nhapkho->lan_hai = $request->sl_nhapkho;
                        $nhapkho->time_hai = $dt;
                        $nhapkho->save();
                    }else{
                        if($nhapkho->lan_ba == null){
                            $nhapkho->lan_ba = $request->sl_nhapkho;
                            $nhapkho->time_ba = $dt;
                            $nhapkho->save();
                        }else{
                            if($nhapkho->lan_bon == null){
                                $nhapkho->lan_bon = $request->sl_nhapkho;
                                $nhapkho->time_bon = $dt;
                                $nhapkho->save();
                            }else{
                                if($nhapkho->lan_nam == null){
                                    $nhapkho->status_nk = 1;
                                    $nhapkho->lan_nam = $request->sl_nhapkho;
                                    $nhapkho->time_nam = $dt;
                                    $nhapkho->save();
                                }
                            }
                        }
                    }
                }
            }
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Lưu Thành Công'
        ], 200);
    }

    public function store()
    {
        $sort_old = Lenh::pluck('position_order','id');
        foreach($sort_old as $k=>$v){
            $lenh = Lenh::find($k);
            $lenh->sort_order=$v;
            $lenh->save();
        }
        return response()->json([
            'status' => true,
            'message' => 'Lưu Thành Công'
        ], 200);
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
        $merged=[];
        foreach(json_decode($parent) as $array){
            $merged = array_merge($merged, json_decode($array));
        }
        foreach ($merged as $key => $value) {
            $all = MenuItems::where('parent',$value)->get();
            $idAfter = [];
            foreach ($all as $k => $v) {
                $lenh = MenuItems::where('parent',$v->parent)->where('sort',$v->sort)->first();
                $idSort = MenuItems::where('parent',$v->parent)->where('status',1)->first();
                if($v->sort < $idSort->sort) {
                    $idAfter[$v->sort] = $v->parent;
                }
                $cdctime = MenuItems::where('status', 1)->where('parent',$this->findafter($v->parent))->first();
                if($v->status == 1) {
                    $lenh->start_time = $cdctime->end_time;
                    $lenh->end_time = date('H:i',$this->ai($v->dinhmuc,$cdctime->end_time,$cdctime->end_date,$v->sort));
                    $lenh->start_date = $cdctime->end_date;
                    $lenh->end_date = date('Y-m-d',$this->ai($v->dinhmuc,$cdctime->end_time,$cdctime->end_date,$v->sort));
                    $lenh->timeChinh = $cdctime->id;
                }
                if($v->sort > $idSort->sort) { // sửa lại nếu cần sửa theo id
                    $cdttime = MenuItems::where('sort',$v->sort - 1)->where('parent',$v->parent)->first();
                    $lenh->start_time = $cdttime->end_time;
                    $lenh->end_time = date('H:i',$this->ai($v->dinhmuc,$cdttime->end_time,$cdttime->end_date,$v->sort));
                    $lenh->start_date = $cdttime->end_date;
                    $lenh->end_date = date('Y-m-d',$this->ai($v->dinhmuc,$cdttime->end_time,$cdttime->end_date,$v->sort));
                    $lenh->timeChinh = $cdctime->id;
                }
                $lenh->save();
            }
            if (isset($idAfter)) {
                if (is_array($idAfter) || is_object($idAfter)){
                    if(count($idAfter) != 0){
                        krsort($idAfter);
                        // dd($idAfter);
                        foreach ($idAfter as $sort => $v) {
                            $dukien = MenuItems::where('parent',$v)->where('sort', $sort)->first();
                            if ($dukien['status_kehoach'] == null) {
                                $cdctime = MenuItems::where('parent',$v)->where('sort', $sort + 1)->first();
                                $dukien->end_time = $cdctime->start_time;
                                $dukien->start_time = date('H:i',$this->divisionDinhmuc($dukien->dinhmuc,$cdctime->start_time,$cdctime->start_date,$dukien->sort));
                                $dukien->start_date = date('Y-m-d',$this->divisionDinhmuc($dukien->dinhmuc,$cdctime->start_time,$cdctime->start_date,$dukien->sort));
                                $dukien->end_date = $cdctime->start_date;
                                $dukien->sort = $dukien->sort;
                                $dukien->timeChinh = $cdctime->id;
                                $dukien->save();
                            }
                        }
                    }
                }
            }
        }
    }

    public function findafter($value)
    {
        $parent = Lenh::orderBy('position_order', 'asc')->pluck('id_menu');
        $merged=[];
        foreach(json_decode($parent) as $array){
            $merged = array_merge($merged, json_decode($array));
        }
        $key = array_search($value, $merged);
        for ($i=1; $i < count($merged); $i++) { 
            $idAfter = $merged[$key-$i];
            $check = MenuItems::where('parent',$idAfter)->get();
            if ($check->isNotEmpty()) {
                $id = $idAfter;
                break;
            }
        }
        // dd($id);
        return $id;
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

    public function qclenh(Request $r)
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $qc = MenuItems::where('parent',$r->parent)->where('sort',$r->sort)->first();
        if ($r->status == 1) {
            $qc->qc_start = $dt->toDateTimeString();
        }
        if ($r->status == 2) {
            $qc->qc_end = $dt->toDateTimeString();
        }
        $qc->save();
        return response()->json([
            'status'  => true,
            'message' => 'Cập Nhật Thành Công',
            'select'  => $r->select,
            'parent' => $r->parent,
        ], 200);
    }

    public function update(Request $r)
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $lenh = MenuItems::where('sort',$r->sort)->where('parent',$r->parent)->first();
        if($r->status == 1) {
            $lenh->start_date = $dt->toDateString();
            $lenh->start_time = $dt->toTimeString();
            $lenh->end_time = date('H:i',$this->ai($lenh->dinhmuc,$dt->toTimeString(),$dt->toDateString(),$r->sort));
            $lenh->end_date = date('Y-m-d',$this->ai($lenh->dinhmuc,$dt->toTimeString(),$dt->toDateString(),$r->sort));
            $lenh->status_kehoach = 1;
        }
        if($r->status == 2) {
            $lenh->end_time = $dt->toTimeString();
            $lenh->end_date = $dt->toDateString();
            $lenh->status_kehoach = 2;
        }
        $lenh->save();

        $getCDC = MenuItems::where('parent',$r->parent)->where('status',1)->first();
        $allBefore = MenuItems::where('parent',$r->parent)->where('sort','>',$r->sort)->pluck('status_kehoach','sort');
        $allAfter = MenuItems::where('parent',$r->parent)->where('sort','<',$r->sort)->pluck('status_kehoach','sort')->toArray();
        foreach ($allBefore as $key => $value) {
            if($value == null and $key > $getCDC->sort) {
                $update = MenuItems::where('sort',$key)->where('parent',$r->parent)->first();
                $findidpre = MenuItems::where('sort','<',$key)->where('parent',$r->parent)->max('sort');
                $cdctime = MenuItems::where('sort',$findidpre)->where('parent',$r->parent)->first();
                $update->start_time = $cdctime->end_time;
                $update->end_time = date('H:i',$this->ai($update->dinhmuc,$cdctime->end_time,$cdctime->end_date,$r->sort));
                $update->start_date = $cdctime->end_date;
                $update->end_date = date('Y-m-d',$this->ai($update->dinhmuc,$cdctime->end_time,$cdctime->end_date,$r->sort));
                $update->timeChinh = $cdctime->id; 
                $update->save();
            }
        }
        krsort($allAfter);
        foreach ($allAfter as $key => $value) {
            if($value == null and $key < $getCDC->sort) {
                $update = MenuItems::where('sort',$key)->where('parent',$r->parent)->first();
                $cdctime = MenuItems::where('sort',$key + 1)->where('parent',$r->parent)->first();
                $update->end_time = $cdctime['start_time'];
                $update->start_time = date('H:i',$this->divisionDinhmuc($update->dinhmuc,$cdctime->start_time,$cdctime->start_date,$update->sort));
                $update->start_date = date('Y-m-d',$this->divisionDinhmuc($update->dinhmuc,$cdctime->start_time,$cdctime->start_date,$update->sort));
                $update->end_date = $cdctime->start_date;
                $update->save();
            }
        }

        if ($r->chinh == 1) {
            $getList = Lenh::orderBy('position_order', 'asc')->pluck('id_menu');
            $merged=[];
            foreach(json_decode($getList) as $array){
                $merged = array_merge($merged, json_decode($array));
            }
            $position_parent = array_search($r->parent, $merged);
            array_splice($merged, 0, $position_parent + 1);
            // dd($getLenh);

            foreach ($merged as $value) {
                $listLenh = MenuItems::where('parent',$value)->get();
                $idAfter = [];
                foreach ($listLenh as $k => $val) {
                    $sortChinh = MenuItems::where('parent',$val->parent)->where('status',1)->first();

                    if($val->sort < $sortChinh->sort) {
                        $idAfter[$val->sort] = $val->parent;
                    }

                    if($val->status == 1 and $val->status_kehoach == null) {
                        $insert = MenuItems::where('sort',$val->sort)->where('parent',$val->parent)->first();
                        $key_now = array_search($val->parent, $merged);
                        if($key_now == 0) {
                            $idParent = $r->parent;
                        }else{
                            $key_after = $key_now - 1;
                            $idParent = $merged[$key_after];
                        }
                        $cdctime = MenuItems::where('parent',$idParent)->where('status',1)->first();
                        $insert->start_time = $cdctime->end_time;
                        $insert->end_time = date('H:i',$this->ai($val->dinhmuc,$cdctime->end_time,$cdctime->end_date,$val->sort));
                        $insert->start_date = $cdctime->end_date;
                        $insert->end_date = date('Y-m-d',$this->ai($val->dinhmuc,$cdctime->end_time,$cdctime->end_date,$val->sort));
                        $insert->save();
                    }
                    if($val->sort > $sortChinh->sort and $val->status_kehoach == null) {
                        $insert = MenuItems::where('sort',$val->sort)->where('parent',$val->parent)->first();
                        $cdctime = MenuItems::where('sort',$val->sort - 1)->where('parent',$val->parent)->first();
                        $insert->start_time = $cdctime->end_time;
                        $insert->end_time = date('H:i',$this->ai($val->dinhmuc,$cdctime->end_time,$cdctime->end_date,$val->sort));
                        $insert->start_date = $cdctime->end_date;
                        $insert->end_date = date('Y-m-d',$this->ai($val->dinhmuc,$cdctime->end_time,$cdctime->end_date,$val->sort));
                        $insert->save();
                    }
                }
                if (isset($idAfter)) {
                    if (is_array($idAfter) || is_object($idAfter)){
                        if(count($idAfter) != 0){
                            krsort($idAfter);
                            foreach ($idAfter as $sort => $v) {
                                $insert = MenuItems::where('parent',$v)->where('sort', $sort)->first();
                                if ($insert['status_kehoach'] == null) {
                                    $cdctime = MenuItems::where('parent',$v)->where('sort', $sort + 1)->first();
                                    $insert->end_time = $cdctime['start_time'];
                                    $insert->start_time = date('H:i',$this->divisionDinhmuc($insert->dinhmuc,$cdctime->start_time,$cdctime->start_date,$insert->sort));
                                    $insert->start_date = date('Y-m-d',$this->divisionDinhmuc($insert->dinhmuc,$cdctime->start_time,$cdctime->start_date,$insert->sort));
                                    $insert->end_date = $cdctime->start_date;
                                    $insert->save();
                                }
                            }
                        }
                    }
                }
            }
            // dd($a);
        }
        return response()->json([
            'status'  => true,
            'message' => 'Cập Nhật Thành Công',
            'select'  => $r->select,
            'parent' => $r->parent,
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

    public function targetF($dinhmuc,$times,$dates,$timef,$datef,$label)
    {
        $format = ' Y-m-d';
        $start = $dates;
        $end = $datef;
        $array = array(); 
        $interval = new DateInterval('P1D'); 
        $realEnd = new DateTime($end); 
        $realEnd->add($interval); 
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
        foreach($period as $date) {                  
            $array[] = $date->format($format);  
        } 

        $stt = CongDoan::where('name',$label)->first();
        date_default_timezone_set('UTC');
        if(count($array) == 1) {
            $getam = QuyNgayNew::where('date',$dates)->where('name_id',$stt->id)->first();
            $checkam = strtotime($getam->end_am) - strtotime($times);
            $checkf = strtotime($getam->end_am) - strtotime($timef);
            if($checkam >= 0) {
                if($checkf >= 0) {
                    $th1 = strtotime($timef) - strtotime($times);
                    $thucte = explode(':', date('H:i',$th1));
                    $dm = explode(':',date('H:i',strtotime($dinhmuc)));
                    $sbc = $thucte[0]*60 + $thucte[1];
                    $sc = $dm[0]*60 + $dm[1];
                    $div = number_format($sbc/$sc*100,0).'%'; // Đúng
                    $target = [date('H:i',$th1),$div];
                    return $target;
                }
                if($checkf < 0){
                    $th2 = strtotime($timef) - strtotime($getam->start_pm) + strtotime($getam->end_am) - strtotime($times);
                    $thucte = explode(':', date('H:i',$th2));
                    $dm = explode(':',date('H:i',strtotime($dinhmuc)));
                    $sbc = $thucte[0]*60 + $thucte[1];
                    $sc = $dm[0]*60 + $dm[1];
                    $div = number_format($sbc/$sc*100,0).'%'; // Đúng
                    $target = [date('H:i',$th2),$div];
                    return $target; //date('H:i',$th2);
                }
            }else {
                $th1 = strtotime($timef) - strtotime($times);
                $thucte = explode(':', date('H:i',$th1));
                $dm = explode(':',date('H:i',strtotime($dinhmuc)));
                $sbc = $thucte[0]*60 + $thucte[1];
                $sc = $dm[0]*60 + $dm[1];
                $div = number_format($sbc/$sc*100,0).'%'; // Đúng
                $target = [date('H:i',$th1),$div];
                return $target;
            }
        }
        if(count($array) == 2) {
            $getams = QuyNgayNew::where('date',$dates)->where('name_id',$stt->id)->first();
            $getamf = QuyNgayNew::where('date',$datef)->where('name_id',$stt->id)->first();
            $checkam = strtotime($getams->end_am) - strtotime($times);
            $checkf = strtotime($getamf->end_am) - strtotime($timef);
            if($checkam >= 0) {
                if($checkf >= 0) {
                    $th1 = strtotime($timef) - strtotime($getamf->start_am) + strtotime($getams->end_pm) - strtotime($getams->start_pm) + strtotime($getams->end_am) - strtotime($times);
                    $thucte = explode(':', date('H:i',$th1));
                    $dm = explode(':',date('H:i',strtotime($dinhmuc)));
                    $sbc = $thucte[0]*60 + $thucte[1];
                    $sc = $dm[0]*60 + $dm[1];
                    $div = number_format($sbc/$sc*100,0).'%'; // Đúng
                    $target = [date('H:i',$th1),$div];
                    return $target;
                }
                if($checkf < 0){
                    $th2 = strtotime($timef) - strtotime($getamf->start_pm) + strtotime($getamf->end_am) - strtotime($getamf->start_am) + strtotime($getams->end_pm) - strtotime($getams->start_pm) + strtotime($getams->end_am) - strtotime($times);
                    $thucte = explode(':', date('H:i',$th2));
                    $dm = explode(':',date('H:i',strtotime($dinhmuc)));
                    $sbc = $thucte[0]*60 + $thucte[1];
                    $sc = $dm[0]*60 + $dm[1];
                    $div = number_format($sbc/$sc*100,0).'%'; // Đúng
                    $target = [date('H:i',$th2),$div];
                    return $target; //date('H:i',$th2);
                }
            }else {
                if($checkf >= 0) {
                    $th1 = strtotime($timef) - strtotime($getamf->start_am) + strtotime($getams->end_pm) - strtotime($times);
                    $thucte = explode(':', date('H:i',$th1));
                    $dm = explode(':',date('H:i',strtotime($dinhmuc)));
                    $sbc = $thucte[0]*60 + $thucte[1];
                    $sc = $dm[0]*60 + $dm[1];
                    $div = number_format($sbc/$sc*100,0).'%'; // Đúng
                    $target = [date('H:i',$th1),$div];
                    return $target;
                }
                if($checkf < 0){
                    $th2 = strtotime($timef) - strtotime($getamf->start_pm) + strtotime($getamf->end_am) - strtotime($getamf->start_am) + strtotime($getams->end_pm) - strtotime($times);
                    $thucte = explode(':', date('H:i',$th2));
                    $dm = explode(':',date('H:i',strtotime($dinhmuc)));
                    $sbc = $thucte[0]*60 + $thucte[1];
                    $sc = $dm[0]*60 + $dm[1];
                    $div = number_format($sbc/$sc*100,0).'%'; // Đúng
                    $target = [date('H:i',$th2),$div];
                    return $target;
                }
            }
        }
        if (count($array) > 2) {
            $del_end = array_pop($array);
            $del_start = array_shift($array);
            $getams = QuyNgayNew::where('date',$dates)->where('name_id',$stt->id)->first();
            $getamf = QuyNgayNew::where('date',$datef)->where('name_id',$stt->id)->first();
            $checkam = strtotime($getams->end_am) - strtotime($times);
            $checkf = strtotime($getamf->end_am) - strtotime($timef);

            $time_work = QuyNgayNew::whereIn('date',$array)->where('name_id',$stt->id)->get();
            foreach ($time_work as $key => $value) {
                $time_chinh = explode(':', $value->time_work);
                $hour[] = $time_chinh[0];
                $min[] = $time_chinh[1];
            }       
            $total_hour = array_sum($hour); 
            $total_min = array_sum($min);

            if($checkam >= 0) {
                if($checkf >= 0) {
                    $th1 = strtotime($timef) - strtotime($getamf->start_am) + strtotime($getams->end_pm) - strtotime($getams->start_pm) + strtotime($getams->end_am) - strtotime($times);
                    $thucte = explode(':', date('H:i',$th1));
                    $dm = explode(':',date('H:i',strtotime($dinhmuc)));
                    $sbc =($total_hour + $thucte[0])*60 + $thucte[1] + $total_min;
                    $sc = $dm[0]*60 + $dm[1];
                    $div = number_format($sbc/$sc*100,0).'%'; // Đúng
                    $target = [date('H:i',$th1),$div];
                }
                if($checkf < 0){
                    $th2 = strtotime($timef) - strtotime($getamf->start_pm) + strtotime($getamf->end_am) - strtotime($getamf->start_am) + strtotime($getams->end_pm) - strtotime($getams->start_pm) + strtotime($getams->end_am) - strtotime($times);
                    $thucte = explode(':', date('H:i',$th2));
                    $dm = explode(':',date('H:i',strtotime($dinhmuc)));
                    $sbc =($total_hour + $thucte[0])*60 + $thucte[1] + $total_min;
                    $sc = $dm[0]*60 + $dm[1];
                    $div = number_format($sbc/$sc*100,0).'%'; // Đúng
                    $target = [date('H:i',$th2),$div];
                    return $target; //date('H:i',$th2);
                }
            }else {
                if($checkf >= 0) {
                    $th1 = strtotime($timef) - strtotime($getamf->start_am) + strtotime($getams->end_pm) - strtotime($times);
                    $thucte = explode(':', date('H:i',$th1));
                    $dm = explode(':',date('H:i',strtotime($dinhmuc)));
                    $sbc =($total_hour + $thucte[0])*60 + $thucte[1] + $total_min;
                    $sc = $dm[0]*60 + $dm[1];
                    $div = number_format($sbc/$sc*100,0).'%'; // Đúng
                    $target = [date('H:i',$th1),$div];
                    return $target;
                }
                if($checkf < 0){
                    $th2 = strtotime($timef) - strtotime($getamf->start_pm) + strtotime($getamf->end_am) - strtotime($getamf->start_am) + strtotime($getams->end_pm) - strtotime($times);
                    $thucte = explode(':', date('H:i',$th2));
                    $dm = explode(':',date('H:i',strtotime($dinhmuc)));
                    $sbc =($total_hour + $thucte[0])*60 + $thucte[1] + $total_min;
                    $sc = $dm[0]*60 + $dm[1];
                    $div = number_format($sbc/$sc*100,0).'%'; // Đúng
                    $target = [date('H:i',$th2),$div];
                    return $target;
                }
            }
        }
    }
    public static function url_title($str, $separator = '', $lowercase = TRUE){
        if($separator == 'dash'){
            $separator = '-';
        }else{
            if($separator == 'underscore'){
                $separator = '_';
            }
        }
        $q_separator = preg_quote($separator);
        $trans       = array(
            '&.+?;'                               => '',
            'à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ'   => 'a',
            'è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ'               => 'e',
            'ì|í|ị|ỉ|ĩ'                           => 'i',
            'ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ'   => 'o',
            'ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ'               => 'u',
            'ỳ|ý|y|ỷ|ỹ'                           => 'y',
            'À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|A' => 'a',
            'È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|E'             => 'e',
            'Ì|Í|Ị|Ỉ|Ĩ|I'                         => 'i',
            'Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|O' => 'o',
            'Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|U'             => 'u',
            'Ỳ|Ý|Y|Ỷ|Ỹ|Y'                         => 'y',
            'đ|Đ'                                 => 'd',
            ' '                                   => $separator,
            '='                                   => $separator,
            '/'                                   => $separator,
            '[^a-z0-9 _-]'                        => '',
            '\s+'                                 => $separator,
            '(' . $q_separator . ')+'             => $separator
        );
        $str         = strip_tags($str);
        foreach($trans as $key => $val){
            $str = preg_replace("#" . $key . "#i", $val, $str);
        }
        if($lowercase === TRUE){
            $str = strtolower($str);
        }
        return trim($str, $separator);
    }
}
