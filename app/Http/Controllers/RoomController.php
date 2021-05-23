<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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
    				DB::table('fix')->where('ID_Fix','=',$id)->update(['ID_Room' => $value]);
    				return back()->with('thanhcong','Thanh cong');
    			}
    			
    		}
    	}
    }
}
