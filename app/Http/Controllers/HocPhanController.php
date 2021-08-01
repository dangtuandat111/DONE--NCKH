<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use App\models\modules;


class HocPhanController extends Controller
{
	//Get module data
    public static function getThongTin() {
    	
		$modules = DB::table('module')->where('ID_Module','like','MHT%')->Paginate(10);
		$credits = DB::select(DB::raw("SELECT DISTINCT Credit FROM module ORDER BY Credit asc"));
		$departments = DB::select(DB::raw("SELECT ID_Department,Department_Name FROM department"));
		$module = DB::select(DB::raw("SELECT DISTINCT ID_Module,Module_Name FROM module where ID_Department = 'MHT' "));

		return view ('modules.thongtin', ['modules' => $modules,'credits' => $credits,
											'module' => $module,'departments' => $departments] );
	}

	//Get fix data with varible id = ID_Module
	public function fixThongTin($id) {
		$modules = DB::table('module')->where('ID_Module','=', $id)->get();
		$departments = DB::table('department')->get();
		
		return view('modules.sua')->with(['modules' => $modules])->with(['department' => $departments]);
	}

	//Get add data
	public function addThongTin() {
		$departments = DB::table('department')->get();
		return view('modules.them', ['department' => $departments]);
	}

	//Post add data
	public function postAdd(Request $request) {
		//Check rules and send messages
		//Required
		$rules = [
	 	'inputID_module' => 'required|max:25',
        'inputSemester' =>'required|max:25',
        'inputCredits' =>'required',
        'inputModule_name' =>'required',
        'inputTheory' =>'required',
        'inputExercise' =>'required',
        'inputPractice' =>'required',
        'inputProject' =>'required',
        'inputID_department' =>'required'
    	];

    	$messages = [
        'inputSemester.required' => 'Kì học là trường bắt buộc',
        'inputID_module.required' => 'Mã học phần là trường bắt buộc',
        'inputCredits.required' => 'Số tín chỉ là trường bắt buộc',
        'inputModule_name.required' => 'Tên học phần là trường bắt buộc',
        'inputTheory.required' => 'Số tiết lý thuyểt là trường bắt buộc',
        'inputExercise.required' => 'Số tiết bài tập là trường bắt buộc',
        'inputPractice.required' => 'Số tiết thực hành là trường bắt buộc',
        'inputProject.required' => 'Số tiết bài tập lớn là trường bắt buộc',
        'inputID_department.required' => 'Bộ môn là trường bắt buộc'
    	];
	    $validator = Validator::make($request->all(), $rules, $messages);
	    
	    if($validator->fails()) {
	    	 return back()->withInput()->withErrors($validator);
	    }
	    else {
	    	//Handle check
	    	$temp = DB::table('module')->where('ID_Module' , $request->inputID_module)->count() ;
			if($temp >0 ) {
				return back()->withInput()->withErrors('Mã học phần đã tồn tại');
			}

			if(!is_numeric( $request->inputSemester ) or $request->inputSemester <1 or $request->inputSemester >8) {
				return Redirect::to('admin/hocphan/them')->withInput()->withErrors( 'Nhập lại kỳ học');
				//return back()->withInput()->withErrors( 'Nhập lại kỳ học');
			}
			if(!is_numeric( $request->inputTheory) ){
				return back()->withInput()->withErrors( 'Nhập lại số tiết lý thuyết');
			}
			if(!is_numeric( $request->inputExercise) ){
				return back()->withInput()->withErrors( 'Nhập lại số tiết bài tập');
			}
			if(!is_numeric( $request->inputPractice) ){
				return back()->withInput()->withErrors( 'Nhập lại số tiết thực hành');
			}
	    }

	    //Create new module
		$bm = new modules;
		$bm->ID_Module = $request->inputID_module;
		$bm->Semester = $request->inputSemester;
		$bm->Credit = $request->inputCredits;
		$bm->Module_Name = $request->inputModule_name;
		$bm->Theory = $request->inputTheory;
		$bm->Exercise = $request->inputExercise;
		$bm->Practice = $request->inputPractice;
		$bm->Project = $request->inputProject;
		$bm->ID_Department  = $request->inputID_department;
		$bm->save();
		return redirect('admin/hocphan/thongtin')->with('thongbao', 'Thêm thành công');
	}

	//Post fix data
	public function postFix(request $request){
		
		$rules = [
	 	'inputID_module' => 'required|max:25',
        'inputSemester' =>'required|max:25',
        'inputCredits' =>'required',
        'inputModule_name' =>'required',
        'inputTheory' =>'required',
        'inputExercise' =>'required',
        'inputPractice' =>'required',
        'inputProject' =>'required',
        'inputID_department' =>'required'
    	];

    	$messages = [
        'inputSemester.required' => 'Kì học là trường bắt buộc',
        'inputID_module.required' => 'Mã học phần là trường bắt buộc',
        'inputCredits.required' => 'Số tín chỉ là trường bắt buộc',
        'inputModule_name.required' => 'Tên học phần là trường bắt buộc',
        'inputTheory.required' => 'Số tiết lý thuyểt là trường bắt buộc',
        'inputExercise.required' => 'Số tiết bài tập là trường bắt buộc',
        'inputPractice.required' => 'Số tiết thực hành là trường bắt buộc',
        'inputProject.required' => 'Số tiết bài tập lớn là trường bắt buộc',
        'inputID_department.required' => 'Bộ môn là trường bắt buộc'
    	];
	    $validator = Validator::make($request->all(), $rules, $messages);
	    
	    if($validator->fails()) {
	    	 return back()->withInput()->withErrors($validator);
	    }
	    else {
	    	$temp = DB::table('module')->where('ID_Module' , $request->inputID_module)->count() ;
			if($temp >1 ) {
				return back()->withInput()->withErrors( 'Mã học phần đã tồn tại');
			}

			if(!is_numeric( $request->inputSemester ) or $request->inputSemester <1 or $request->inputSemester >8) {
				return Redirect::to('admin/hocphan/them')->withInput()->withErrors( 'Nhập lại kỳ học');
				//return back()->withInput()->withErrors( 'Nhập lại kỳ học');
			}
			if(!is_numeric( $request->inputTheory) ){
				return back()->withInput()->withErrors( 'Nhập lại số tiết lý thuyết');
			}
			if(!is_numeric( $request->inputExercise) ){
				return back()->withInput()->withErrors( 'Nhập lại số tiết bài tập');
			}
			if(!is_numeric( $request->inputPractice) ){
				return back()->withInput()->withErrors( 'Nhập lại số tiết thực hành');
			}
	    }

	    try {
	    	DB::table('module')->where('id_module', $id)->update(
				['semester' => $request->inputSemester,
				'credit' => $request->inputCredits,
				'module_name' => $request->inputModule_name,
				'theory' => $request->inputTheory,
				'exercise' => $request->inputExercise,
				'practice' => $request->inputPractice,
				'project' => $request->inputProject,
				'id_department' => $request->inputID_department]

			);
	    }catch(\Exception $e) {
	    	return redirect('admin/hocphan/thongtin')->withErrors($e->getMessage());
	    }
		
		return redirect('admin/hocphan/thongtin')->with('thongbao', 'Sửa thành công');
	}

	//XDelete data
	public function deleteThongTin($id) {
		DB::table('module')->where('ID_Module' , $id)->delete();
		return redirect('admin/hocphan/thongtin')->with('thongbao', 'Xóa học phần thành công');
	}

	//Filter ajax
	public function getFilter(Request $request) {
		if(request()->ajax()) {

	        $md = (!empty($_GET["md"])) ? ($_GET["md"]) : ('');
	        //$dp = (!empty($_GET["dp"])) ? ($_GET["dp"]) : ('');
	        $cd = (!empty($_GET["cd"])) ? ($_GET["cd"]) : ('');

        	$data = DB::table('module')->when($md,function($query,$md) {
        		return $query->where('ID_Module',$md);
        	})->when($cd,function($query,$cd) {
        		return $query->where('Credit',$cd);
        	})->where('ID_Department','=','MHT')->Paginate(10);
			
			return view('modules.moduleView')->with(['modules' => $data]);
		}
	}

}
