<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\models\schedules;
use App\models\module_class;
use App\models\teacher;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class AssignController extends Controller
{
    //
    public function index() {
    	$schedules = DB::table('schedules')->select(DB::raw('distinct schedules.ID_Module_Class ,Module_Class_Name,Number_Reality,School_Year,ID_Teacher'))->join('module_class','module_class.ID_Module_Class', '=' , 'schedules.ID_Module_Class')->where('ID_Teacher','=',null)->paginate(10);
    	

        $teacher = DB::table('teacher')->where('Is_Delete','=','0')->get();
        $school = DB::select(DB::raw("SELECT DISTINCT School_Year FROM module_class "));
        $departments = DB::select(DB::raw("SELECT ID_Department,Department_Name FROM department"));
        $module = DB::select(DB::raw("SELECT DISTINCT ID_Module,Module_Name FROM module "));

        return view ('assign.assign', ['schedules' => $schedules,'teacher' => $teacher,'school' => $school, 'module' => $module,'departments' => $departments] );
    }

    public function submit(Request $request) {
    	//print_r($request->request);
    	$i = 0;
        $j = 0;
    	$array = [] ;
    	$magv = '0086';

    	foreach($request->request as $key2 =>$value) {
            //print_r($key2);
            if($j==1) {
                $magv = $value;
                //echo $value."<br />"; 
                $j=2;
            }
            else {
                $j++;
            }
    		//echo $key2."<br />"		;
    		if($i == 2) {
				//echo $key2."<br />";
				$test1 = explode("/",$key2)[0];
				$test2 = explode("/",$key2)[1];
				$key2 = $test1." ".$test2;
				$key2 = str_replace('_', '.', $key2);
                 if($magv == '') {
                    return back()->withErrors('Chưa chọn giảng viên');
                }
                //return back()->withErrors($key2.$magv);
                //echo "dayla";
				//echo $key2." "."abc"."<br />"."abc"."<br />";
				$sch = DB::table('schedules')->where('ID_Module_Class',   $key2)->get();
                $sch_gv = DB::table('schedules')->join('module_class','schedules.ID_Module_Class','=','module_class.ID_Module_Class')->where('ID_Teacher',   $magv)->get();

                foreach($sch_gv as $value1) {
                    foreach ($sch as  $value2) {
                        if($value1->Day_Schedules == $value2->Day_Schedules) {
                            return back()->withErrors("Lỗi ".$value1->ID_Module_Class." Thời gian: ".$value1->Day_Schedules." Trùng với môn: ".$value2->ID_Module_Class);
                        }
                    }
                }
				
                //echo $key2;
				DB::table('module_class')->where('ID_Module_Class', $key2)->update(['ID_Teacher' => $magv]);
    		}
    		else {
    			$i = $i + 1;
    		}
    		
    	}
        return back()->with('thongbao','Thanh cong');
    }


    public function getGV($id) {
        echo $id;
        $teacher = DB::table('teacher')->where('Is_Delete','=','0')->where('ID_Department',$id)->get();
        $count =  DB::table('teacher')->where('Is_Delete','=','0')->where('ID_Department',$id)->count();
        if($count == 0 ) {
            echo "<option value =''>Chọn giảng viên</option>";
        }
        else {
             echo "<option value =''>Chọn giảng viên</option>";
            foreach($teacher as $gv) {
                echo "<option class = 'option' value = '".$gv->ID_Teacher."''>".$gv->Name_Teacher."</option>";
            }
        }
    }

    //Filter ajax
    public function getFilter(Request $request) {
        if(request()->ajax()) {

            $md = (!empty($_GET["md"])) ? ($_GET["md"]) : ('');
            $dp = (!empty($_GET["dp"])) ? ($_GET["dp"]) : ('');
            $sy = (!empty($_GET["sy"])) ? ($_GET["sy"]) : ('');

            $data = DB::table('module_class')
            ->join('module','module_class.ID_Module', '=' , 'module.ID_Module')
            ->when($md,function($query,$md) {
                return $query->where('module_class.ID_Module',$md);
            })->when($sy,function($query,$sy) {
                return $query->where('School_Year',$sy);
            })->when($dp,function($query,$dp) {
                return $query->where('module.ID_Department',$dp);
            })->where('ID_Teacher','=',NULL)->paginate(10);
            
            return Response::json($data);
        }
    }

    public function index2() {
        $schedules = DB::table('schedules')->select(DB::raw('distinct schedules.ID_Module_Class ,Module_Class_Name,Number_Reality,School_Year,ID_Teacher'))->join('module_class','module_class.ID_Module_Class', '=' , 'schedules.ID_Module_Class')->where('ID_Teacher','<>',null)->paginate(10);
        $school = DB::select(DB::raw("SELECT DISTINCT School_Year FROM module_class "));
        $departments = DB::select(DB::raw("SELECT ID_Department,Department_Name FROM department"));
        $module = DB::select(DB::raw("SELECT DISTINCT ID_Module,Module_Name FROM module "));

        return view ('assign.assignList', ['schedules' => $schedules,'school' => $school, 'module' => $module,'departments' => $departments] );
    }

     //Filter ajax
    public function getFilterList(Request $request) {
        if(request()->ajax()) {

            $md = (!empty($_GET["md"])) ? ($_GET["md"]) : ('');
            $dp = (!empty($_GET["dp"])) ? ($_GET["dp"]) : ('');
            $sy = (!empty($_GET["sy"])) ? ($_GET["sy"]) : ('');

            $data = DB::table('module_class')
            ->join('module','module_class.ID_Module', '=' , 'module.ID_Module')
            ->when($md,function($query,$md) {
                return $query->where('module_class.ID_Module',$md);
            })->when($sy,function($query,$sy) {
                return $query->where('School_Year',$sy);
            })->when($dp,function($query,$dp) {
                return $query->where('module.ID_Department',$dp);
            })->where('ID_Teacher','<>',NULL)->get();
            
            return Response::json($data);
        }
    }

    public function deleteThongTin($id) {
        DB::table('module_class')->where('ID_Module_Class' , $id)->update(['ID_Teacher' => null]);;
        return redirect('admin/assign/list')->with('thongbao', 'Xóa phân giảng thành công');
    }
}
