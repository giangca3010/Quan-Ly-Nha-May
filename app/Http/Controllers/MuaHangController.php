<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\DinhMuc;
use App\Target;
use App\Kho;
use App\Nhap;
use App\Xuat;
use App\DealineKho;
use App\Exports\KhoExport;
use Maatwebsite\Excel\Facades\Excel;
use Importer;
use Input;

class MuaHangController extends Controller
{
	public function index(Request $r)
    {
    	$name = 'Kế Hoạch Mua Hàng';
        $action = '';
        $now = Carbon::now('Asia/Ho_Chi_Minh');
		$weekStartDate = date("d-m-Y", strtotime('monday this week'));
		$weekEndDate = date("d-m-Y", strtotime('sunday this week'));
		$weeks = collect($this->dateRange($weekStartDate, $weekEndDate));
		$items = array();
		$kho = Kho::rightjoin('nguyen_vat_lieu', 'kho.id_nvl', '=', 'nguyen_vat_lieu.id_nvl')->rightjoin('dealine_kho', 'kho.id_nvl', '=', 'dealine_kho.id_nvl')->get();
		// for ($i=0; $i < count($kho) ; $i++) { 
		// 	for ($j=0; $j <= count($weeks) ; $j++) { 
		// 		$items[$i][$j] = 0;
		// 	}
		// }
		foreach ($kho as $key => $value) {
			$items[$key]['name'] = $value['name']; 
			$items[$key]['id'] = $value['id_nvl']; 
			$items[$key]['soluong'] = $value['soluong']; 
			$items[$key]['date'] = $value['dealine_date']; 
			$dinhmuc = Target::where('start','<=',$now->toDateString())->where('end','>=',$now->toDateString())->where('id_nvl',$value['id_nvl'])->first();
			if (empty($dinhmuc)) {
				$items[$key]['songay'] = 'chưa có định mức tiêu thụ'; 
				$items[$key]['ngaynhapkho'] = 'nhập định mức tiêu thụ'; 
			}else{
				$countt = count(collect($this->dateRange($now->toDateString(), $dinhmuc['end'])));
				$number_nhapkho = $value['soluong'] - $dinhmuc['dm_tieuthu'] * $dinhmuc['dm_tktt'];
				$check = $number_nhapkho - $countt * $dinhmuc['dm_tieuthu'];
				if ($value['soluong'] != 0) {
					if ($check <= 0) {
						//tuần 1
						$number_cham_tktt = floor( $number_nhapkho / $dinhmuc['dm_tieuthu']);
					}else{
						if ($dinhmuc['t'] == 4) {
							$dinhmucplus = Target::where('p',$dinhmuc['p'] + 1)->where('t', 1)->where('id_nvl',$value['id_nvl'])->first();
						}else{
							$dinhmucplus = Target::where('p',$dinhmuc['p'])->where('t',$dinhmuc['t'] + 1)->where('id_nvl',$value['id_nvl'])->first();
						}
						$check_t2 = floor($check / $dinhmucplus['dm_tieuthu']);

						if ($check_t2 > 7) {
							if ($dinhmucplus['t'] == 4) {
								$dinhmucplus1 = Target::where('p',$dinhmucplus['p'] + 1)->where('t', 1)->where('id_nvl',$value['id_nvl'])->first();
							}else{
								$dinhmucplus1 = Target::where('p',$dinhmucplus['p'])->where('t',$dinhmucplus['t'] + 1)->where('id_nvl',$value['id_nvl'])->first();
							}
							$sl_conlai3 = $value['soluong'] - ($dinhmucplus['dm_tieuthu'] * 7 + $dinhmuc['dm_tieuthu'] * $countt);
							$sl_t3 = $sl_conlai3 - $dinhmucplus1['dm_tieuthu'] * $dinhmucplus1['dm_tktt'];
							if ($sl_t3 < 0) {
								$check_t3 = 0;
							}else{
								$check_t3 = floor($sl_t3 / $dinhmucplus1['dm_tieuthu']);
							}

							if ($check_t3 > 7) {
								if ($dinhmucplus1['t'] == 4) {
									$dinhmucplus2 = Target::where('p',$dinhmucplus1['p'] + 1)->where('t', 1)->where('id_nvl',$value['id_nvl'])->first();
								}else{
									$dinhmucplus2 = Target::where('p',$dinhmucplus1['p'])->where('t',$dinhmucplus1['t'] + 1)->where('id_nvl',$value['id_nvl'])->first();
								}
								$sl_conlai4 = $value['soluong'] - ($dinhmucplus1['dm_tieuthu'] * 7 + $dinhmucplus['dm_tieuthu'] * 7 + $dinhmuc['dm_tieuthu'] * $countt);
								$sl_t4 = $sl_conlai4 - $dinhmucplus2['dm_tieuthu'] * $dinhmucplus2['dm_tktt'];
								if ($sl_t4 < 0) {
									$check_t4 = 0;
								}else{
									$check_t4 = floor($sl_t4 / $dinhmucplus2['dm_tieuthu']);
								}

								if ($check_t4 > 7) {
									if ($dinhmucplus2['t'] == 4) {
										$dinhmucplus3 = Target::where('p',$dinhmucplus2['p'] + 1)->where('t', 1)->where('id_nvl',$value['id_nvl'])->first();
									}else{
										$dinhmucplus3 = Target::where('p',$dinhmucplus2['p'])->where('t',$dinhmucplus2['t'] + 1)->where('id_nvl',$value['id_nvl'])->first();
									}
									$sl_conlai5 = $value['soluong'] - ($dinhmucplus2['dm_tieuthu'] * 7 + $dinhmucplus1['dm_tieuthu'] * 7 + $dinhmucplus['dm_tieuthu'] * 7 + $dinhmuc['dm_tieuthu'] * $countt);
									$sl_t5 = $sl_conlai5 - $dinhmucplus3['dm_tieuthu'] * $dinhmucplus3['dm_tktt'];
									if ($sl_t5 < 0) {
										$check_t4 = 0;
									}else{
										$check_t4 = floor($sl_t5 / $dinhmucplus3['dm_tieuthu']);
									}
									//tuần 5
									$number_cham_tktt = $check_t4 + $countt + 7 + 7 + 7;
								}else{
									//tuần 4
									$number_cham_tktt = $check_t4 + $countt + 7 + 7;
								}

							}else{
								//tuần 3
								$number_cham_tktt = $check_t3 + $countt + 7;
							}

						}else{
							//tuần 2
							$sl_conlai2 = $value['soluong'] - ($dinhmuc['dm_tieuthu'] * $countt);
							$sl_t2 = $sl_conlai2 - $dinhmucplus['dm_tieuthu'] * $dinhmucplus['dm_tktt'];
							if ($sl_t2 < 0) {
								$sn_t2 = 0;
							}else{
								$sn_t2 = floor($sl_t2 / $dinhmucplus['dm_tieuthu']);
							}
							$number_cham_tktt = $sn_t2 + $countt;
						}
					}
					$date_cham_tktt = date('d-m-Y',strtotime($now->toDateString() . " +".$number_cham_tktt." day")); // tính đến ngày nhập kho
					$items[$key]['songay'] = $number_cham_tktt; 
					$items[$key]['ngaynhapkho'] = $date_cham_tktt; 

				}else{
					$items[$key]['songay'] = 0; 
					$items[$key]['ngaynhapkho'] = 0; 
				}
			}
		}
		// dd($items);

		// dd($weekStartDate,$weekEndDate);
        return view('kho.kehoachmua',compact('name','action','weeks','items'));
    }

    function dateRange ($first, $last, $step = '+1 day', $format = 'd-m-Y'){
		$dates = array();
		$current = strtotime( $first );
		$last = strtotime( $last );
		while( $current <= $last ) {

			$dates[] = date( $format, $current );
			$current = strtotime( $step, $current );
		}
		return $dates;
	}

	public function showitems(Request $r)
    {
    	$now = Carbon::now('Asia/Ho_Chi_Minh');
		$weekStartDate = $r->start;
		$weekEndDate = $r->end;
		$weeks = collect($this->dateRange($weekStartDate, $weekEndDate));
		$items = array();
		$kho = Kho::all();
		for ($i=0; $i < count($kho) ; $i++) { 
			for ($j=0; $j <= count($weeks) ; $j++) { 
				$items[$i][$j] = 0;
			}
		}
		foreach ($kho as $key => $value) {
			$dinhmuc = DinhMuc::where('start_p','<',$now->toDateString())->where('end_p','>',$now->toDateString())->where('code',$value['code'])->first();
			$countt = count(collect($this->dateRange($now->toDateString(), $dinhmuc['end_p'])));
			$number_nhapkho = $value['soluong'] - $dinhmuc['dm_khotoithieu'];
			$check = $number_nhapkho - $countt * $dinhmuc['dm_tieuthu'];
			if ($check <= 0) {
				$number_cham_tktt = floor( $number_nhapkho / $dinhmuc['dm_tieuthu']) - 1;
			}else{
				$dinhmucplus = DinhMuc::where('p',$dinhmuc['p'] + 1)->where('code',$value['code'])->first();
				$number_cham_tktt = floor($check / $dinhmucplus['dm_tieuthu']) + $countt - 1;
			}
			$dm = $number_cham_tktt-$dinhmuc['dm_ngaymua'];
			$date_cham_tktt = date('d-m-Y',strtotime($now->toDateString() . " +".$number_cham_tktt." day")); // tính đến ngày nhập kho
			// $date_cham_tktt = date('d-m-Y',strtotime($now->toDateString() . " +".$dm." day")); // tính cả ngày mua
			$items[$key]['name'] = $value['item']; 
			$key_new = array_search($date_cham_tktt,$this->dateRange($weekStartDate, $weekEndDate));
			if ($key_new > 0) {
				$items[$key][$key_new+1] = $dinhmuc['dm_mua']; 
			}
		}
		
        foreach ($items as $v)
        {
            foreach($v as $k){
            	if($k > 0){
            		$info = 'label-danger';
            	}else {
            		$info = '';
            	}
            	$str[] = '<td class="sorting text-center '.$info.'" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" >'.$k.'</td>';
            }
        }
        $line = array_chunk($str, count($weeks) + 1);
        foreach ($line as $key => $value) {
        	$cover[] = '<tr role="row" class="odd">'.implode('', $value).'</tr>';
        }
        foreach ($cover as $key => $value) {
        	echo $value;
        }
    }

    public function showdates(Request $r)
    {
		$weekStartDate = $r->start;
		$weekEndDate = $r->end;
		$weeks = collect($this->dateRange($weekStartDate, $weekEndDate));

        foreach ($weeks as $v)
        {
            echo '<th class="sorting text-center" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">'.$v.'</th>';
        }
    }

    public function export() 
    {
        return Excel::download(new KhoExport, 'Tồn Kho '.Carbon::now('Asia/Ho_Chi_Minh')->toDateString().'.xlsx');
    }

    public function importkho(Request $request)
    {
        if( Input::file('fileInput') ) {
            $filepath = Input::file('fileInput')->getRealPath();
        } else {
            return back()->with('errors', 'Chưa có file');
        }
        // dd(Carbon::now('Asia/Ho_Chi_Minh')->toDateString());
        Kho::truncate();
        $excel = Importer::make('Excel');
        $excel->load($filepath);
        $collection = $excel->getCollection();
        unset($collection[0]);
        foreach ($collection as $key => $value) {
        	$dealine = DealineKho::find($value[0]);
        	if($dealine['dealine_date'] == null){
        		if ($value[4] == 0) {
        			$dealine->dealine_date = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        		}
        	}else{
        		if ($value[3] < $value[4]) {
        			$dealine->dealine_date = null;
        		}
        	}
			$dealine->save();

			$kho = new Kho;
			$kho->id_nvl = $value[0];
			$kho->soluong = $value[4];
			$kho->save();

        }
        return back()->with('success', 'UpFile Thành Công');
    }

    public function showtarget(Request $r)
    {
    	$target = Target::where('id_nvl',$r->id)->get();
    	return $target;
    }
}
