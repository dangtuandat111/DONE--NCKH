<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;	
//use DB;
//use Session;
use App\models\modules;
use Maatwebsite\Excel\Concerns\ToModel;
//use Redirect,Response;
//use Excel;
use App\Imports\ScheduleImport;
use App\Imports\UserImport;
use App\Imports\teacherImport;
use Validator;

use Excel;
use Session;

class importController extends Controller
{
    //
    public function getModules_Class(){
    	return view('import.importModule_Class');
    }

    public function getModules() {
        return view('import.importModule');
    }

    public function getTeachers() {
        return view('import.importTeacher');
    }

     public function getRoom() {
        return view('import.importRoom');
    }

    public function postTeachers(Request $request) {
            $import = new teacherImport();
            
            $rules = [
                'giangvien' =>'required|max:5000|mimes:xlsx,xls,csv',
                
            ];

            $messages = [
                'giangvien.required' => 'Chưa chọn file',
                'giangvien.mimes' => 'Yêu cầu file là: xlxs, xls, csv'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()) {
                return back()->withErrors($validator);

            }

            try {
           
                Excel::import($import,$request->giangvien);
            }catch(Exception $ex) {
               return Redirect('admin/import/giangvien')->withErrors($ex->getMessage());
            }
            // return Redirect('admin/import/giangvien')->withErrors("Lỗi");
            //return back()->with('thongbao',' Them thanh cong');
           
    }

    public function postRoom() {
        echo "da vao";
    }

    public function postModules_Class(Request $request) {
    	$import = new ScheduleImport();
    	
        $rules = [
            'lophocphan' =>'required|max:5000|mimes:xlsx,xls,csv',
            
        ];

        $messages = [
            'lophocphan.required' => 'Chưa chọn file',
            'lophocphan.mimes' => 'Yêu cầu file là: xlxs, xls, csv'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return back()->withError($validator);

        }
        try {
           
            Excel::import($import,$request->lophocphan);
            
        }catch(Exception $ex) {
           return Redirect('admin/import/lophocphan')->withErrors($ex->getMessage());
        }
         return back()->with('thongbao',' Them thanh cong');
   	   
    }
}