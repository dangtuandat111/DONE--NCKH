<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ThongKeController extends Controller
{
    //
    public function index() {
    	$data = DB::table('fix')->join('schedules','fix.ID_Schedules','=','schedules.ID_Schedules')->join('module_class','module_class.ID_Module_Class','=','schedules.ID_Module_Class')->join('teacher','teacher.ID_Teacher','=','module_class.ID_Teacher')->paginate(10,['teacher.ID_Teacher','Name_Teacher','schedules.ID_Module_Class','fix.ID_Room','Shift_Fix','Day_Fix','Time_Fix_Request','Time_Accept_Request','Status_Fix','schedules.Shift_Schedules','schedules.Day_Schedules']);
    	//dd($data);
    	$school = DB::select(DB::raw("SELECT DISTINCT School_Year FROM module_class "));
    	return view('thongke.thongtin',['data' => $data,'school' => $school]);
    }
}
