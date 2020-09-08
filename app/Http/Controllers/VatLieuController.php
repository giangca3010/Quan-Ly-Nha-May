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

class VatLieuController extends Controller
{
    public function index()
    {
    	$name = 'Dòng Tiền Nguyên Vật Liệu';
	    $action = 'Danh Sách';
        $user_id = \Auth::user()->id;
        if($user_id == 1){
    	    $chiphi = ChiPhi::where('id_phanloai',1)->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
        }elseif($user_id == 3){
            $chiphi = ChiPhi::where('id_phanloai',1)->where('status_duyet',2)->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
        }elseif($user_id == 47 or $user_id == 48 or $user_id == 49){
            $chiphi = ChiPhi::where('id_phanloai',1)->where('status_duyet',1)->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
        }else{
            $chiphi = ChiPhi::where('id_phanloai',1)->where('user_create',$user_id)->orwhere('user_dx',$user_id)->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
        }
		$loaichiphi = LoaiChiPhi::where('id',1)->get();
		$nhanvien = User::get();
        $itemkho = ItemKho::get();
        $role = Role::where('id','>',5)->get();
        $bank = Bank::all();
        $all = ChiPhi::All();
        $list = [];$get = [];
        foreach ($all as $key => $value) {
            if ($value['total'] > $value['tam_ung']) {
                $list[] = $value['stt'];
            }
        }
        if(count($list) > 0){
            foreach ($list as $v) {
                $loc = ChiPhi::where('id_phanloai',1)->where('stt',$v)->where('type','>',0)->where('user_create',\Auth::user()->id)->orwhere('user_dx',\Auth::user()->id)->orderBy('id_cp','desc')->first();
                if($loc['con_lai'] > 0 ){
                    $get[] = $loc['id_cp'];
                }
            }
        }
        if(count($get) > 0){
            $tamung = ChiPhi::whereIn('id_cp',$get)->get();
        }else{
            $tamung = array();
        }
	    return view('admin.chiphi.vatlieu',compact('name','action','chiphi','loaichiphi','nhanvien','itemkho','role','bank','tamung'));
    }

    public function add(Request $r)
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $time = $dt->getTimestamp();
    	$chiphi = new ChiPhi;
    	$chiphi->user_create = \Auth::user()->id;
    	$chiphi->name_dx = $r->name;
    	$chiphi->user_dx = $r->nhanvien;
    	$chiphi->status = $r->status;
    	$chiphi->id_phanloai = $r->loaichiphi;
    	$chiphi->total =$r->total;
        $chiphi->total_thuc =$r->total;
        $chiphi->chuy = $r->chuy;
        $chiphi->tam_ung = $r->tamung;
        $chiphi->con_lai = (int)$r->total - (int)$r->tamung;
        $chiphi->stt = $time;
        $chiphi->role_id = $r->role_dx;
        $chiphi->date_money = $r->date_money == null ? null : date('Y-m-d h:i:s', strtotime($r->date_money));
        $chiphi->date_need = $r->date_need == null ? null : date('Y-m-d h:i:s', strtotime($r->date_need));
        if ($r->chuy) {
            $chiphi->type = 0;
        }
    	$chiphi->save();
        $line = array_chunk(array_values($r->line), 8);
    	foreach ($line as $key => $value) {
	    	$dexuat = new DeXuat;
    		$dexuat->ten = $value[0];
    		$dexuat->content = $value[6];
            $dexuat->donvi = $value[2];
            $dexuat->giamgia = $value[3];
    		$dexuat->money = $value[4];
    		$dexuat->so_luong = $value[1];
    		$dexuat->thanh_tien = $value[5];
            $dexuat->money_thucte = $value[5];
            $dexuat->soluong_thuc = $value[1];
            $dexuat->tien_thuc = $value[4];
    		$dexuat->id_chiphi = ChiPhi::select('id_cp')->latest()->first()->id_cp;
	    	$dexuat->save();
    	}
    	return response()->json([
            'status' => true,
            'message' => 'Thêm Thành Công'
        ], 200);
    }

    public function destroy($id)
	{
		ChiPhi::where('id_cp',$id)->delete();
		\DB::table('line_dexuat')->where('id_chiphi',$id)->delete();
		return redirect('chiphi');
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

	public function media(Request $r)
	{
		if ($r->file != null) {
            foreach($r->file as $file) {
                if (is_file($file)) {
                    $new_name = rand().'.'.$file->getClientOriginalExtension();
                    Storage::disk('public_uploads')->putFileAs('chiphi', $file, $new_name);
                    $media = new MediaTaiLieu;
                    $media->id_ma = $r->id;
                    $media->roles = 5;
                    $media->link = '/storage/chiphi/'.$new_name;
                    $media->save();
                }
            }
            $image = MediaTaiLieu::where('roles',5)->where('id_ma',$r->id)->get();
            return response()->json([
	            'image' => $image,
	        ], 200);
        }

	}

    public function deletemedia($id)
    {
        MediaTaiLieu::where('roles',5)->where('id',$id)->delete();
        return redirect('chiphi');
    }

    public function showComment(Request $r)
    {
        $comment = CommentCP::where('id_chiphi',$r->id)->leftJoin('users', 'comment_dexuat.user_id', '=', 'users.id')->join('info_user', 'comment_dexuat.user_id', '=', 'info_user.user_id')->get();
        return response()->json([
            'comment' => $comment,
        ], 200);
    }

    public function addComment(Request $r)
    {
        $comment = new CommentCP;
        $comment->id_chiphi = $r->id;
        $comment->user_id = \Auth::user()->id;
        $comment->content = $r->content;
        $comment->save();

        $info = InforUser::where('user_id',\Auth::user()->id)->first();
        return response()->json([
            'info' => $info,
            'user' => \Auth::user()->name,
            'content' => $r->content,
        ], 200);
    }

    public function duyetChiPhi(Request $r)
    {
        $ChiPhi = ChiPhi::find($r->id);
        $ChiPhi->status_duyet = $r->loai;
        $ChiPhi->save();
        return response()->json([
            'status' => true,
            'message' => 'Sửa Thành Công'
        ], 200);
    }

    public function khongduyetChiPhi(Request $r)
    {
        $ChiPhi = ChiPhi::find($r->id);
        $ChiPhi->status_duyet = 4;
        $ChiPhi->save();
        return response()->json([
            'status' => true,
            'message' => 'Sửa Thành Công'
        ], 200);
    }

    public function filterStatus(Request $r)
    {
        $user_id = \Auth::user()->id;
        if($user_id == 1 or $user_id == 3 or $user_id == 47 or $user_id == 48 or $user_id == 49){
            if ($r->status_duyet == 100) {
                $chiphi = ChiPhi::leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
            }
            if ($r->status_duyet == 0) {
                $chiphi = ChiPhi::where('status_duyet',0)->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
            }
            if ($r->status_duyet == 1) {
                $chiphi = ChiPhi::where('status_duyet',1)->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
            }
            if ($r->status_duyet == 2) {
                $chiphi = ChiPhi::where('status_duyet',2)->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
            }
            if ($r->status_duyet == 3) {
                $chiphi = ChiPhi::where('status_duyet',3)->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
            }
            if ($r->status_duyet == 4) {
                $chiphi = ChiPhi::where('status_duyet',4)->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
            }
        }else{
            if ($r->status_duyet == 100) {
                $chiphi = ChiPhi::where('user_create',$user_id)->orwhere('user_dx',$user_id)->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
            }
            if ($r->status_duyet == 0) {
                $chiphi = ChiPhi::where([
                    ['status_duyet',0],
                    ['user_create',$user_id],
                ])->orwhere([
                    ['status_duyet',0],
                    ['user_dx',$user_id],
                ])->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
            }
            if ($r->status_duyet == 1) {
                $chiphi = ChiPhi::where([
                    ['status_duyet',1],
                    ['user_create',$user_id],
                ])->orwhere([
                    ['status_duyet',1],
                    ['user_dx',$user_id],
                ])->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
            }
            if ($r->status_duyet == 2) {
                $chiphi = ChiPhi::where([
                    ['status_duyet',2],
                    ['user_create',$user_id],
                ])->orwhere([
                    ['status_duyet',2],
                    ['user_dx',$user_id],
                ])->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
            }
            if ($r->status_duyet == 3) {
                $chiphi = ChiPhi::where([
                    ['status_duyet',3],
                    ['user_create',$user_id],
                ])->orwhere([
                    ['status_duyet',3],
                    ['user_dx',$user_id],
                ])->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
            }
            if ($r->status_duyet == 4) {
                $chiphi = ChiPhi::where([
                    ['status_duyet',4],
                    ['user_create',$user_id],
                ])->orwhere([
                    ['status_duyet',4],
                    ['user_dx',$user_id],
                ])->leftJoin('users', 'chi_phi.user_dx', '=', 'users.id')->leftJoin('loai_chi_phi', 'chi_phi.id_phanloai', '=', 'loai_chi_phi.id')->get();
            }
        }
        return response()->json([
            'chiphi' => $chiphi,
        ], 200);
    }

    public function sendchiphi($id)
    {
        $ChiPhi = ChiPhi::find($id);
        $ChiPhi->status_duyet = 1;
        $ChiPhi->save();
        return redirect('chiphi');
    }

    public function edit(Request $r)
    {
        $line = array_chunk($r->line, 9);
        $chiphi = ChiPhi::find($r->id);
        $chiphi->name_dx = $r->name;
        $chiphi->user_dx = $r->nhanvien;
        $chiphi->status = $r->status;
        $chiphi->id_phanloai = $r->loaichiphi;
        $chiphi->total =$r->total;
        $chiphi->total_thuc =$r->total;
        $chiphi->chuy = $r->chuy;
        $chiphi->role_id = $r->role_dx;
        $chiphi->date_money = $r->date_money == null ? null : date('Y-m-d h:i:s', strtotime($r->date_money));
        $chiphi->date_need = $r->date_need == null ? null : date('Y-m-d h:i:s', strtotime($r->date_need));
        $chiphi->save();
        DeXuat::where('id_chiphi',$r->id)->delete();
        foreach ($line as $key => $value) {
            $dexuat = new DeXuat;
            $dexuat->ten = $value[1];
            $dexuat->so_luong = $value[2];
            $dexuat->donvi = $value[3];
            $dexuat->giamgia = $value[4];
            $dexuat->money = $value[5];
            $dexuat->thanh_tien = $value[6];
            $dexuat->money_thucte = $value[6];
            $dexuat->content = $value[7];
            $dexuat->id_chiphi = $r->id;
            $dexuat->save();
        }
        return response()->json([
            'status' => true,
            'message' => 'Thêm Thành Công'
        ], 200);
    }

    public function import(Request $request)
    {
        if( Input::file('fileInput') ) {
            $filepath = Input::file('fileInput')->getRealPath();
        } else {
            return back()->with('errors', 'Chưa có file');
        }
        $excel = Importer::make('Excel');
        $excel->load($filepath);
        $collection = $excel->getCollection();
        if ($collection->count() > 0) {
            foreach($collection->toArray() as $key => $data) {
                if ($key > 0) {
                    $dukien = new ItemKho;
                    $dukien->item = $data[1];
                    $dukien->group = $data[2];
                    $dukien->group_name = $data[3];
                    $dukien->item_description = $data[4];
                    $dukien->chitiet = $data[1].' - '.$data[4] ;
                    // $dukien = new Order;
                    // $dukien->so_number = trim($data[0]);
                    // $dukien->description = 'TC_'.trim($data[0]);
                    // $dukien->your_ref = trim($data[0]);
                    // $dukien->resource = 1;
                    // $dukien->ordered_by = 1;
                    // $dukien->deliver_to = 1;
                    // $dukien->invoice_to = 1;
                    // $dukien->warehouse = 'A_MN';
                    // $dukien->delivery_method = 'DB';
                    // $dukien->delivery_date = $data[4];
                    // $dukien->costcenter = $data[5];
                    // $dukien->user_id = 1;
                    // $dukien->start_date = $data[4];
                    // $dukien->pre_pay = $data[7];
                    // $dukien->status_id = 2;
                    // $dukien->amount = $data[8];
                    // $dukien->vat = 0;
                    // $dukien->fee_ld = 0;
                    // $dukien->fee_vc = 0;
                    // $dukien->qgg = 0;
                    // $dukien->subtotal = $data[8];
                    // $dukien->sdt = $data[3];
                    // $dukien->note = $data[1].' / '.$data[2];
                    $dukien->save();
                }
            }

            return back()->with('success', 'UpFile Thành Công');
        }

        /*if ($collection->count() > 0) {
            foreach($collection->toArray() as $data) {
                $dukien = new ItemKho;
                $dukien->item = $data[0];
                $dukien->group = $data[1];
                $dukien->group_name = $data[2];
                $dukien->item_description = $data[3];
                $dukien->save();
            }

            return back()->with('success', 'UpFile Thành Công');
        }*/
    }

    public function search(Request $request)
    {
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = ItemKho::where('item', 'LIKE', "%{$query}%")->orwhere('item_description', 'LIKE', "%{$query}%")->orwhere('chitiet', 'LIKE', "%{$query}%")->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach($data as $row)
            {
               $output .= '
               <li>'.$row->chitiet.'</li>
               ';
           }
           $output .= '</ul>';
           echo $output;
       }
    }

    public function duyethai(Request $request)
    {
        $line = array_chunk($request->line, 11);
        $chiphiold = ChiPhi::find($request->id);
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $time = $dt->getTimestamp();
        // dd($line);
        $chiphi = new ChiPhi;
        $chiphi->user_create = $chiphiold->user_create;
        $chiphi->name_dx = $chiphiold->name_dx;
        $chiphi->user_dx = $chiphiold->user_dx;
        $chiphi->status = $chiphiold->status;
        $chiphi->id_phanloai = $chiphiold->id_phanloai;
        $chiphi->total = $request->total_thuc;
        $chiphi->total_thuc = $request->total_thuc;
        $chiphi->chuy = $chiphiold->chuy;
        $chiphi->type = $request->id;
        $chiphi->tam_ung = $chiphiold->tamung;
        $chiphi->con_lai = $chiphiold->con_lai;
        $chiphi->stt = $time;
        $chiphi->status_duyet = 1;
        $chiphi->save();
        $chiphiold->status_duyet = 3;
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
            $dexuat->id_chiphi = ChiPhi::select('id_cp')->latest()->first()->id_cp;
            $dexuat->save();
        }
        return response()->json([
            'status' => true,
            'message' => 'Thêm Thành Công'
        ], 200);
    }

    public function addbank(Request $request)
    {
        $chiphi = ChiPhi::find($request->id);
        $chiphi->id_bank = $request->id_bank;
        $chiphi->status_duyet = 1;
        $chiphi->save();
        return response()->json([
            'status' => true,
            'message' => 'Thêm Thành Công'
        ], 200);
    }

    public function showtamung($id)
    {
        $chiphi = ChiPhi::find($id);
        return $chiphi['con_lai'];
    }

    public function addchiphitu(Request $request)
    {
        $chiphiold = ChiPhi::find($request->id);
        // dd($chiphiold);
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $time = $dt->getTimestamp();
        $chiphi = new ChiPhi;
        $chiphi->user_create = $chiphiold->user_create;
        $chiphi->name_dx = $chiphiold->name_dx;
        $chiphi->user_dx = $chiphiold->user_dx;
        $chiphi->status = $chiphiold->status;
        $chiphi->id_phanloai = $chiphiold->id_phanloai;
        $chiphi->total = $chiphiold->total;
        $chiphi->total_thuc = $chiphiold->total_thuc;
        $chiphi->chuy = $chiphiold->chuy;
        $chiphi->type = $chiphiold->type;
        $chiphi->tam_ung = $request->tam_ung;
        $chiphi->con_lai = $chiphiold->con_lai - $request->tam_ung;
        $chiphi->date_money = $chiphiold->date_money;
        $chiphi->date_need = $chiphiold->date_need;
        $chiphi->stt = $time;
        $chiphi->role_id = $chiphiold->role_dx;
        $chiphi->status_duyet = 1;
        $chiphi->save();
        $line = DeXuat::where('id_chiphi',$request->id)->get();
        foreach ($line as $key => $value) {
            $dexuat = new DeXuat;
            $dexuat->ten = $value['ten'];
            $dexuat->content = $value['content'];
            $dexuat->donvi = $value['donvi'];
            $dexuat->giamgia = $value['giamgia'];
            $dexuat->money = $value['money'];
            $dexuat->so_luong = $value['so_luong'];
            $dexuat->thanh_tien = $value['thanh_tien'];
            $dexuat->money_thucte = $value['money_thucte'];
            $dexuat->soluong_thuc = $value['soluong_thuc'];
            $dexuat->tien_thuc = $value['tien_thuc'];
            $dexuat->id_chiphi = ChiPhi::select('id_cp')->latest()->first()->id_cp;
            $dexuat->save();
        }
        return response()->json([
            'status' => true,
            'message' => 'Thêm Thành Công'
        ], 200);
    }

    public function showline($id)
    {
    	$dexuat = DeXuat::where('id_chiphi',$id)->get();
    	$nhacungcap = NhaCungCap::all();
    	foreach ($dexuat as $v)
        {
    		echo "<div><input type='hidden' value='".$v->id."'><input type='text' disabled value='".$v->ten."'><select class='ncc'></select></div>";
        }
    }

    public function showncc($id)
    {
    	$nhacungcap = NhaCungCap::all();
    	foreach ($nhacungcap as  $value) {
    		echo "<option value='".$value->id_ncc."'> ".$value->name_cc."</option>";
    	}
    }
}
