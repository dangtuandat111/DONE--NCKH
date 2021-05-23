<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\models\teacher;
use App\models\User;
use App\models\department;
use Illuminate\Support\Facades\Hash;

class GiangVienController extends Controller
{
    //
    public function getThongTin() {
    	$teachers = DB::table('teacher')->where('IS_Delete', 0)->Paginate(10);
        $id_teacher = DB::table('teacher')->get();
        $departments = DB::table('department')->get();

		return view ('teacher.thongtin', ['teachers' => $teachers, 'id_teacher' => $id_teacher, 'departments' => $departments ] );
    }

    public function addThongTin() {
    	$departments = DB::table('department')->get();
		return view('teacher.them', ['department' => $departments]);
    }

    public function fixThongTin($id) {
        $teachers = DB::table('teacher')->where('ID_Teacher','=', $id)->get();
        $departments = DB::table('department')->get();
        
        return view ('teacher.sua', ['teachers' => $teachers] , ['department' => $departments]);
    }

    public function postAdd(Request $request) {
    	//Kiem tra

    	$rules = [
    		'inputTeacher_name' => 'required|max:50',
            'inputID_Teacher' => 'required',
    		'inputPermission' => 'required',
    		'inputEmail_Teacher' => 'required|email',
    		'inputPassword_Teacher' => 'required',
    		'inputDoB_Teacher' => 'required',
    		'inputID_Department' => 'required',
            'inputPhone_number' => 'required|max:10'
    	];

    	$messages = [
    		'inputTeacher_name.required' => 'Tên giảng viên là bắt buộc',
            'inputID_Teacher.required' => 'Mã giảng viên là bắt buộc',
    		'inputPhone_number.required' => 'Số điện thoại là  bắt buộc',
    		'inputPermission.required' => 'Phân quyền là bắt buộc',
    		'inputEmail_Teacher.required' => 'Email là bắt buộc',
    		
    		'inputPassword_Teacher.required' => 'Mật khẩu là bắt buộc',
    		'inputDoB_Teacher.required' => 'Ngày sinh là bắt buộc',
    		'inputID_Department.required' => 'Bộ môn là bắt buộc',

    		'inputTeacher_name.max' => 'Tên giảng viên tối đa 50 kí tự',
            'inputPhone_number.regex' => 'Số điện thoại không đúng',
    		'inputPhone_number.max' => 'Số điện thoại tối đa 10 số',
    		'inputEmail.email' => 'Địa chỉ email không đúng',
    		'inputUser.max' => 'Tên người dùng tối đa 50 kí tự',
    		'inputPassword.max' => 'Mật khẩu có độ dài không quá 200 kí tự',
    		
    	];

    	$validator = Validator::make($request->all(), $rules, $messages);
	    
	    if($validator->fails()) {
	    	 return back()->withInput()->withErrors($validator);
	    }
       $temp = DB::table('teacher')->where('ID_Teacher' , $request->inputID_Teacher)->count() ;
        if($temp >0 ) {
            return back()->withInput()->withErrors( 'Mã giảng viên đã tồn tại');
        }

        if($request->inputPermission == "Admin") {
            $request->inputPermission = 1;
        }
        else if ($request->inputPermission == "Phòng đào tạo") {
            $request->inputPermission =2;
        }
        else if ($request->inputPermission == "Giảng viên" ) {   
            $request->inputPermission = 0;
        }
        else {
             return back()->withInput()->withErrors('Chọn lại phân quyền');
        }

        // DB::table('account')->insert([
        //     'username' => $request->inputTeacher_name,
        //     'email' => $request->inputEmail_Teacher,
        //     'password' => bcrypt($request->inputPassword_Teacher),
        //     'permission' => $request->inputPermission,
        // ]);

        try {
            $acc = new User();
            $acc->username = $request->inputTeacher_name;
            $acc->email = $request->inputEmail_Teacher;
            $acc->password = bcrypt($request->inputPassword_Teacher);
            $acc->permission = $request->inputPermission;
            $acc->save();
         }catch(QueryException $e) {
            return back()->withInput()->withErrors('Lỗi thêm tài khoản');
        }

	    $gv = new teacher();
	    $gv->ID_Teacher = $request->inputID_Teacher;
	    $gv->Name_Teacher = $request->inputTeacher_name;
	    $gv->Phone_Teacher = $request->inputPhone_number;
	    $gv->Email_Teacher = $request->inputEmail_Teacher;
	    $gv->IS_Delete = 0;
	    $gv->University_Teacher_Degree = $request->inputTeacher_Rank;
	    $data = Carbon::createFromFormat('Y-m-d', $request->inputDoB_Teacher)->format('Y-m-d');
	    $gv->DoB_Teacher = $data;
	    $gv->ID_Department  = $request->inputID_Department;
        $gv->ID = $acc->id;
	    $gv->save();
       


	    return redirect('admin/teacher/thongtin')->with('thongbao', 'Thêm giảng viên thành công');
    }



    public function postFix(request $request){
        $rules = [
            'inputName_Teacher' => 'required|max:50',
            'inputID_Teacher' => 'required',
            'inputPhone_Teacher' => 'required|max:10',
            'inputPermission' => 'required',
            'inputEmail_Teacher' => 'required|email',
            'inputDoB_Teacher' => 'required',
            'inputID_Department' => 'required'
        ];

        $messages = [
            'inputName_Teacher.required' => 'Tên giảng viên là bắt buộc',
            'inputID_Teacher.required' => 'Mã giảng viên là bắt buộc',
            'inputPhone_Teacher.required' => 'Số điện thoại là  bắt buộc',
            'inputPermission.required' => 'Phân quyền là bắt buộc',
            'inputEmail_Teacher.required' => 'Email là bắt buộc',
            
            'inputDoB_Teacher.required' => 'Ngày sinh là bắt buộc',
            'inputID_Department.required' => 'Bộ môn là bắt buộc',

            'inputName_Teacher.max' => 'Tên giảng viên tối đa 50 kí tự',
            'inputPhone_Teacher.max' => 'Số điện thoại chưa đúng format',
            'inputEmail_Teacher.email' => 'Địa chỉ email không đúng',
           

        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()) {
             return back()->withErrors($validator);
        }
        else {
            if($request->inputPassword == null) {
                $pass = DB::table('teacher')->where('ID_Teacher',$request->inputID_Teacher)->get();
                $request->inputPassword = $pass;
            }

            if($request->inputPermission == "Admin") {
                $request->inputPermission = 4; // Bo mon
            }
            else if ($request->inputPermission == "Phòng đào tạo") {
                $request->inputPermission =2; //Phong dao tao
            }
            else $request->inputPermission = 1; // Giang vien
        }
       

        $id = $request->inputID_Teacher;
        DB::table('teacher')->where('ID_Teacher', $id)->update(
            ['Name_Teacher' => $request->inputName_Teacher,
            'ID_Teacher' =>$request->inputID_Teacher,
            'Phone_Teacher' => $request->inputPhone_Teacher,
            'Email_Teacher' => $request->inputEmail_Teacher,
            'DoB_Teacher' => $request->inputDoB_Teacher,
            'ID_Department' => $request->inputID_Department]
        );
        return redirect('admin/teacher/thongtin')->with('thongbao', 'Sửa thành công');
    }

    public function deleteThongTin($id) {
       DB::table('teacher')->where('ID_Teacher' , $id)->update(
        [
            'IS_Delete' => 1
        ]);

        return redirect('admin/teacher/thongtin')->with('thongbao', 'Xóa giảng viên thành công');
    }
}
