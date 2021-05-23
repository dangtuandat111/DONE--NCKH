<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modules extends Model
{
    use HasFactory;
     protected $table = "module";
     public $timestamps = false;

     public function getAll() {
     	return DB::table('modules')->get();
     }

}
