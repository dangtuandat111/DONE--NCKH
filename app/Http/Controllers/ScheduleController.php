<?php

namespace App\Http\Controllers;

use App\Models\schedules;
use App\Models\Event;
use Illuminate\Http\Request;
use Redirect,Response;
use DB;
use Carbon\Carbon;
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

    public function test() {
      // $start = Carbon::createFromFormat('Y-m-d', '2021-01-03');
      // $end = Carbon::createFromFormat('Y-m-d', '2020-01-03');
        //if(request()->ajax()) {
            $start = '2020-012-03';
            $end = '2021-01-03';
             //$query = "Select ID_Schedules as id, ID_Module_Class as title, Day_Schedules as start, Day_Schedules as end From schedules ";
            $query = "Select ID_Schedules as id, ID_Module_Class as title, Day_Schedules as start, Day_Schedules as end From schedules ";
             if(1 == 1 ){
                $query = $query." where Day_Schedules >= '".$start."' and Day_Schedules <= '".$end."'";
             }
             echo $query;
            $data = DB::select(DB::raw($query));

           dd($data);
           
           // return Response::json($data);
       // }
       // return view('calendar.calendar');
    }

    public function getOne() {
        return view('calendar.calendar');
    }
    
}
