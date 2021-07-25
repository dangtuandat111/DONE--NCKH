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

     public function postRoom() {
    	$filename = "MAU_THEM_PHONGHOC.xlsx";
	    	 // Get path from storage directory
	    $path = app_path('File_Export\\'.$filename);

	    // Download file with custom headers
	    return response()->download($path, $filename, [
	        'Content-Type' => 'application/vnd.ms-excel',
	        'Content-Disposition' => 'inline; filename="' . $filename . '"'
	    ]);
    }

     public function postModules() {
    	$filename = "MAU_THEM_HOCPHAN.xlsx";
	    	 // Get path from storage directory
	    $path = app_path('File_Export\\'.$filename);

	    // Download file with custom headers
	    return response()->download($path, $filename, [
	        'Content-Type' => 'application/vnd.ms-excel',
	        'Content-Disposition' => 'inline; filename="' . $filename . '"'
	    ]);
    }

    public function postThongKe() {
    	Excel::create('Filename', function($excel) {

		})->export('xlsx');
    }
}
