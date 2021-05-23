<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon;

class RequestFixController extends Controller
{
    public function getThongTin() {
    	$fix = DB::table('fix')->join('schedules','schedules.ID_Schedules','=','fix.ID_Schedules')->select('fix.ID_Fix','fix.ID_Schedules','fix.ID_Room as newRoom','fix.Shift_Fix as newShift','fix.Day_Fix as newDay','fix.ID_Teacher_Option', 'schedules.ID_Room as oldRoom','schedules.Shift_Schedules as oldShift','schedules.Day_Schedules as oldDay','schedules.ID_Module_Class')->whereNULL('Time_Accept_Request')->get();
    	// $id = $fix[0]->ID_Schedules;
    	//dd($fix);
    

    	// for($i = 0 ;$i<count($fix);$i++) {
    	// 	$id = $fix[$i]->ID_Schedules;
    	// 	$info = DB::table('schedules')->where('ID_Schedules','=', $id)->get();
    	// 	//dd($fix[$i]);
    	// 	$fix->put('old_Shift',$info[0]->Shift_Schedules);
    	// 	//$fix[$i]['old_Shift'] = $info[0]->Shift_Schedules;
    	// 	dd($fix);
    	// }
    	
    	//dd($fix);
    	return view('fix.requestFix', ['fix' => $fix]);
    }

    public function Accept($id) {
    	echo "da vao";
    	echo $id;
    	$now = Carbon\Carbon::now();
    	echo $now->format('d m y ');
    	DB::table('fix')->where('ID_Fix','=',$id)->update(['Time_Accept_Request'=>$now]);
    	DB::table('fix')->where('ID_Fix','=',$id)->update(['Status_Fix'=>'Chấp nhận']);
    	return back()->with('thongbao','Chap nhan thanh cong');
    }

    public function Decline($id) {
    	echo "da vao";
    	echo $id;
    	$now = Carbon\Carbon::now();
    	echo $now->format('d m y ');
    	DB::table('fix')->where('ID_Fix','=',$id)->update(['Time_Accept_Request' => $now]);
    	DB::table('fix')->where('ID_Fix','=',$id)->update(['Status_Fix'=>'Từ chối']);
    	return back()->with('thongbao','Tu choi thanh cong');
    }
}