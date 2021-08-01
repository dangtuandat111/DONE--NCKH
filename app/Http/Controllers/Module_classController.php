<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\module_class;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use DB;

class Module_classController extends Controller
{
    //
    public function getThongtin() {
    	$module_class = DB::table('module_class')->where('ID_Module','LIKE','%'.'MHT'.'%')->Paginate(10);
    	$credits = DB::select(DB::raw("SELECT DISTINCT Credit FROM module ORDER BY Credit asc"));
		$departments = DB::select(DB::raw("SELECT ID_Department,Department_Name FROM department"));
		$module = DB::select(DB::raw("SELECT DISTINCT ID_Module,Module_Name FROM module "));
		$school_year = DB::select(DB::raw("SELECT DISTINCT School_Year FROM module_class "));
		$teacher = DB::select(DB::raw("SELECT ID_Teacher,Name_Teacher FROM teacher "));
		return view ('module_class.thongtin', ['module_class' => $module_class,'credits' => $credits,
											'module' => $module,'departments' => $departments, 
											'school_year' =>$school_year, 'teacher' => $teacher] );
    }

    public function getFilterHP($id) {
       
        $module = DB::select(DB::raw("SELECT DISTINCT ID_Module,Module_Name FROM module where ID_Department = '".$id."'"));
        $count =  count($module);
        if($count == 0 ) {
            echo "<option value =''>Chọn học phần</option>";
        }
        else {
             echo "<option value =''>Chọn học phần</option>";
            foreach($module as $md) {
                echo "<option class = 'option' value = '".$md->ID_Module."''>".$md->Module_Name."</option>";
            }
        }
    }

    public function getFilter() {
    	//if(request()->ajax()) {

	        $md = (!empty($_GET["md"])) ? ($_GET["md"]) : ('');
	        $dp = (!empty($_GET["dp"])) ? ($_GET["dp"]) : ('');
	        $cd = (!empty($_GET["cd"])) ? ($_GET["cd"]) : ('');
            $pg = (!empty($_GET["pg"])) ? ($_GET["pg"]) : ('');
            $gv = (!empty($_GET["gv"])) ? ($_GET["gv"]) : ('');
            $sy = (!empty($_GET["sy"])) ? ($_GET["sy"]) : ('');
            $kind = (!empty($_GET["kind"])) ? ($_GET["kind"]) : ('');

        	$data = DB::table('module_class')->join('module', 'module_class.ID_Module' ,'=', 'module.ID_Module')
            ->when($md,function($query,$md) {
        		return $query->where('module_class.ID_Module',$md);
        	})->when($cd,function($query,$cd) {
        		return $query->where('module.Credit',$cd);
        	})->when($dp,function($query,$dp) {
        		return $query->where('module.ID_Department',$dp);
        	})->when($sy,function($query,$sy) {
                return $query->where('School_Year',$sy);
            })->when($gv,function($query,$gv) {
                return $query->where('module_class.ID_Teacher',$gv);
            })->when($pg,function($query,$pg) {
                if($pg == "DaPG") {
                    return $query->where('module_class.ID_Teacher','<>',NULL);
                }
                else return $query->whereNull('module_class.ID_Teacher');
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
                elseif($kind == "DA") {
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
            })->Paginate(10);
			
			return view('module_class.module_classView')->with(['module_class' => $data]);
		//}
    }
}
