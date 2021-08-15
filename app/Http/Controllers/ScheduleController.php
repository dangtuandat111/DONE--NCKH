<?php

namespace App\Http\Controllers;

use App\Models\schedules;
use App\Models\Event;
use Illuminate\Http\Request;
use Redirect,Response;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
   //->where(' Day_Schedules',   '<=', $end)
class ScheduleController extends Controller
{

    public function getAll()
    {
       if(request()->ajax()) 
        {
        $data = DB::select("
          Select 
          concat(IFNULL(Name_Teacher, 0), ' ', Module_Name,' ') as title, 
          CASE 
          WHEN Shift_Schedules = 1 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 7 HOUR),INTERVAL 0 MINUTE) 
          WHEN Shift_Schedules = 2 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 9 HOUR),INTERVAL 35 MINUTE) 
          WHEN Shift_Schedules = 3 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 13 HOUR),INTERVAL 0 MINUTE) 
          WHEN Shift_Schedules = 4 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 15 HOUR),INTERVAL 35 MINUTE)
          WHEN Shift_Schedules = 5 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 18 HOUR),INTERVAL 05 MINUTE) 
          ELSE DATE_ADD(Day_Schedules, INTERVAL 0 HOUR) 
          END AS start, 

          CASE 
          WHEN teacher.ID_Teacher = '0172' THEN  '#D1D8FD'
          WHEN teacher.ID_Teacher = '0175' THEN  '#D5D6EA'
          WHEN teacher.ID_Teacher = '0849' THEN  '#F6F6EB'
          WHEN teacher.ID_Teacher = '0884' THEN  '#D7ECD9'
          WHEN teacher.ID_Teacher = '0896' THEN  '#F5D5CB'
          WHEN teacher.ID_Teacher = '1207' THEN  '#F6ECF5'
          WHEN teacher.ID_Teacher = '1268' THEN  '#F3DDF2'
          WHEN teacher.ID_Teacher = '1387' THEN  '#FFEFCF'
          WHEN teacher.ID_Teacher = '1406' THEN  '#F6F5F0'
          WHEN teacher.ID_Teacher = '1614' THEN  '#D8F0FA'
          WHEN teacher.ID_Teacher = '1634' THEN  '#EFB6BC'

          ELSE '#05f78a'
          END AS backgroundColor,

          CASE 
          WHEN Shift_Schedules = 1 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 9 HOUR),INTERVAL 30 MINUTE) 
          WHEN Shift_Schedules = 2 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 12 HOUR),INTERVAL 05 MINUTE) 
          WHEN Shift_Schedules = 3 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 15 HOUR),INTERVAL 30 MINUTE) 
          WHEN Shift_Schedules = 4 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 18 HOUR),INTERVAL 05 MINUTE)
          WHEN Shift_Schedules = 4 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 21 HOUR),INTERVAL 05 MINUTE) 
          ELSE DATE_ADD(Day_Schedules, INTERVAL 0 HOUR) 
          END AS end
        from 
          schedules 
          inner join module_class on module_class.ID_Module_Class = schedules.ID_Module_Class 
          inner join module on module.ID_Module = module_class.ID_Module
          inner join teacher on teacher.ID_Teacher = module_class.ID_Teacher
        where 
          schedules.ID_Module_Class like 'MHT%' 
          and module_class.ID_Teacher IS NOT NULL

        ");
         
        return Response::json($data);
       
        }
        return view('calendar.fullcalendar');
    }

    public function getOne() {
      $id = Auth::user()->id ;
      $id_teacher = DB::table('teacher')->where('ID_Account','=',$id)->get('ID_Teacher');
      $id_teacher = $id_teacher[0]->ID_Teacher;

      //return Response::json($id);
      if(request()->ajax()) 
        {
        $data = DB::select("
          Select 
          concat(Module_Name,' ', ID_Room ) as title, 
          CASE 
          WHEN Shift_Schedules = 1 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 7 HOUR),INTERVAL 0 MINUTE) 
          WHEN Shift_Schedules = 2 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 9 HOUR),INTERVAL 35 MINUTE) 
          WHEN Shift_Schedules = 3 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 13 HOUR),INTERVAL 0 MINUTE) 
          WHEN Shift_Schedules = 4 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 15 HOUR),INTERVAL 35 MINUTE)
          WHEN Shift_Schedules = 5 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 18 HOUR),INTERVAL 10 MINUTE)
          ELSE DATE_ADD(Day_Schedules, INTERVAL 20 HOUR) 
          END AS start, 

          CASE 
          WHEN teacher.ID_Teacher = '0172' THEN  '#D1D8FD'
          WHEN teacher.ID_Teacher = '0175' THEN  '#D5D6EA'
          WHEN teacher.ID_Teacher = '0849' THEN  '#F6F6EB'
          WHEN teacher.ID_Teacher = '0884' THEN  '#D7ECD9'
          WHEN teacher.ID_Teacher = '0896' THEN  '#F5D5CB'
          WHEN teacher.ID_Teacher = '1207' THEN  '#F6ECF5'
          WHEN teacher.ID_Teacher = '1268' THEN  '#F3DDF2'
          WHEN teacher.ID_Teacher = '1387' THEN  '#FFEFCF'
          WHEN teacher.ID_Teacher = '1406' THEN  '#F6F5F0'
          WHEN teacher.ID_Teacher = '1614' THEN  '#D8F0FA'
          WHEN teacher.ID_Teacher = '1634' THEN  '#EFB6BC'

          ELSE '#05f78a'
          END AS backgroundColor,

          CASE 
          WHEN Shift_Schedules = 1 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 9 HOUR),INTERVAL 30 MINUTE) 
          WHEN Shift_Schedules = 2 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 12 HOUR),INTERVAL 05 MINUTE) 
          WHEN Shift_Schedules = 3 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 15 HOUR),INTERVAL 30 MINUTE) 
          WHEN Shift_Schedules = 4 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 18 HOUR),INTERVAL 05 MINUTE)
          WHEN Shift_Schedules = 4 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 25 HOUR),INTERVAL 10 MINUTE) 
          ELSE DATE_ADD(Day_Schedules, INTERVAL 20 HOUR) 
          END AS end
        from 
          schedules 
          inner join module_class on module_class.ID_Module_Class = schedules.ID_Module_Class 
          inner join module on module.ID_Module = module_class.ID_Module
          inner join teacher on teacher.ID_Teacher = module_class.ID_Teacher
        where 
          schedules.ID_Module_Class like 'MHT%' 
          and module_class.ID_Teacher IS NOT NULL
          and teacher.ID_Teacher = '".$id_teacher." '

        ");
         
        return Response::json($data);
       
        }
        return view('calendar.calendar');
    }

    public function testGet()
    {
       if(request()->ajax()) 
        {
        $data = DB::select("
          Select 
          concat(IFNULL(Name_Teacher, 0), ' ', Module_Name,' ', IFNULL(ID_Room, 0)) as title, 
          CASE 
          WHEN Shift_Schedules = 1 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 7 HOUR),INTERVAL 0 MINUTE) 
          WHEN Shift_Schedules = 2 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 9 HOUR),INTERVAL 35 MINUTE) 
          WHEN Shift_Schedules = 3 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 13 HOUR),INTERVAL 0 MINUTE) 
          WHEN Shift_Schedules = 4 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 15 HOUR),INTERVAL 35 MINUTE) 
          ELSE DATE_ADD(Day_Schedules, INTERVAL 0 HOUR) 
          END AS start, 

          CASE 
          WHEN Shift_Schedules = 1 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 9 HOUR),INTERVAL 30 MINUTE) 
          WHEN Shift_Schedules = 2 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 12 HOUR),INTERVAL 05 MINUTE) 
          WHEN Shift_Schedules = 3 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 15 HOUR),INTERVAL 30 MINUTE) 
          WHEN Shift_Schedules = 4 THEN DATE_ADD(DATE_ADD(Day_Schedules, INTERVAL 18 HOUR),INTERVAL 05 MINUTE) 
          ELSE DATE_ADD(Day_Schedules, INTERVAL 0 HOUR) 
          END AS end
        from 
          schedules 
          inner join module_class on module_class.ID_Module_Class = schedules.ID_Module_Class 
          inner join module on module.ID_Module = module_class.ID_Module
          inner join teacher on teacher.ID_Teacher = module_class.ID_Teacher
        where 
          schedules.ID_Module_Class like 'MHT%' 
          and module_class.ID_Teacher IS NOT NULL

        ");
         
        return Response::json($data);
       
        }
        return view('calendar.testCalendar');
    }
    
}
