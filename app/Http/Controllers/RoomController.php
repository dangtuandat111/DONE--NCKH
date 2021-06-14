<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon;

class RoomController extends Controller
{
    public function index() {
    	$fix = DB::table('fix')->whereNULL('ID_Room')->where('Status_Fix','=','Chấp nhận')->get();
    	$room = DB::table('room')->get();
    	return view('room.thongtin',['fix' => $fix, 'room' => $room]);
    }
    public function submit(Request $request) {
    	//dd($request);
    	$i = 0;
    	$id = -1;
        $numberInsertedValue = 0;
    	foreach ($request->request as $rq => $value) {
    		if($i == 0) {
    			$i = 1;
    			continue;
    		}
    		else {
    			if ($i == 1) {
    				$id = $rq;
    				$i = 2;
    				continue;
    			}
    			if ($i == 2) {
    				//dd($value);
                    $now = Carbon\Carbon::now();
                    //echo $now->format('d m y ');
    				DB::table('fix')->where('ID_Fix','=',$id)->update(['ID_Room' => $value,'Time_Set_Room' => $now]);
                    $a = DB::table('fix')->where('ID_Fix','=',$id)->get();
                    $b = DB::table('schedules')->where('ID_Schedules','=',$a[0]->ID_Schedules)->get();
                    //Update lại bảng schedules
                    DB::table('schedules')->where('ID_Schedules','=',$a[0]->ID_Schedules)->update(['ID_Room' => $a[0]->ID_Room, 'Shift_Schedules' => $a[0]->Shift_Fix, 'Day_Schedules' => $a[0]->Day_Fix  ]);
                    //Update lại bảng fix
                    DB::table('fix')->where('ID_Fix','=',$a[0]->ID_Fix)->update(['ID_Room' => $b[0]->ID_Room, 'Shift_Fix' => $b[0]->Shift_Schedules, 'Day_Fix' => $b[0]->Day_Schedules ]);
                    print_r($a);
                    $i = 1;
                    $id = -1;
                    $numberInsertedValue++;
    			}
    		}
    	}
        return back()->with('thanhcong','Thanh cong');
    }
}
