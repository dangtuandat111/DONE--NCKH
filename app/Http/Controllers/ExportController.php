<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Exports\FileExport;
use App\Exports\GiangVienExport;

class ExportController extends Controller
{
    //
    public function postTeacher() {
    	$export = new GiangVienExport();

        return Excel::download($export, 'giangvien.xlsx');
    }

    

    public function postThongKe(Request $request) {
    	$i = 0 ; 
    	$month = 0;
        //Kiem tra co month
    	foreach($request->request as $data) {
    		if($i==1) {$month = $data; break;}
    		$i++;
    	}
    	$month = (int)$month;
    	//dd($month);
    	$export = new FileExport($month);

    	return Excel::download($export, 'export.xlsx');
    	//return back();
    }
}
