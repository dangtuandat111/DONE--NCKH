<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Carbon\Carbon;
use DateTime;
use DB;
Use Exception;
use App\models\modules;
use App\models\module_class;
use App\models\teacher;
use App\models\schedules;
use App\models\rooms;
use Illuminate\Support\Str;


class teacherImport implements ToCollection
{
	public $i = 3;
	public $numberInsertedValue = 0;
	public function collection(Collection $collection)
    {
    	$error = '';
    	foreach($collection as $item) {
	    	if($this->i >0  ) {
	    		$this->i --;
	    		continue;
	    	}
	    	print_r($item);
	    	echo "<br />";
	    	try {
		    	$id_teacher = $item[0];
		    	$name_teacher = $item[1];
		    	$DoB_teacher = $item[2];
		    	$DoB_teacher = date('Y-m-d',strtotime($DoB_teacher));
		    	$phone_teacher = $item[3];
		    	$degree_teacher = $item[4];
		    	$permission_teacher = $item[5];
		    	$pass = $item[6];
		    	$email = $item[7];
		    	$dp = $item[8];
	    	}catch (Exception $e) {
	    		$error = 'Lỗi dữ liệu nhập';
	    		break;
	    	}

	    	try {
	    		//echo "da vao";
	    		DB::table('teacher')->insert([
	    			'ID_Teacher' => $id_teacher,
	    			'Name_Teacher' => $name_teacher,
	    			'DoB_Teacher' => $DoB_teacher,
	    			'Phone_Teacher' => $phone_teacher,
	    			'University_Teacher_Degree' => $degree_teacher,
	    			'Email_Teacher' => $email,
	    			'ID_Department' => $dp,
	    			'ID_Account' => null,
	    			'Is_Delete' => 0,
	    		]);
	    		$this->numberInsertedValue ++;
	    		//echo "da ra";
	    	}catch (Exception $e) {
	    		$error = 'Lỗi khi thêm giảng viên';
	    		break;
	    	}

    	}
    	if(!empty($error)) {
            return back()->withErrors($error)->with('thongbao','Số trường thêm thành công: '.$this->numberInsertedValue);
        }
    	else return back()->with('thongbao','Số trường thêm thành công: '.$this->numberInsertedValue);
    }
}
