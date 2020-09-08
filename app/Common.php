<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Cache;
use Carbon\Carbon;
use App\QuyNgayNew;
use App\CongDoan;
use DateTime;
use DatePeriod;
use DateInterval;
use App\MenuItems;
use App\Lenh;

class Common{

    public static function time_work($start,$end){
        date_default_timezone_set('UTC');
        return  strtotime($end) - strtotime($start);
    }

    public static function targetS($dinhmuc,$time,$date,$label)
    {
    	$dt = Carbon::now('Asia/Ho_Chi_Minh');
		$stt = CongDoan::where('name',$label)->first();
		// dd($stt);
		$getam = QuyNgayNew::where('date',$date)->where('name_id',$stt->id)->first();
		$checkam = strtotime($getam->end_am) - strtotime($time); 
    	if ($dt->toDateString() == $date) {
    		$nowam = strtotime($getam->end_am) - strtotime($dt->toTimeString());
    		$nowpm = strtotime($getam->start_pm) - strtotime($dt->toTimeString());
    		$nowpmoff = strtotime($getam->end_pm) - strtotime($dt->toTimeString());

    		$th1 = strtotime($dt->toTimeString()) - strtotime($time); 
    		$th2 = strtotime($getam->end_am) - strtotime($time); 
    		$th3 = strtotime($dt->toTimeString()) - strtotime($time) - ( strtotime($getam->start_pm) - strtotime($getam->end_am) );
    		$th4 = strtotime($getam->end_pm) - strtotime($time); 
    		$th5 = strtotime($getam->end_pm) - strtotime($getam->start_pm) + ( strtotime($getam->end_am) - strtotime($time) );
			date_default_timezone_set('UTC');
    		if($checkam > 0 and $nowam > 0 and $nowpmoff > 0) {
    			$thucte = explode(':', date('H:i',$th1));
    			$dm = explode(':',date('H:i',strtotime($dinhmuc)));
		    	$sbc = $thucte[0]*60 + $thucte[1];
		    	$sc = $dm[0]*60 + $dm[1];
		    	$div = number_format($sbc/$sc*100,0); // Đúng
		    	$target = [date('H:i',$th1),$div];
				return $target;
    		}
    		if($checkam > 0 and $nowam <= 0 and $nowpm > 0 and $nowpmoff > 0) {
    			$thucte = explode(':', date('H:i',$th2));
    			$dm = explode(':',date('H:i',strtotime($dinhmuc)));
		    	$sbc = $thucte[0]*60 + $thucte[1];
		    	$sc = $dm[0]*60 + $dm[1];
		    	$div = number_format($sbc/$sc*100,0); // Đúng
		    	$target = [date('H:i',$th2),$div];
				return $target;
    		}
    		if($checkam > 0 and $nowam <= 0 and $nowpm < 0 and $nowpmoff > 0) {
    			$thucte = explode(':', date('H:i',$th3));
    			$dm = explode(':',date('H:i',strtotime($dinhmuc)));
		    	$sbc = $thucte[0]*60 + $thucte[1];
		    	$sc = $dm[0]*60 + $dm[1];
		    	$div = number_format($sbc/$sc*100,0); // Đúng
		    	$target = [date('H:i',$th3),$div];
		    	return $target;
    		}
    		if($checkam < 0 and $nowam <= 0  and $nowpm <= 0 and $nowpmoff > 0) {
    			$thucte = explode(':', date('H:i',$th1));
    			$dm = explode(':',date('H:i',strtotime($dinhmuc)));
		    	$sbc = $thucte[0]*60 + $thucte[1];
		    	$sc = $dm[0]*60 + $dm[1];
		    	$div = number_format($sbc/$sc*100,0); // Đúng
		    	$target = [date('H:i',$th1),$div];
		    	return $target;
    		}
    		if ($checkam < 0 and $nowam <= 0 and $nowpm < 0 and $nowpmoff < 0) {
    			$thucte = explode(':', date('H:i',$th4));
    			$dm = explode(':',date('H:i',strtotime($dinhmuc)));
		    	$sbc = $thucte[0]*60 + $thucte[1];
		    	$sc = $dm[0]*60 + $dm[1];
		    	$div = number_format($sbc/$sc*100,0); // Đúng
		    	$target = [date('H:i',$th4),$div];
		    	return $target;
    		}
    		if($checkam > 0 and $nowam <= 0 and $nowpm < 0 and $nowpmoff < 0) {
    			$thucte = explode(':', date('H:i',$th5));
    			$dm = explode(':',date('H:i',strtotime($dinhmuc)));
		    	$sbc = $thucte[0]*60 + $thucte[1];
		    	$sc = $dm[0]*60 + $dm[1];
		    	$div = number_format($sbc/$sc*100,0); // Đúng
		    	$target = [date('H:i',$th5),$div];
		    	return $target;
    		}
    	}else {
    		$format = ' Y-m-d';
    		$start = $date;
    		$end = $dt->toDateString();
    		$array = array(); 
	        $interval = new DateInterval('P1D'); 
	        $realEnd = new DateTime($end); 
	        $realEnd->add($interval); 
	        $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
	        foreach($period as $date) {                  
	            $array[] = $date->format($format);  
	        } 
	        if(count($array) == 2) {
        		$date_end = QuyNgayNew::where('date',$dt->toDateString())->where('name_id',$stt->id)->first();
        		date_default_timezone_set('UTC');
        		$check_dem = strtotime($date_end->start_am) - strtotime($dt->toTimeString());
        		$time_now = ($check_dem > 0) ? '23:59' : $dt->toTimeString();
        		// $time_now = $dt->toTimeString();
        		$check = strtotime($date_end->end_am) - strtotime($time_now);
        		$checkpmoff = strtotime($date_end->end_pm) - strtotime($time_now);
        		$checkpm = strtotime($date_end->start_pm) - strtotime($time_now);
	        	if($checkam >= 0) {
	        		$start = strtotime($getam->end_am) - strtotime($time) + strtotime($getam->end_pm) - strtotime($getam->start_pm);
	        		if ($check >= 0 and $checkpm >= 0 and $checkpmoff >= 0) {
	        			$end = strtotime($time_now) - strtotime($date_end->start_am);
	        			$time_run = $start + $end;  
	        		}
	        		if ($check < 0 and $checkpm >= 0 and $checkpmoff >= 0){
	        			$end =  strtotime($date_end->end_am) -  strtotime($date_end->start_am) ;
	        			$time_run = $start + $end;  
	        		}
	        		if ($check < 0 and $checkpm < 0 and $checkpmoff < 0){
	        			$end = strtotime($date_end->end_pm) - strtotime($date_end->start_pm) + strtotime($date_end->end_am) - strtotime($date_end->start_am);
	        			$time_run = $start + $end;  
	        		}
	        		if ($check < 0 and $checkpm < 0 and $checkpmoff >= 0){
	        			$end = strtotime($time_now) - strtotime($date_end->start_pm) + strtotime($date_end->end_am) - strtotime($date_end->start_am);
	        			$time_run = $start + $end;  
	        		}
        			// $target = date('H:i',$time_run);
	        	}else {
	        		$start = strtotime($getam->end_pm) - strtotime($time);
	        		if ($check >= 0 and $checkpm >= 0 and $checkpmoff >= 0) {
	        			$end = strtotime($time_now) - strtotime($date_end->start_am);
	        			$time_run = $start + $end; 
	        		} 
	        		if ($check < 0 and $checkpm >= 0 and $checkpmoff >= 0){
	        			$end = strtotime($date_end->end_am) - strtotime($date_end->start_am);
	        			$time_run = $start + $end; 
	        		}
	        		if ($check < 0 and $checkpm < 0 and $checkpmoff < 0){
	        			$end = strtotime($date_end->end_pm) - strtotime($date_end->start_pm) + strtotime($date_end->end_am) - strtotime($date_end->start_am);
	        			$time_run = $start + $end;  
	        		}
	        		if ($check < 0 and $checkpm < 0 and $checkpmoff >= 0){
	        			$end = strtotime($time_now) - strtotime($date_end->start_pm) + strtotime($date_end->end_am) - strtotime($date_end->start_am);
	        			$time_run = $start + $end;  
	        		}
        			// $target = $time_run;
	        	}
	        	$thucte = explode(':', date('H:i',$time_run));
    			$dm = explode(':',date('H:i',strtotime($dinhmuc)));
		    	$sbc = $thucte[0]*60 + $thucte[1];
		    	$sc = $dm[0]*60 + $dm[1];
		    	$div = number_format($sbc/$sc*100,0); // Đúng
		    	$target = [date('H:i',$time_run),$div];
		    	return $target;
	        }
	        if(count($array) > 2) {
				$del_end = array_pop($array);
				$del_start = array_shift($array);
				$time_work = QuyNgayNew::whereIn('date',$array)->where('name_id',$stt->id)->get();
				foreach ($time_work as $key => $value) {
					$time_chinh = explode(':', $value->time_work);
					$hour[] = $time_chinh[0];
					$min[] = $time_chinh[1];
		      	}      	
				$total_hour = array_sum($hour); 
				$total_min = array_sum($min);

				$date_end = QuyNgayNew::where('date',$del_end)->where('name_id',$stt->id)->first();
        		date_default_timezone_set('UTC');
        		$check_dem = strtotime($date_end->start_am) - strtotime($dt->toTimeString());
        		$time_now = ($check_dem > 0) ? '23:59' : $dt->toTimeString();
        		$check = strtotime($date_end->end_am) - strtotime($time_now);
        		$checkpmoff = strtotime($date_end->end_pm) - strtotime($time_now);
        		$checkpm = strtotime($date_end->start_pm) - strtotime($time_now);
	        	if($checkam >= 0) {
	        		$start = strtotime($getam->end_am) - strtotime($time) + strtotime($getam->end_pm) - strtotime($getam->start_pm);
	        		if ($check >= 0 and $checkpm >= 0 and $checkpmoff >= 0) {
	        			$end = strtotime($time_now) - strtotime($date_end->start_am);
	        			$time_run = $start + $end;  
	        		}
	        		if ($check < 0 and $checkpm >= 0 and $checkpmoff >= 0){
	        			$end =  strtotime($date_end->end_am) -  strtotime($date_end->start_am) ;
	        			$time_run = $start + $end;  
	        		}
	        		if ($check < 0 and $checkpm < 0 and $checkpmoff < 0){
	        			$end = strtotime($date_end->end_pm) - strtotime($date_end->start_pm) + strtotime($date_end->end_am) - strtotime($date_end->start_am);
	        			$time_run = $start + $end;  
	        		}
	        		if ($check < 0 and $checkpm < 0 and $checkpmoff >= 0){
	        			$end = strtotime($time_now) - strtotime($date_end->start_pm) + strtotime($date_end->end_am) - strtotime($date_end->start_am);
	        			$time_run = $start + $end;  
	        		}
        			$sum_dc = date('H:i',$time_run);
        			$ex = explode(':', $sum_dc);
        			$total_h = $ex[0] + $total_hour;
        			$total_m = $ex[1] + $total_min;
        			$time_center = $total_h.':'.$total_m;

	        	}else {
	        		$start = strtotime($getam->end_pm) - strtotime($time);
	        		if ($check >= 0 and $checkpm >= 0 and $checkpmoff >= 0) {
	        			$end = strtotime($time_now) - strtotime($date_end->start_am);
	        			$time_run = $start + $end; 
	        		} 
	        		if ($check < 0 and $checkpm >= 0 and $checkpmoff >= 0){
	        			$end = strtotime($date_end->end_am) - strtotime($date_end->start_am);
	        			$time_run = $start + $end; 
	        		}
	        		if ($check < 0 and $checkpm < 0 and $checkpmoff < 0){
	        			$end = strtotime($date_end->end_pm) - strtotime($date_end->start_pm) + strtotime($date_end->end_am) - strtotime($date_end->start_am);
	        			$time_run = $start + $end;  
	        		}
	        		if ($check < 0 and $checkpm < 0 and $checkpmoff >= 0){
	        			$end = strtotime($time_now) - strtotime($date_end->start_pm) + strtotime($date_end->end_am) - strtotime($date_end->start_am);
	        			$time_run = $start + $end;  
	        		}
        			$sum_dc = date('H:i',$time_run);
        			$ex = explode(':', $sum_dc);
        			$total_h = $ex[0] + $total_hour;
        			$total_m = $ex[1] + $total_min;
        			$time_center = $total_h.':'.$total_m;

	        	}
	        	// return $time_center;
	        	// $thucte = explode(':', date('H:i',$time_center));
    			$dm = explode(':',date('H:i',strtotime($dinhmuc)));
		    	$sbc = $total_h*60 + $total_m;
		    	$sc = $dm[0]*60 + $dm[1];
		    	$div = number_format($sbc/$sc*100,0); // Đúng
		    	$target = [$time_center,$div];
		    	return $target;
	        }
	      
	        // return count($array); 
    		// print_r($array);
    	}
    }

    public static function targetF($dinhmuc,$times,$dates,$timef,$datef,$label)
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
			    	$div = number_format($sbc/$sc*100,0); // Đúng
			    	$target = [date('H:i',$th1),$div];
					return $target;
				}
				if($checkf < 0){
					$th2 = strtotime($timef) - strtotime($getam->start_pm) + strtotime($getam->end_am) - strtotime($times);
					$thucte = explode(':', date('H:i',$th2));
	    			$dm = explode(':',date('H:i',strtotime($dinhmuc)));
			    	$sbc = $thucte[0]*60 + $thucte[1];
			    	$sc = $dm[0]*60 + $dm[1];
			    	$div = number_format($sbc/$sc*100,0); // Đúng
			    	$target = [date('H:i',$th2),$div];
					return $target; //date('H:i',$th2);
				}
			}else {
				$th1 = strtotime($timef) - strtotime($times);
				$thucte = explode(':', date('H:i',$th1));
    			$dm = explode(':',date('H:i',strtotime($dinhmuc)));
		    	$sbc = $thucte[0]*60 + $thucte[1];
		    	$sc = $dm[0]*60 + $dm[1];
		    	$div = number_format($sbc/$sc*100,0); // Đúng
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
			    	$div = number_format($sbc/$sc*100,0); // Đúng
			    	$target = [date('H:i',$th1),$div];
					return $target;
				}
				if($checkf < 0){
					$th2 = strtotime($timef) - strtotime($getamf->start_pm) + strtotime($getamf->end_am) - strtotime($getamf->start_am) + strtotime($getams->end_pm) - strtotime($getams->start_pm) + strtotime($getams->end_am) - strtotime($times);
					$thucte = explode(':', date('H:i',$th2));
	    			$dm = explode(':',date('H:i',strtotime($dinhmuc)));
			    	$sbc = $thucte[0]*60 + $thucte[1];
			    	$sc = $dm[0]*60 + $dm[1];
			    	$div = number_format($sbc/$sc*100,0); // Đúng
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
			    	$div = number_format($sbc/$sc*100,0); // Đúng
			    	$target = [date('H:i',$th1),$div];
					return $target;
				}
				if($checkf < 0){
					$th2 = strtotime($timef) - strtotime($getamf->start_pm) + strtotime($getamf->end_am) - strtotime($getamf->start_am) + strtotime($getams->end_pm) - strtotime($times);
					$thucte = explode(':', date('H:i',$th2));
	    			$dm = explode(':',date('H:i',strtotime($dinhmuc)));
			    	$sbc = $thucte[0]*60 + $thucte[1];
			    	$sc = $dm[0]*60 + $dm[1];
			    	$div = number_format($sbc/$sc*100,0); // Đúng
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
			    	$div = number_format($sbc/$sc*100,0); // Đúng
			    	$target = [date('H:i',$th1),$div];
				}
				if($checkf < 0){
					$th2 = strtotime($timef) - strtotime($getamf->start_pm) + strtotime($getamf->end_am) - strtotime($getamf->start_am) + strtotime($getams->end_pm) - strtotime($getams->start_pm) + strtotime($getams->end_am) - strtotime($times);
					$thucte = explode(':', date('H:i',$th2));
	    			$dm = explode(':',date('H:i',strtotime($dinhmuc)));
			    	$sbc =($total_hour + $thucte[0])*60 + $thucte[1] + $total_min;
			    	$sc = $dm[0]*60 + $dm[1];
			    	$div = number_format($sbc/$sc*100,0); // Đúng
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
			    	$div = number_format($sbc/$sc*100,0); // Đúng
			    	$target = [date('H:i',$th1),$div];
					return $target;
				}
				if($checkf < 0){
					$th2 = strtotime($timef) - strtotime($getamf->start_pm) + strtotime($getamf->end_am) - strtotime($getamf->start_am) + strtotime($getams->end_pm) - strtotime($times);
					$thucte = explode(':', date('H:i',$th2));
	    			$dm = explode(':',date('H:i',strtotime($dinhmuc)));
			    	$sbc =($total_hour + $thucte[0])*60 + $thucte[1] + $total_min;
			    	$sc = $dm[0]*60 + $dm[1];
			    	$div = number_format($sbc/$sc*100,0); // Đúng
			    	$target = [date('H:i',$th2),$div];
					return $target;
				}
			}
        }
    }

    public static function checkdate($date,$time)
    {
    	$dt = Carbon::now('Asia/Ho_Chi_Minh');
		if($date >= $dt->toDateString() and $time >= $dt->toTimeString()) {
			return 'modal';
		}
    }

    public static function checkdatenow($date)
    {
    	$dt = Carbon::now('Asia/Ho_Chi_Minh');
		if($date === $dt->toDateString()){
    		return 'bg-success';
    	}
    	if (date('l',strtotime($date)) === 'Sunday' and $date !== $dt->toDateString()) {
    		return 'bg-danger';
    	}
    }

    public static function dukien($date,$dinhmuc,$start)
    {
    	$time = explode(':', $dinhmuc);
    	$min = $time[0]*60 + $time[1];
    	$time_tb = 8*60;

    	return $start;
    }

    public static function nhapkho($parent){
    	$getTimeAll = MenuItems::where('parent',$parent)->pluck('dinhmuc');
    	foreach ($getTimeAll as $key => $value) {
			$time_chinh = explode(':', $value);
			$hour[] = $time_chinh[0];
			$min[] = $time_chinh[1];
      	}      	
		$total_hour = array_sum($hour); 
		$total_min = array_sum($min);
		$getIdTimeThuc = MenuItems::whereNotNull('status_kehoach')->where('parent',$parent)->max('id');
		// return $getIdTimeThuc;
		if ($getIdTimeThuc == null) {
			return '';
		}else{
			$getAllIdTimeThuc = MenuItems::whereNotNull('status_kehoach')->where('parent',$parent)->where('id','<',$getIdTimeThuc+1)->pluck('id');
			$dataTimeThuc = MenuItems::whereIn('id',$getAllIdTimeThuc)->pluck('dinhmuc');
	    	foreach ($dataTimeThuc as $k => $v) {
				$time_now = explode(':', $v);
				$hour_now[] = $time_now[0];
				$min_now[] = $time_now[1];
	      	}   
	      	$total_hour_now = array_sum($hour_now); 
			$total_min_now = array_sum($min_now);   	
			$min_now = $total_hour_now * 60 + $total_min_now;
			$target = number_format($min_now / ($total_hour * 60 + $total_min) *100);
			return $target;
		}
    }

    public static function getKien($sort,$postion)
    {
    	$getLenh = Lenh::where('position_order',$sort)->first();
    	foreach (json_decode($getLenh['id_menu']) as $k => $v) {
    		if ($k == $postion) {
			    $id = $v;
    		}
		}
    	$getName = MenuItems::where('id',$id)->first();
    	return $getName->label;
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

    public static function format_number($value)
    {
    	$tach = explode(',',$value);
    	if(isset($tach[1])){
	    	$gop =(int) $tach[0].$tach[1];
    	}else{
    		$gop =(int) $tach[0];
    	}
    	return $gop;
    }

    public static function warning($date)
    {
        $color = '';
        if (!empty($date)) {
	        $now = Carbon::now('Asia/Ho_Chi_Minh');
	        $first = $date;
	        $last =  $now->toDateString();
	        $step = '+1 day';
	        $format = 'd-m-Y';
	        $dates = array();
			$current = strtotime( $first );
			$last = strtotime( $last );
			while( $current <= $last ) {
				$dates[] = date( $format, $current );
				$current = strtotime( $step, $current );
			}

	    	$count = count($dates);
	    	if ($count < 7) {
	    		$color = ' label-warning';
	    	}
	    	if ($count > 6 && $count < 13) {
	    		$color = 'bg-danger';
	    	}
	    	if ($count > 12 && $count < 20) {
	    		$color = ' label-danger';
	    	}
	    	if ($count > 19) {
	    		$color = ' label-default';
	    	}
	    	return [
	    		'count' => $count,
	    		'class' => $color,
	    	];
        }else{
        	return [
 	    		'class' => $color,
	    	];
        }

    }
}
