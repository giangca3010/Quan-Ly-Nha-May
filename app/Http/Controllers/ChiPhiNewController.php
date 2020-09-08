<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChiPhi;
use App\User;
use App\LoaiChiPhi;
use App\DeXuat;
use App\MediaTaiLieu;
use App\CommentCP;
use App\InforUser;
use App\ItemKho;
use Input;
use Importer;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Bank;
use Carbon\Carbon;
use App\NhaCungCap;
use App\TimeLine;

class ChiPhiNewController extends Controller
{
    public function index()
    {
    	$name = 'Chi Phí Mới';
	    $action = 'Danh Sách';
        $user_id = \Auth::user()->id;
        if($user_id == 1){
    	    $chiphi = ChiPhi::where('id_phanloai','>',1)->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
        }elseif($user_id == 3){
            $chiphi = ChiPhi::where('id_phanloai','>',1)->where('status_duyet',4)->orwhere('status_duyet',5)->orwhere('status_duyet',6)->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
        }elseif($user_id == 47 or $user_id == 48 or $user_id == 49){
            $chiphi = ChiPhi::where('id_phanloai','>',1)->where('status_duyet',3)->orwhere('status_duyet',5)->orwhere('status_duyet',6)->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
        }else{
            $chiphi = ChiPhi::where('id_phanloai','>',1)->where('user_create',$user_id)->orwhere('user_dx',$user_id)->orwhere('user_duyet',$user_id)->orwhere('user_check',$user_id)->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
        }
        $loaichiphi = LoaiChiPhi::where('id','>',1)->get();
		$nhanvien = User::get();
        $itemkho = ItemKho::get();
        $role = Role::where('id','>',5)->get();
        $bank = Bank::all();
        $all = ChiPhi::All();
        // $list = [];$get = [];
        // foreach ($all as $key => $value) {
        //     if ($value['total'] > $value['tam_ung']) {
        //         $list[] = $value['stt'];
        //     }
        // }
        // if(count($list) > 0){
        //     foreach ($list as $v) {
        //         $loc = ChiPhi::where('id_phanloai','>',1)->where('stt',$v)->where('type','>',0)->where('user_create',\Auth::user()->id)->orwhere('user_dx',\Auth::user()->id)->orderBy('id_cp','desc')->first();
        //         dd($loc);
        //         if($loc['con_lai'] > 0 ){
        //             $get[] = $loc['id_cp'];
        //         }
        //     }
        // }
        // if(count($get) > 0){
        //     $tamung = ChiPhi::whereIn('id_cp',$get)->get();
        // }else{
        //     $tamung = array();
        // }
        $roleNT = \DB::table('model_has_roles')->whereIn('role_id',[29,26,18])->pluck('model_id');
        $nhanvienNT = User::whereIn('id',$roleNT)->get();
        // dd($chiphi);
	    return view('admin.chiphi.chiphinew',compact('name','action','chiphi','loaichiphi','nhanvien','itemkho','role','bank','nhanvienNT','user_id'));
    }

    public function add(Request $request)
    {
    	// dd($request->all());
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $time = $dt->getTimestamp();
        $chiphi = new ChiPhi;
        $chiphi->user_create = \Auth::user()->id;
        $chiphi->name_dx = $request->name;
        $chiphi->user_dx = $request->user_dx;
        $chiphi->user_duyet = $request->user_duyet;
        $chiphi->user_check = $request->user_check;
        $chiphi->status = $request->status;
        $chiphi->id_phanloai = $request->loaichiphi;
        $chiphi->chuy = $request->chuy;
        $chiphi->stt = $time;
        $chiphi->role_id = $request->role_dx;
        $chiphi->date_money = $request->date_money == null ? null : date('Y-m-d h:i:s', strtotime($request->date_money));
        $chiphi->date_need = $request->date_need == null ? null : date('Y-m-d h:i:s', strtotime($request->date_need));
        if ($request->checkbox) {
            $chiphi->type = 0;
        }
        $chiphi->save();

        $cp = ChiPhi::orderBy('id_cp','desc')->first();
        if ($request->file != null) {
            foreach($request->file as $file) {
                if (is_file($file)) {
                    $new_name = rand().'.'.$file->getClientOriginalExtension();
                    Storage::disk('public_uploads')->putFileAs('chiphi', $file, $new_name);
                    $media = new MediaTaiLieu;
                    $media->id_ma = $cp['id_cp'];
                    $media->roles = 5;
                    $media->link = '/storage/chiphi/'.$new_name;
                    $media->save();
                }
            }
        }

        $timeline = new TimeLine;
        $timeline->id_cp = $cp['id_cp']; 
        $timeline->user_id = \Auth::user()->id; 
        $timeline->icon =  'fa-plus';
        $timeline->process = 0; 
        $timeline->save();

        return back()->with('success', 'UpFile Thành Công');
    }

    public function showChiPhi(Request $r)
    {
        $chiphi = ChiPhi::where('id_cp',$r->id)->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
        $line = \DB::table('line_dexuat')->where('id_chiphi',$r->id)->get();
        $image = MediaTaiLieu::where('roles',5)->where('id_ma',$r->id)->get();
        $role = User::with('roles')->where('id',$chiphi[0]->user_dx)->get();
        return response()->json([
            'chiphi' => $chiphi[0],
            'list' => $line,
            'image' => $image,
            'role' => $role,
        ], 200);
    }

    public function edit(Request $request)
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $time = $dt->getTimestamp();
        $chiphi = ChiPhi::find($request->id);
        $chiphi->name_dx = $request->name;
        $chiphi->user_dx = $request->user_dx;
        $chiphi->user_duyet = $request->user_duyet;
        $chiphi->user_check = $request->user_check;
        $chiphi->status = $request->status;
        $chiphi->id_phanloai = $request->loaichiphi;
        $chiphi->chuy = $request->chuy;
        $chiphi->role_id = $request->role_dx;
        $chiphi->date_money = $request->date_money == null ? null : date('Y-m-d h:i:s', strtotime($request->date_money));
        $chiphi->date_need = $request->date_need == null ? null : date('Y-m-d h:i:s', strtotime($request->date_need));
        if ($request->checkbox) {
            $chiphi->type = 0;
        }
        $chiphi->save();

        if ($request->file != null) {
            foreach($request->file as $file) {
                if (is_file($file)) {
                    $new_name = rand().'.'.$file->getClientOriginalExtension();
                    Storage::disk('public_uploads')->putFileAs('chiphi', $file, $new_name);
                    $media = new MediaTaiLieu;
                    $media->id_ma = $request->id;
                    $media->roles = 5;
                    $media->link = '/storage/chiphi/'.$new_name;
                    $media->save();
                }
            }
        }
        return back()->with('success', 'UpFile Thành Công');
    }

    public function destroy($id)
    {
        ChiPhi::where('id_cp',$id)->delete();
        \DB::table('line_dexuat')->where('id_chiphi',$id)->delete();
        return redirect('chiphinew');
    }

    public function sendchiphi($id)
    {
        $ChiPhi = ChiPhi::find($id);
        $ChiPhi->status_duyet = 1;
        $ChiPhi->save();

        $timeline = new TimeLine;
        $timeline->id_cp = $id; 
        $timeline->user_id = \Auth::user()->id; 
        $timeline->process = 1; 
        $timeline->icon =  'fa-hourglass-start';

        $timeline->save();

        return redirect('chiphinew');
    }

    public function sendchiphil($id)
    {
        $ChiPhi = ChiPhi::find($id);
        if ($ChiPhi->user_duyet != null) {
            $stt = 2;
        }else{
            $stt = 3;
        }
        $ChiPhi->tra_lai = 0;
        $ChiPhi->status_duyet = $stt;
        $ChiPhi->save();
        return redirect('chiphinew');
    }

    public function addcheck(Request $request)
    {
        // dd($request->all());
        $chiphi = ChiPhi::find($request->id);
        $chiphi->total = $request->total;
        $chiphi->total_thuc =$request->total;
        $chiphi->tam_ung = $request->tamung;
        $chiphi->con_lai = (int)$request->total - (int)$request->tamung;
        $chiphi->save();
        $line = array_chunk($request->line, 8);
        foreach ($line as $key => $value) {
            $dexuat = new DeXuat;
            $dexuat->ten = $value[0];
            $dexuat->so_luong = $value[1];
            $dexuat->donvi = $value[2];
            $dexuat->giamgia = $value[3];
            $dexuat->money = $value[4];
            $dexuat->thanh_tien = $value[5];
            $dexuat->money_thucte = $value[5];
            $dexuat->content = $value[6];
            $dexuat->id_chiphi = $request->id;
            $dexuat->save();
        }

        // $timeline = new TimeLine;
        // $timeline->id_cp = $cp['id_cp']; 
        // $timeline->user_id = \Auth::user()->id; 
        // $timeline->process = 0; 
        // $timeline->save();
        return response()->json([
            'status' => true,
            'message' => 'Thêm Thành Công'
        ], 200);
    }

    public function duyetChiPhi(Request $r)
    {
        $ChiPhi = ChiPhi::find($r->id);
        $ChiPhi->status_duyet = $r->loai;
        $ChiPhi->tra_lai = 0;
        $ChiPhi->save();
        return response()->json([
            'status' => true,
            'message' => 'Sửa Thành Công'
        ], 200);
    }

    public function khongduyetChiPhi(Request $r)
    {
        $ChiPhi = ChiPhi::find($r->id);
        $ChiPhi->status_duyet = $r->loai - 2;
        $ChiPhi->tra_lai = 1;
        $ChiPhi->save();
        return response()->json([
            'status' => true,
            'message' => 'Sửa Thành Công'
        ], 200);
    }

    public function addbank(Request $request)
    {
        $chiphi = ChiPhi::find($request->id);
        $chiphi->id_bank = $request->id_bank;
        $chiphi->status_duyet = 6;
        $chiphi->save();
        return response()->json([
            'status' => true,
            'message' => 'Thêm Thành Công'
        ], 200);
    }

    public function duyethai(Request $request)
    {
        $line = array_chunk($request->line, 11);
        $chiphiold = ChiPhi::find($request->id);
        // dd($chiphiold->total_thuc);
        $idcpnew = ChiPhi::select('id_cp')->latest()->first()->id_cp;
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $time = $dt->getTimestamp();
        $chiphi = new ChiPhi;
        $chiphi->user_create = $chiphiold->user_create;
        $chiphi->name_dx = $chiphiold->name_dx;
        $chiphi->user_dx = $chiphiold->user_dx;
        $chiphi->status = $chiphiold->status;
        $chiphi->id_phanloai = $chiphiold->id_phanloai;
        $chiphi->total = $request->total_thuc;
        $chiphi->total_thuc = $request->total_thuc;
        $chiphi->chuy = $chiphiold->chuy;
        $chiphi->user_check = $chiphiold->user_check;
        $chiphi->user_duyet = $chiphiold->user_duyet;
        $chiphi->id_tu = $request->id;
        $chiphi->type = 1;
        $chiphi->tam_ung = $chiphiold->tamung;
        $chiphi->date_need = $chiphiold->date_need;
        $chiphi->tam_ung = $chiphiold->tam_ung;
        $chiphi->tra_lai = $chiphiold->tra_lai;
        $chiphi->con_lai = $chiphiold->con_lai;
        $chiphi->stt = $time;
        $chiphi->status_duyet = 4;
        $chiphi->bank_status = $request->total_thuc - $chiphiold->total_thuc;
        $chiphi->save();
        $chiphiold->id_tu = $idcpnew;
        $chiphiold->save();
        foreach ($line as $key => $value) {
            $dexuatold = DeXuat::find($value[0]);
            $dexuat = new DeXuat;
            $dexuat->ten = $dexuatold['ten'];
            $dexuat->content = $value[10];
            $dexuat->donvi = $dexuatold['donvi'];
            $dexuat->giamgia = $dexuatold['giamgia'];
            $dexuat->money = $dexuatold['money'];
            $dexuat->so_luong = $dexuatold['so_luong'];
            $dexuat->thanh_tien = $value[9];
            $dexuat->soluong_thuc = $value[7];
            $dexuat->tien_thuc = $value[8];
            $dexuat->money_thucte = $value[9];
            $dexuat->id_chiphi = $idcpnew;
            $dexuat->save();
        }
        return response()->json([
            'status' => true,
            'message' => 'Thêm Thành Công'
        ], 200);
    }

    public function timeline($id)
    {
        $timeline = TimeLine::where('id_cp',$id)->get();
        foreach ($timeline as $v)
        {

            echo '<ul class="timeline"><li class="time-label"><span class="bg-red">'.$v->created_at.'</span></li><li><i class="fa fa-envelope bg-blue"></i><div class="timeline-item"><span class="time"><i class="fa fa-clock-o"></i> 12:05</span><h3 class="timeline-header"><a href="#">Support Team</a> ...</h3></div></li></ul>';
            // echo "<option value='".$v->version."'> Version ".$v->version."</option>";
        }
    }
}
