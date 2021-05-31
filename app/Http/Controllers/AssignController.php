<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\models\schedules;
use App\models\module_class;
use App\models\teacher;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;


class AssignController extends Controller
{
    //
    public function index() {
    	$schedules = DB::table('schedules')->select(DB::raw(' schedules.ID_Module_Class ,Module_Class_Name,Number_Reality,School_Year,ID_Teacher'))->join('module_class','module_class.ID_Module_Class', '=' , 'schedules.ID_Module_Class')->whereNULL('ID_Teacher')->paginate(10);
    	
        $maAcc = Auth::user()->id;
        
        $maBM = DB::table('department')->where('ID','=',$maAcc)->get();
        
        $teacher = DB::table('teacher')->where('Is_Delete','=','0')->where('ID_Department','=',$maBM[0]->ID_Department)->get();

        $teacher_All = DB::table('teacher')->where('Is_Delete','=','0')->get();

        $school = DB::select(DB::raw("SELECT DISTINCT School_Year FROM module_class "));
        $departments = DB::select(DB::raw("SELECT ID_Department,Department_Name FROM department"));
        $module = DB::select(DB::raw("SELECT DISTINCT ID_Module,Module_Name FROM module "));

        //dd($schedules);
        return view ('assign.assign', ['schedules' => $schedules,'teacher' => $teacher,'school' => $school, 'module' => $module,'departments' => $departments, 'teacher_All' => $teacher_All] );
    }

    public function submit(Request $request) {
    	   // print_r($request->request);
    	$i = 0;
        $j = 0;
    	$array = [] ;
    	$magv = '0086';
        $Error = '';

    	foreach($request->request as $key2 =>$value) {
            print_r($key2);
            if($j==2) {
                $magv = $value;
                //echo $value."<br />"; 
               
                $j++;
            }
            else {
                $j++;
            }
    		if($i == 4) {
				//Lay lai ma hoc phan 
				$test1 = explode("/",$key2)[0];
				$test2 = explode("/",$key2)[1];
				$key2 = $test1." ".$test2;
				$key2 = str_replace('_', '.', $key2);
                //Ket thuc lay lai ma hoc phan

                //Kiem tra du lieu
                if($magv == '') {
                    //echo "gv".$magv;
                    $Error = 'Thiếu tên giảng viên.';
                    break;
                }
				$sch = DB::table('schedules')->where('ID_Module_Class',   $key2)->get();
                $sch_gv = DB::table('schedules')->join('module_class','schedules.ID_Module_Class','=','module_class.ID_Module_Class')->where('ID_Teacher',   $magv)->get();
                
                if($sch->isEmpty()) {
                    $Error = 'Mã học phần không tồn tại';
                    break;
                }
                if($sch_gv->isEmpty()) {
                    $Error = 'Lịch trình không tồn tại';
                    break;
                }
                //Ket thuc kiem tra du lieu

                foreach($sch_gv as $value1) {
                    foreach ($sch as  $value2) {
                        if(($value1->Day_Schedules == $value2->Day_Schedules and $value1->Shift_Schedules == $value2->Shift_Schedules) ){

                            $Error = "Lỗi ".$value1->ID_Module_Class." Thời gian: ".$value1->Day_Schedules." Trùng với môn: ".$value2->ID_Module_Class;
                            break 2;
                            // return back()->withErrors("Lỗi ".$value1->ID_Module_Class." Thời gian: ".$value1->Day_Schedules." Trùng với môn: ".$value2->ID_Module_Class);
                        }
                    }
                }
                //Luu qua trinh phan giang
				DB::table('module_class')->where('ID_Module_Class', $key2)->update(['ID_Teacher' => $magv]);
                //Ket thuc luu qua trinh phan giang
    		}
    		else {
    			$i = $i + 1;
    		}
    		
    	}
        if($Error != '') {
            return back()->withErrors($Error);
        }
        else {
            //return back()->with('thongbao','Thành công');
        }
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
            $dh = (!empty($_GET["dh"])) ? ($_GET["dh"]) : ('');
            $kind = (!empty($_GET["kind"])) ? ($_GET["kind"]) : ('');

            $data = DB::table('module_class')
            ->join('module','module_class.ID_Module', '=' , 'module.ID_Module')
            ->when($md,function($query,$md) {
                return $query->where('module_class.ID_Module',$md);
            })->when($sy,function($query,$sy) {
                return $query->where('School_Year',$sy);
            })->when($dp,function($query,$dp) {
                return $query->where('module.ID_Department',$dp);
            })->when($kind,function($query,$kind) {
                if($kind == "BT") {
                    return $query->where('module_class.Module_Class_Name', 'like', '%BT%');
                }
                else if($kind == "TH"){
                    return $query->where('module_class.Module_Class_Name', 'like', '%.1%');
                }
                else if($kind == "TL") {
                      return $query->where('module_class.Module_Class_Name', 'like', '%TL%');
                }
                else return $query->where('module_class.Module_Class_Name', 'not like', '%.1%')->where('module_class.Module_Class_Name', 'not like', '%BT%')->where('module_class.Module_Class_Name', 'not like', '%TL%');
            })->where('ID_Teacher','=',NULL)->paginate(10);
            
            return Response::json($data);
        }
    }

    public function index2() {
        $schedules = DB::table('schedules')->select(DB::raw(' schedules.ID_Module_Class ,Module_Class_Name,Number_Reality,School_Year,ID_Teacher'))->join('module_class','module_class.ID_Module_Class', '=' , 'schedules.ID_Module_Class')->where('ID_Teacher','<>',null)->paginate(10);
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
