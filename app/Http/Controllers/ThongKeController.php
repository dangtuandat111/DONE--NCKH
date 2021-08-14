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

    public function testLoi() {
    	$data = DB::select("
    		Select * 
    		from module_class
    		inner join schedules on module_class.ID_Module_Class = schedules.ID_Module_Class
    		where School_Year = '1-21'
    	");

    	$GVs = DB::select("
    		Select * 
    		from teacher
    	");

    	
    	foreach($GVs as $gv) {
    		echo $gv->Name_Teacher;
    		$listError = [];
    		$i =0;
    		$datas = DB::select("
	    		Select * 
	    		from module_class
	    		inner join schedules on module_class.ID_Module_Class = schedules.ID_Module_Class
	    		where School_Year = '1-21'
	    		"." and ID_Teacher = '".$gv->ID_Teacher."'"
    		);
    		foreach($datas as $value1) {
    			foreach($datas as $value2) {
    				if(
    					($value1->Day_Schedules == $value2->Day_Schedules and $value1->Shift_Schedules == $value2->Shift_Schedules) and 
    					($value1->Shift_Schedules != 0 or $value2->Shift_Schedules != 0) and 
    					($value1->ID_Module_Class != $value2->ID_Module_Class)
    				){
                        $Error = "Lỗi ".$value1->Module_Class_Name." Thời gian: ".$value1->Day_Schedules.";Ca: ".$value1->Shift_Schedules." Trùng với môn: ".$value2->Module_Class_Name." Thời gian: ".$value1->Day_Schedules.";Ca: ".$value2->Shift_Schedules;
                        array_push($listError,$Error);
                    }
    			}
    		}
    		print("<pre>".print_r($listError,true)."</pre>");
    		echo "<br />";
    	}

    }
}
