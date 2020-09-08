<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Boom;
use App\CongDoan;

class BoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = 'Boom';
        $action = 'Danh Sách';
        $boom = Boom::where('parent',0)->where('menu',$request->all())->get();
        $merge = $boom->map(function($value,$key)  {
            $value->parentSons =  $this->getsons($value->id);
            return $value;
        });
        $merge = $merge->sortByDesc('id');
        return view('admin.boom',compact('name','action','merge'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $name = 'Boom';
    //     $action = 'Action';
    //     $lenh = Boom::where('parent',0)->get();

    //     $booms = new Boom();
    //     $menus = $booms->getall();

    //     return view('admin.action-boom',compact('name','action','lenh','menus'));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $boom = new Boom();
        $boom->name = request()->input("name");
        $boom->parent = (request()->input("parent") == null) ? 0 : request()->input("parent");
        $boom->dinhmuc = request()->input("dinhmuc");
        if ($request->parent != 0) {
            $boom->depth = 1;
        }
        if ($request->status == 'true') {
            $checkCDC = Boom::where('parent',request()->input("parent"))->where('status',1)->get();
            if($checkCDC->isEmpty()) {
                $boom->status = 1;
            }else {
                return response()->json([
                    'status' => false,
                    'message' => 'Lỗi! Đã có công đoạn chính'
                ], 200);
            }
        }
        if ($request->opposites == 'true') {
            $boom->opposites = 1;
        }
        $boom->tre = request()->input("tre");
        $boom->sort = Boom::getNextSortRoot(request()->input("menu_id"));
        $boom->version = 1;
        $boom->menu = request()->input("menu_id");
        $boom->save();
        $tong = Boom::where('id',$request->parent)->first();
        $tong_dm = ($tong->dinhmuc == 0) ? '00:00' : $tong->dinhmuc;
        $hour_tong = explode(':', $tong_dm);
        $hour_moi = explode(':', $request->dinhmuc);
        $hour = $hour_tong[0] + $hour_moi[0];
        $min = $hour_tong[1] + $hour_moi[1];
        $tong->dinhmuc = $hour.':'.$min;
        $tong->save();
        return response()->json([
                'status' => true,
                'message' => 'Thêm Thành Công'
            ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $r)
    {
        $name = 'Boom';
        $action = 'Sửa';
        $parent = Boom::where('id',$r->id)->get();
        $sons = Boom::where("parent", $r->id)->orderBy("sort", "asc")->get();
        $menus = $parent->merge($sons)->sortBy('sort');

        $congdoan = CongDoan::where('id_menu',$r->menu_id)->get();
        $lenh = Boom::where('parent',0)->get();
        $id = $r->id;
        $menu_id = $r->menu_id;
        return view('admin.edit-boom',compact('name','action','lenh','menus','id','congdoan','menu_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // dd($request->all());
        if (is_array(request()->input("arraydata"))) {
            foreach (request()->input("arraydata") as $value) {

                $boom = Boom::find($value["id"]);
                $boom->parent = $value["parent"];
                $boom->sort = $value["sort"];
                $boom->depth = $value["depth"];
                $boom->save();
            }
        }
        echo json_encode(array("resp" => 'Chuyển Thành Công'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $arraydata = request()->input("arraydata");
        if (is_array($arraydata)) {
            foreach ($arraydata as $value) {
                $Boom = Boom::find($value['id']);
                $Boom->name = $value['name'];
                if(isset($value['tre']) and isset($value['dinhmuc'])) {
                    $Boom->tre = $value['tre'];
                    $Boom->dinhmuc = $value['dinhmuc'];
                    $tong = explode(':', $value['dinhmuc']);
                    $hour[] = $tong[0];
                    $min[] = $tong[1];
                }
                if ($value['opposites'] == 'true') {
                    $Boom->opposites = 1;
                }
                $Boom->save();
            }
        } else {
            $Boom = Boom::find(request()->input("id"));
            $Boom->name = request()->input("name");
            $Boom->tre = request()->input("tre");
            if ($request->opposites == 'true') {
                $Boom->opposites = 1;
            }
            $Boom->dinhmuc = request()->input("dinhmuc");
            $Boom->save();
        }
        // dd( array_sum($min) );
        $tong_dm = Boom::where('id',$arraydata[0]['id'])->first();
        $tong_dm->dinhmuc = array_sum($hour).':'.array_sum($min);
        $tong_dm->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Boom::where('id',$request->id)->delete();
        Boom::where('parent',$request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa Thành Công'
        ], 200);
    }

    public function getsons($id)
    {
        $Boom = Boom::where("parent", $id)->orderBy('sort', 'asc')->get();
        $boom = $Boom->groupBy(function($val) {
            return $val->version;
        });
        return $Boom;
    }

    public function addLenh(Request $request)
    {
        $boom = new Boom();
        $boom->name = request()->input("name");
        $boom->parent = 0;
        $boom->dinhmuc = '00:00';
        $boom->tre = '00:00';
        $boom->depth = 0;
        $boom->status = 0;
        $boom->menu = (integer)  $request->menu_id;
        $boom->version = 1;
        $boom->sort = 0;
        $boom->save();
        return response()->json([
                'status' => true,
                'message' => 'Thêm Thành Công'
            ], 200);
    }

    public function addVersion(Request $request)
    {
        $tre = [
            $request->tre1,
            $request->tre2,
            $request->tre3,
            $request->tre4,
            $request->tre5,
            $request->tre6,
            $request->tre7,
        ];
        $dinhmuc = [
            $request->dinhmuc1,
            $request->dinhmuc2,
            $request->dinhmuc3,
            $request->dinhmuc4,
            $request->dinhmuc5,
            $request->dinhmuc6,
            $request->dinhmuc7,
        ];
        $arraydata = request()->all();
        $Boom = Boom::where('parent',$request['id'])->orderBy('sort', 'asc')->get();
        $Parent = Boom::where('id',$request['id'])->first();
        $version = Boom::where('name',$request['itemname'])->max('version');
        
        foreach ($tre as $key => $value) {
            if ($value != null) {
                $t = explode(':',$value);
                $hour_t[] = $t[0];
                $min_t[] = $t[1];
            }
        }

        foreach ($dinhmuc as $key => $value) {
            if ($value != null) {
                $t = explode(':',$value);
                $hour_dm[] = $t[0];
                $min_dm[] = $t[1];
            }
        }

        $addVersion = new Boom;
        $addVersion->name = $Parent->name;
        $addVersion->menu = $request->menu_id;
        $addVersion->parent = 0;
        $addVersion->depth = 0;
        $addVersion->version = $version + 1;
        $addVersion->tre = array_sum($hour_t).':'.array_sum($min_t);
        $addVersion->dinhmuc = array_sum($hour_dm).':'.array_sum($min_dm);
        $addVersion->save();

        $id = Boom::orderBy('id', 'desc')->first();
        $i = $request->count - 1;

        foreach ($Boom as $value) {
            $addVersion = new Boom;
            $addVersion->name = $value->name;
            $addVersion->menu = $request->menu_id;
            $addVersion->parent = $id->id;
            $addVersion->version = $version + 1;
            $addVersion->status = $value->status;
            $addVersion->depth = 1;
            $addVersion->tre = $tre[$i];
            $addVersion->dinhmuc = $dinhmuc[$i];
            $addVersion->sort = Boom::getNextSortRoot($request->menu_id);
            $addVersion->save();
            $i--;
        }
        return response()->json([
                'status' => true,
                'message' => 'Thêm Version Thành Công'
            ], 200);

    }
}
