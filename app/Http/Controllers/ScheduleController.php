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
 
         $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
         $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
            
         $data = DB::table('schedules')->select(DB::raw('ID_Schedules as id, ID_Module_Class as title, Day_Schedules as start, Day_Schedules as end'))->where('Day_Schedules', '>=', $start)->where('Day_Schedules',   '<=', $end)->get();
         
        return Response::json($data);
       
        }
        return view('calendar.fullcalendar');
    }

    public function getOne() {
      $id = Auth::user()->id ;
      $id_teacher = DB::table('teacher')->where('ID','=',$id)->get('ID_Teacher');
      if(request()->ajax()) 
        {
 
         $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
         $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');

       $data = DB::select(DB::raw(" SELECT schedules.ID_Schedules as id, CONCAT(module_class.ID_Module,'.Phòng:' , schedules.ID_Room,'.Ca:', schedules.Shift_Schedules) as title, schedules.Day_Schedules as start, schedules.Day_Schedules as end from  schedules inner join module_class on schedules.ID_Module_Class = module_class.ID_Module_Class where  Day_Schedules >= '".$start."' and Day_Schedules <= '".$end." ' and ID_Teacher = '".$id_teacher[0]->ID_Teacher."'"));

        return Response::json($data);
       
       }
        return view('calendar.calendar');
    }
    
}
