<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;
class FixController extends Controller
{
	public $data_array = ([]);
	public $data;
	public $baseQuery = "";

	public function getPaginate(Request $request) {
		//Lay id account nguoi dang nhap
    	$id = Auth::user()->id;
    	//Tim id giang vien tu id account
    	$id_teacher = DB::table("teacher")->where("ID","=",$id)->get();
    	//print_r($id_teacher);
    	foreach($id_teacher as $value => $res) {
    		// echo "<br />";
    		// print_r($res);
    		// echo $res->ID_Teacher;
    		$getID = $res->ID_Teacher;
    	}
    	//Lay thong tin toann bo giang vien
    	$teacher = DB::table("teacher")->get();
    	//Lay lop hoc phan tu id giang vien
    	$count  = DB::table('module_class')->where('ID_Teacher','=', $getID)->count();
    	$module_classes = DB::table('module_class')->where('ID_Teacher','=', $getID)->get();

    	//Lay lich hoc tu id danh sach lop hoc phan
    	if($count == 0 ) {
    		return view("fix.thongtin")->with('thongbao','Giang vien khong co hoc mon');
    	}
    	elseif ($count == 1) {
            //dd($module_classes);
    		$data = (DB::table('schedules')->where('ID_Module_Class','=',$module_classes[0]->ID_Module_Class)->paginate(10));
    		return view ('fix.thongtin', ['module_classes' => $data, 'teacher' => $teacher ] );
    	}
    	else {
    		$query = "SELECT * FROM schedules ";
    		$item = 0;
    		foreach ($module_classes as $module_class) {
				if($item == 0 ) {
					$query = $query." where ID_Module_Class = '".$module_class->ID_Module_Class."' ";
				}
				else {
					$query = $query." OR ID_Module_Class = '".$module_class->ID_Module_Class."' ";
				}
				$item ++;
    		}
    		$baseQuery = $query;
    		$this->data = collect(DB::select(DB::raw($query)));
    		$page = $request->page;
			$size = 10;
			$paginationData = new LengthAwarePaginator(
			                         $this->data->forPage($page, $size),
			                         $this->data->count(), 
			                         $size, 
			                         $page,
			                         ['path' => url('admin/fix/getPaginate')]
			                       );
    		return view ('fix.thongtin', ['module_classes' => $paginationData, 'teacher' => $teacher ]);
    	}
	}

    public function getThongTin() {
    	//Lay id account nguoi dang nhap
    	$id = Auth::user()->id;
    	//Tim id giang vien tu id account
    	$id_teacher = DB::table("teacher")->where("ID","=",$id)->get();
    	//print_r($id_teacher);
    	foreach($id_teacher as $value => $res) {
    		$getID = $res->ID_Teacher;
    	}
    	//Lay thong tin toann bo giang vien
    	$teacher = DB::table("teacher")->get();
    	//Lay lop hoc phan tu id giang vien
    	$count  = DB::table('module_class')->where('ID_Teacher','=', $getID)->count();
    	$module_classes = DB::table('module_class')->where('ID_Teacher','=', $getID)->get();

    	//Lay lich hoc tu id danh sach lop hoc phan
    	if($count == 0 ) {
    		return view("fix.thongtin")->with('thongbao','Giang vien khong co hoc mon');
    	}
    	elseif ($count == 1) {
            //dd($module_classes);
    		$data = (DB::table('schedules')->where('ID_Module_Class','=',$module_classes[0]->ID_Module_Class)->paginate(10));
    		return view ('fix.thongtin', ['module_classes' => $data, 'teacher' => $teacher ] );
    	}
    	else {
    		$query = "SELECT * FROM schedules ";
    		$item = 0;
    		foreach ($module_classes as $module_class) {
    		
				if($item == 0 ) {
					$query = $query." where ID_Module_Class = '".$module_class->ID_Module_Class."' ";
				}
				else {
					$query = $query." OR ID_Module_Class = '".$module_class->ID_Module_Class."' ";
				}
				$item ++;
    		}

    		$this->data = collect(DB::select(DB::raw($query)));
    		$page = 1;
			$size = 10;
			$paginationData = new LengthAwarePaginator(
			                         $this->data->forPage($page, $size),
			                         $this->data->count(), 
			                         $size, 
			                         $page,
			                         ['path' => url('admin/fix/getPaginate')]
			                       );
    		//dd($data);
    		return view ('fix.thongtin', ['module_classes' => $paginationData, 'teacher' => $teacher ]);
    	}
    }

    public function submitChange(Request $request) {
    	//dd($request);
    	$ID_Schedules = $request->inputSchedules;
    	// echo "Dayla: ".$ID_Schedules."<br />";
    	$inputDate = $request->inputDate;
    	$inputShift = $request->inputShift;
    	$inputTeacher = $request->inputTeacher;
    	$inputReason = $request->inputReason;

    	if($inputDate == null || $inputReason == null || $inputShift == null || $inputTeacher == null ) {
    		return back()->withErrors('Phải điền đầy đủ các trường');
    	}

    	//Kiểm tra xem lịch thay đổi có trùng không
    	//Lay id account nguoi dang nhap
    	$id = Auth::user()->id;
    	//Lấy id giảng viên
    	$id_teacher = DB::table("teacher")->where("ID","=",$id)->get();
    	foreach($id_teacher as $value => $res) {
    		$getID = $res->ID_Teacher;
    	}
    	//Kiểm tra
    	$module_classes = DB::table('module_class')->where('ID_Teacher','=', $getID)->get();
    	foreach($module_classes as $module_class) {
    		// print_r($module_class);
    		// echo "<br />";
    		$sch = DB::table('schedules')->where('ID_Module_Class','=',$module_class->ID_Module_Class)->get();
    		foreach ($sch as $key) {
    			print_r($key);
    			echo "<br />";
    			if($key->Day_Schedules == $inputDate and $key->Shift_Schedules == $inputShift) {
    				return back()->withErrors('Lỗi: Trùng lịch dạy: {'.$key->Day_Schedules.", ".$key->Shift_Schedules."}");
    			}
    		}
    	}

    	//Insert vào bảng fix
    	//Lấy thông tin lịch tình
    	//$currentSchedule = DB::table('schedules')->where('ID_Schedules','=',$ID_Schedules);
    	$current_date_time = Carbon::now()->toDateTimeString();
    	DB::table('fix')->insert(
			['ID_Schedules' => $ID_Schedules,
			 'Shift_Fix' => $inputShift,
			 'Day_Fix' => $inputDate,
			 'Time_Fix_Request' => $current_date_time,
			 'Status_Fix' => 'Đang chờ',
			 'ID_Teacher_Option' => $inputTeacher]
		);
		return back()->with('thongbao','Yêu cầu đang chờ được xử lý');
    }
}
