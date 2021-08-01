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
        $schedules = DB::table('module_class')->
            //join('teacher','teacher.ID_Teacher','=','module_class.ID_Teacher')->
            where('ID_Module_Class','LIKE','MHT%')->
            whereNULL('module_class.ID_Teacher')-> 
            orderBy('ID_Module_Class', 'asc')->
            paginate(10);
    

        $maAcc = Auth::user()->id;
        
        $maBM = DB::table('department')->where('ID_Account','=',$maAcc)->orderBy('Department_Name','asc')->get();
        
        $teacher = DB::table('teacher')->where('Is_Delete','=','0')->where('ID_Department','=',$maBM[0]->ID_Department)->get();

        $teacher_All = DB::table('teacher')->where('Is_Delete','=','0')->get();

        $school = DB::select(DB::raw("SELECT DISTINCT School_Year FROM module_class "));
        $departments = DB::select(DB::raw("SELECT ID_Department,Department_Name FROM department"));
        $module = DB::select(DB::raw("SELECT DISTINCT ID_Module,Module_Name FROM module where ID_Module like 'MHT%' order By Module_Name ASC"));
        
        
        return view ('assign.assign', ['schedules' => $schedules,'teacher' => $teacher,'school' => $school, 'module' => $module,'departments' => $departments, 'teacher_All' => $teacher_All] )->render();
    }

    public function submit(Request $request) {
    	
    	$array = [] ; $magv = ''; $Error = ''; $numberRequest = 0 ;

        //Dem so truong da them thanh cong
        $numberInsertedValue = 0;
       
        //Lấy mã giảng viên
        if(is_null($request->input('select_gv'))) {
            $magv = $request->input('select_gv_2');
        }
        else {
            $magv = $request->input('select_gv');
        }
        //Hết lấy mã giảng viên
        
        $numberRequest = count($request->all());
    	foreach($request->request as  $key2=>$value) {
            if( $numberRequest >= count($request->all()) - 4) {
                $numberRequest--;
                continue;
            }
            $numberRequest--;
            

			$test1 = explode("/",$key2)[0];
			$test2 = explode("/",$key2)[1];
			$key2 = $test1." ".$test2;
			$key2 = str_replace('_', '.', $key2);
            //Ket thuc lay lai ma hoc phan
            echo $test1."<br />".$test2."<br />".$key2."<br />";
            //Kiem tra du lieu
            if($magv == '') {
                $Error = 'Thiếu tên giảng viên.';
                break;
            }
			$count_sch = DB::table('module_class')->where('ID_Module_Class','=', $key2)->count();
            $sch = DB::table('schedules')->where('ID_Module_Class','=', $key2)->get();
            //dd($sch);
            $sch_gv = DB::table('schedules')->join('module_class','schedules.ID_Module_Class','=','module_class.ID_Module_Class')->where('ID_Teacher',   $magv)->get();
            
            if($count_sch <= 0) {
                $Error = 'Mã học phần không tồn tại: '.$key2;
                break;
            }
            if($sch_gv->isEmpty()) {
                DB::table('module_class')->where('ID_Module_Class', $key2)->update(['ID_Teacher' => $magv]);
                $numberInsertedValue++;
                continue;
            }
            //Ket thuc kiem tra du lieu
            foreach($sch_gv as $value1) {
                foreach ($sch as  $value2) {
                    //dd($value1);
                    if(($value1->Day_Schedules == $value2->Day_Schedules 
                        and $value1->Shift_Schedules == $value2->Shift_Schedules) 
                        and $value1->Shift_Schedules != 0 )
                    {
                        $Error = "Lỗi ".$value1->ID_Module_Class." Thời gian: ".$value1->Day_Schedules.";Ca: ".$value1->Shift_Schedules." Trùng với môn: ".$value2->ID_Module_Class.";Ca: ".$value2->Shift_Schedules;
                        break 3;
                    }
                }
            }
            //Luu qua trinh phan giang
            
            DB::table('module_class')->where('ID_Module_Class', $key2)->update(['ID_Teacher' => $magv]);
        
            $numberInsertedValue++;
            //Ket thuc luu qua trinh phan giang
        }

        if($Error != '') {
            return back()->withErrors($Error)->with('thongbao','Thành công: '.$numberInsertedValue)->withInput();
        }
        else {
            return back()->with('thongbao','Thành công: '.$numberInsertedValue)->withInput();
        }

    }


    public function getGV($id) {
        //echo $id;
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
    // public function getFilter(Request $request) {
    //     if(request()->ajax()) {

    //         $md = (!empty($_GET["md"])) ? ($_GET["md"]) : ('');
    //         $dp = (!empty($_GET["dp"])) ? ($_GET["dp"]) : ('');
    //         $sy = (!empty($_GET["sy"])) ? ($_GET["sy"]) : ('');
    //         $dh = (!empty($_GET["dh"])) ? ($_GET["dh"]) : ('');
    //         $kind = (!empty($_GET["kind"])) ? ($_GET["kind"]) : ('');

    //         $data = DB::table('module_class')
    //         ->join('module','module_class.ID_Module', '=' , 'module.ID_Module')
    //         ->where('ID_Module_Class','LIKE','MHT%')
    //         ->whereNULL('module_class.ID_Teacher')
    //         ->orderBy('ID_Module_Class', 'asc')
    //         ->when($md,function($query,$md) {
    //             return $query->where('module_class.ID_Module',$md);
    //         })->when($sy,function($query,$sy) {
    //             return $query->where('School_Year',$sy);
    //         })->when($dp,function($query,$dp) {
    //             return $query->where('module.ID_Department',$dp);
    //         })->when($kind,function($query,$kind) {
    //             if($kind == "BT") {
    //                 return $query->where('module_class.Module_Class_Name', 'like', '%BT%');
    //             }
    //             else if($kind == "TH"){
    //                 return $query->where('module_class.Module_Class_Name', 'like', '%.1%');
    //             }
    //             else if($kind == "TL") {
    //                 return $query->where('module_class.Module_Class_Name', 'like', '%TL%');
    //             }
    //             else if($kind == "DA"){
    //                 return $query->where('module_class.Module_Class_Name', 'like', '%DA%');
    //             }
    //             else return $query->where('module_class.Module_Class_Name', 'not like', '%.1%')->where('module_class.Module_Class_Name', 'not like', '%BT%')->where('module_class.Module_Class_Name', 'not like', '%TL%')->where('module_class.Module_Class_Name', 'not like', '%DA%');
    //         })->when($dh,function($query,$dp) {
    //             if($dh > 1 ) return $query->where('module_class.ID_Module_Class','like','%.'.$t.' (%');
    //         })->where('ID_Teacher','=',NULL)->where('ID_Module_Class','like','MHT%')->get();
            
    //         return Response::json($data);
    //     }
    // }

    public function getFilter(Request $request) {
        
        
            $md = (!empty($_GET["md"])) ? ($_GET["md"]) : ('');
            $dp = (!empty($_GET["dp"])) ? ($_GET["dp"]) : ('');
            $sy = (!empty($_GET["sy"])) ? ($_GET["sy"]) : ('');
            $dh = (!empty($_GET["dh"])) ? ($_GET["dh"]) : ('');
            $kind = (!empty($_GET["kind"])) ? ($_GET["kind"]) : ('');

            $data = DB::table('module_class')
            ->join('module','module_class.ID_Module', '=' , 'module.ID_Module')
            ->where('ID_Module_Class','LIKE','MHT%')
            ->whereNULL('module_class.ID_Teacher')
            ->orderBy('ID_Module_Class', 'asc')
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
                elseif($kind == "TH"){
                    return $query->where([
                                    ['module_class.Module_Class_Name', 'like', '%.1%'],
                                    ['module_class.Module_Class_Name', 'not like', '%BT%'],
                                    ['module_class.Module_Class_Name', 'not like', '%TT%'],
                                ])
                                ->orWhere([
                                    ['module_class.Module_Class_Name', 'like', '%TH%'],
                                    ['module_class.Module_Class_Name', 'not like', '%BT%'],
                                    ['module_class.Module_Class_Name', 'not like', '%TT%'],
                                ]);
                }
                elseif($kind == "TL") {
                    return $query->where('module_class.Module_Class_Name', 'like', '%TL%');
                }
                elseif($kind == "DA"){
                    return $query->where('module_class.Module_Class_Name', 'like', '%DA%');
                }
                elseif($kind == "TT") {
                      return $query->where('module_class.Module_Class_Name', 'like', '%TT%');
                }
                else return $query->where('module_class.Module_Class_Name', 'not like', '%.1%')
                                ->where('module_class.Module_Class_Name', 'not like', '%TH%')   
                                ->where('module_class.Module_Class_Name', 'not like', '%BT%')
                                ->where('module_class.Module_Class_Name', 'not like', '%TL%')
                                ->where('module_class.Module_Class_Name', 'not like', '%DA%')
                                ->where('module_class.Module_Class_Name', 'not like', '%TT%');
            })->when($dh,function($query,$dh) {
                if($dh > 1 ) return $query->where('module_class.ID_Module_Class','like','%-'.$dh.' (%');
            })->where('ID_Teacher','=',NULL)->where('ID_Module_Class','like','MHT%')->paginate(10);
            

            $teacher = DB::table('teacher')->where('Is_Delete','=','0')->where('ID_Department','=','MHT')->get();
            $teacher_All = DB::table('teacher')->where('Is_Delete','=','0')->get();
            $departments = DB::select(DB::raw("SELECT ID_Department,Department_Name FROM department"));
        
            return view('assign.assignView')->with(['schedules' => $data, 'teacher' => $teacher,'teacher_All' => $teacher_All,'departments' => $departments]);
    }

    // public function test() {
    //     $md = (!empty($_GET["md"])) ? ($_GET["md"]) : ('');
    //     $dp = (!empty($_GET["dp"])) ? ($_GET["dp"]) : ('');
    //     $sy = (!empty($_GET["sy"])) ? ($_GET["sy"]) : ('');
    //     $dh = (!empty($_GET["dh"])) ? ($_GET["dh"]) : ('');
    //     $kind = (!empty($_GET["kind"])) ? ($_GET["kind"]) : ('');

    //     $data = DB::table('module_class')
    //     ->join('module','module_class.ID_Module', '=' , 'module.ID_Module')
    //     ->where('ID_Module_Class','LIKE','MHT%')
    //     ->whereNULL('module_class.ID_Teacher')
    //     ->orderBy('ID_Module_Class', 'asc')
    //     ->when($md,function($query,$md) {
    //         return $query->where('module_class.ID_Module',$md);
    //     })->when($sy,function($query,$sy) {
    //         return $query->where('School_Year',$sy);
    //     })->when($dp,function($query,$dp) {
    //         return $query->where('module.ID_Department',$dp);
    //     })->when($kind,function($query,$kind) {
    //         if($kind == "BT") {
    //             return $query->where('module_class.Module_Class_Name', 'like', '%BT%');
    //         }
    //         else if($kind == "TH"){
    //             return $query->where('module_class.Module_Class_Name', 'like', '%.1%');
    //         }
    //         else if($kind == "TL") {
    //             return $query->where('module_class.Module_Class_Name', 'like', '%TL%');
    //         }
    //         else if($kind == "DA"){
    //             return $query->where('module_class.Module_Class_Name', 'like', '%DA%');
    //         }
    //         else return $query->where('module_class.Module_Class_Name', 'not like', '%.1%')->where('module_class.Module_Class_Name', 'not like', '%BT%')->where('module_class.Module_Class_Name', 'not like', '%TL%')->where('module_class.Module_Class_Name', 'not like', '%DA%');
    //     })->when($dh,function($query,$dp) {
    //         if($dh > 1 ) return $query->where('module_class.ID_Module_Class','like','%.'.$t.' (%');
    //     })->where('ID_Teacher','=',NULL)->where('ID_Module_Class','like','MHT%')->paginate(10);
        

    //     $teacher = DB::table('teacher')->where('Is_Delete','=','0')->where('ID_Department','=','MHT')->get();
    //     $teacher_All = DB::table('teacher')->where('Is_Delete','=','0')->get();
    //     $departments = DB::select(DB::raw("SELECT ID_Department,Department_Name FROM department"));
    
    //     return view('assign.assignView')->with(['schedules' => $data, 'teacher' => $teacher,'teacher_All' => $teacher_All,'departments' => $departments]);
    // }

    public function index2() {
        $schedules = DB::table('module_class')->
            join('teacher','teacher.ID_Teacher','=','module_class.ID_Teacher')->
            where('ID_Module_Class','LIKE','MHT%')->
            orderBy('ID_Module_Class', 'asc')->
            where('module_class.ID_Teacher','<>',null)->
            paginate(10);

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
        return back()->with('thongbao', 'Xóa phân giảng thành công');
    }
}
