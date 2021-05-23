<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon;
use Illuminate\Support\Facades\Mail;

class RequestFixController extends Controller
{
    
    public function getThongTin() {
    	$fix = DB::table('fix')->join('schedules','schedules.ID_Schedules','=','fix.ID_Schedules')->select('fix.ID_Fix','fix.ID_Schedules','fix.ID_Room as newRoom','fix.Shift_Fix as newShift','fix.Day_Fix as newDay','fix.ID_Teacher_Option', 'schedules.ID_Room as oldRoom','schedules.Shift_Schedules as oldShift','schedules.Day_Schedules as oldDay','schedules.ID_Module_Class')->whereNULL('Time_Accept_Request')->get();
    	return view('fix.requestFix', ['fix' => $fix]);
    }

    public function Accept($id) {
    	echo "da vao";
    	echo $id;
        
    	$now = Carbon\Carbon::now();
    	echo $now->format('d m y ');
    	// DB::table('fix')->where('ID_Fix','=',$id)->update(['Time_Accept_Request'=>$now]);
    	// DB::table('fix')->where('ID_Fix','=',$id)->update(['Status_Fix'=>'Chấp nhận']);
        $m = 'Yêu cầu của bạn được chấp nhận';
        $this->sendMail($id,$m);
    	return back()->with('thongbao','Chấp nhận thành công');
    }

    public function Decline($id) {
    	echo "da vao";
    	echo $id;
    	$now = Carbon\Carbon::now();
    	echo $now->format('d m y ');
    	// DB::table('fix')->where('ID_Fix','=',$id)->update(['Time_Accept_Request' => $now]);
    	// DB::table('fix')->where('ID_Fix','=',$id)->update(['Status_Fix'=>'Từ chối']);
        $m = 'Yêu cầu của bạn bị từ chối';
        $this->sendMail($id,$m);
    	return back()->with('thongbao','Từ chối thành công');
    }

    public function sendMail($id,$m) {
        $id_sch2 = DB::table('fix')->where('ID_Fix','=',$id)->get();
        $id_sch = DB::table('schedules')->where('ID_Schedules','=',$id_sch2[0]->ID_Schedules)->get();
       

        Mail::send('email',[
            'id' => $id_sch[0]->ID_Schedules,
            'id_md' => $id_sch[0]->ID_Module_Class,
            'id_room' => $id_sch[0]->ID_Room,
            'shift' => $id_sch[0]->Shift_Schedules,
            'day' => $id_sch[0]->Day_Schedules,
            'tt' => $m
        ],function($message) {
            //$message->from('hkim661990@gmail.com', '');
            $message->to('hkim661990@gmail.com','');
            $message->subject('Phản hồi yêu cầu thay đổi giờ giảng');
        });
    }
}