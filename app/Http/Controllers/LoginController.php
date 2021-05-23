<?php

namespace App\Http\Controllers;

use App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Session;
use DB;
use Illuminate\Database\MySqlConnection;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class LoginController extends Controller
{
    //Ham de goi trang login trong thu muc admin
	public function index(Request $request) {
        if($request->isMethod('post')){
            // Kiểm tra dữ liệu nhập vào
            $rules = [
                'email' =>'required|email|max:255', // chi gom chu hoac so va khong ket thuc bang so
                'password' => 'required|min:1|regex:/(^([a-zA-z\d]+)(\d+)?$)/'
            ];
            $messages = [
                'email.required' => 'Email là trường bắt buộc',
                'email.max' => 'Tên email không quá 255 ký tự',
                'email.email' => 'Email không đúng định dạng',
                'email.regex' => 'Email không đúng định dạng',
                'password.required' => 'Mật khẩu là trường bắt buộc',
                'password.min' => 'Mật khẩu phải chứa ít nhất 1 ký tự',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            
            
            if ($validator->fails()) {
                
                return redirect('login')->withErrors($validator)->withInput();
            } else {

                if (Auth::attempt(['email' => $request->input("email"), 'password' => $request->input("password")])) {
                    
                    return redirect('/home');
                  
                } else {
                    
                    return view('admin.login')->withErrors("Email or password is not correct");
                  
                }
                
            }
        }
		else return view('admin.login');
	}

    public function home() {
        return view('admin.home');
    }

	//Ham xu ly dang nhap 
	public function postLogin()
    {

        
    }

    public function getHome() {
        return view('admin.home');
    }

    public function Logout() {
        if(Auth::logout()) {
            return Redirect::to('/login');
        };
        return redirect('/login');
    }


}


