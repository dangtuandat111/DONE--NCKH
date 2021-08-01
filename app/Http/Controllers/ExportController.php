<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Exports\FileExport;

class ExportController extends Controller
{
    //
    public function postTeacher() {
    	$filename = "MAU_THEM_GIANGVIEN.xlsx";
	    	 // Get path from storage directory
	    $path = app_path('File_Export\\'.$filename);
        
	    // Download file with custom headers
	    return response()->download($path, $filename, [
	        'Content-Type' => 'application/vnd.ms-excel',
	        'Content-Disposition' => 'inline; filename="' . $filename . '"'
	    ]);
    }

    

    public function postThongKe(Request $request) {
    	$i = 0 ; 
    	$month = 0;
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
