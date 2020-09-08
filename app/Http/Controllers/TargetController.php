<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\NguyenVatLieu;
use App\Target;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TargetController extends Controller
{
    public function index(Request $r)
    {
        $name = 'Tiêu Thụ Thực Tế';
        $action = 'Danh Sách';
        $p = $r->p;
        $calendar = Calendar::where('p',$p)->where('z',14)->first();
        $nguyenlieu = NguyenVatLieu::all();

        $target = $nguyenlieu->map(function($target) use ($p,$calendar){
        	$dm = Target::where('id_nvl',$target->id_nvl)->where('p',$p)->get(); 
        	return (object)[
        		"id_nvl" => $target->id_nvl,
		        "name" => $target->name,
		        "code" => $target->code,
		        "donvi" => $target->don_vi,
                'count' => (int)$dm->sum('dm_tieuthu') * 7,
                'p' => (int)$p,
		        'target' => $dm->map(function($t) {return (object)[
                        "id_nvl" => $t->id_nvl,
                        "dm_tieuthu" => (int)$t->dm_tieuthu,
                        "p" => $t->p,
                        "t" => $t->t,
                        "start" => $t->start,
                        "end" => $t->end,
                        "status" => $this->block($t->start,$t->end)
                    ];
                })->toArray(),
		    ];
        })->toArray();
        $t1 = $calendar['t1'];
        $t2 = $calendar['t2'];
        $t3 = $calendar['t3'];
        $t4 = $calendar['t4'];
        // dd($target);
        return view('admin.target.index',compact('name','action','calendar','target','t1','t2','t3','t4'));

    }

    function block($start,$end)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        if (strtotime($now->toDateString()) > strtotime($end)) {
            return 1;
        }else{
            return 0;
        }
    }

    public function add(Request $r)
    {
    	// dd($r->all());
        Target::where('p',$r->p)->where('id_nvl',$r->id_nvl)->delete();
        $target = [
            [
                't' => 1,
                'start' => $r->date1,
                'end' => date('Y-m-d',strtotime($r->date1 . " +6 day")),
                'dm_tieuthu' => $r->t1,
            ],
            [
                't' => 2,
                'start' => $r->date2,
                'end' => date('Y-m-d',strtotime($r->date2 . " +6 day")),
                'dm_tieuthu' => $r->t2,
            ],
            [
                't' => 3,
                'start' => $r->date3,
                'end' => date('Y-m-d',strtotime($r->date3 . " +6 day")),
                'dm_tieuthu' => $r->t3,
            ],
            [
                't' => 4,
                'start' => $r->date4,
                'end' => date('Y-m-d',strtotime($r->date4 . " +6 day")),
                'dm_tieuthu' => $r->t4,
            ],
        ];
        foreach ($target as $key => $value) {
            $nguyenlieu = NguyenVatLieu::where('id_nvl',$r->id_nvl)->first();
            $new = new Target;
            $new->id_nvl = $r->id_nvl;
            $new->p = $r->p;
            $new->start = $value['start'];
            $new->end = $value['end'];
            $new->t = $value['t'];
            $new->dm_tieuthu = $value['dm_tieuthu'];
            $new->dm_mua = $nguyenlieu['dm_mua_c'];
            $new->dm_tktt = $nguyenlieu['dm_tktt_c'];
            $new->save();
        }
        return back()->with('success', 'UpFile Thành Công');
    }
}
