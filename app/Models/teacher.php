<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class teacher extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "teacher";
    public $timestamps = false;
    
    protected $fillable = [
          
        'Email_Teacher',
        'Password_Teacher',
      
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'Password_Teacher',
        //'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

}
