<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Event;	
//use DB;
//use Session;
use App\models\modules;
use Maatwebsite\Excel\Concerns\ToModel;
//use Redirect,Response;
//use Excel;
use App\Imports\ScheduleImport;
use App\Imports\teacherImport;
use App\Imports\newImport;
use Validator;

use Maatwebsite\Excel\Exceptions;
use Excel;
use Session;
use DB;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;


class importController extends Controller
{
    //Phat trien them
    public function getModules_Class(){
    	return view('import.importModule_Class');
    }

    // public function getModules() {
    //     return view('import.importModule');
    // }

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

            Excel::import($import,$request->giangvien);
            
            // return Redirect('admin/import/giangvien')->withErrors("Lỗi");
            //return back();
           
    }

    public function postRoom(Request $request) {
        $import = new newImport();
        Excel::import($import,$request->hocphan);
    }

    public function postModules_Class(Request $request) {
        //dd($request);

        if(!$request->hasFile('lophocphan')) {
            return back()->withError('Lỗi file');
        }

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
            return back()->withErrors($validator);

        }
        $import->onlySheets('CPM','MHT','KHM','CNT');
        
        Excel::import($import,$request->lophocphan);
        return back();
    }

    //Phát triển thêm
    // public function getCheck(Request $request) {
    //     if(count($request->request) != 2) {
    //         $data = [
    //         'Tình trạng' => "Có lỗi: ",
    //         ];
    //         return Response::json($data);
    //     };

    //     $stt = 1;
    //     foreach($request->request as $info) {
    //         if($stt == 1) {
    //             $NH = $info;
    //             $stt++;
    //         }
    //         else {
    //             $DH = $info;
    //             break;
    //         }
    //     }
    //     if($DH == 1) {
    //         $schedule = $NH;
    //     }
    //     else $schedule = $NH.".".$DH;
    //     echo $schedule;
    //     $count = DB::table('schedules')->where('ID_Module_Class','LIKE', '%'.$schedule.'%')->count();
    //     if($count > 0) {
    //         $success = [
    //             'Tình trạng' => "Đã tồn tại ",
    //         ];
    //     }
    //     $success = [
    //         'tình trạng' => "thành công",
    //     ];
    //     echo "<br />".$count;
    //     //return Response::json($data);
    // }

}