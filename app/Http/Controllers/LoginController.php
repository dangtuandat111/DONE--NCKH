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

use Illuminate\Support\Facades\Mail;
class LoginController extends Controller
{
    //Ham de goi trang login trong thu muc admin
    public $email ;
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
                    
                    return view('admin.login')->withErrors("Email hoặc mật khẩu không đúng");
                  
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

    public function resetPass(Request $request) {
        if($request->isMethod('post')){
            $rules = [
                'Email' =>'required|email|max:255', // chi gom chu hoac so va khong ket thuc bang so
                'Old_Password' => 'required|min:1|regex:/(^([a-zA-z\d]+)(\d+)?$)/',
                'Password' => 'required|min:1|regex:/(^([a-zA-z\d]+)(\d+)?$)/',
                'Confirm_Password' => 'required|min:1|regex:/(^([a-zA-z\d]+)(\d+)?$)/|same:Password'
            ];
            $messages = [
                'Email.required' => 'Email là trường bắt buộc',
                'Email.max' => 'Tên email không quá 255 ký tự',
                'Email.email' => 'Email không đúng định dạng',

                'Old_Password.required' => 'Mật khẩu là trường bắt buộc',
                'Old_Password.min' => 'Mật khẩu phải chứa ít nhất 1 ký tự',
                'Old_Password.regex' => 'Mật khẩu không đúng định dạng',

                'Password.required' => 'Mật khẩu là trường bắt buộc',
                'Password.min' => 'Mật khẩu phải chứa ít nhất 1 ký tự',
                'Password.regex' => 'Mật khẩu không đúng định dạng',

                'Confirm_Password.required' => 'Mật khẩu là trường bắt buộc',
                'Confirm_Password.min' => 'Mật khẩu phải chứa ít nhất 1 ký tự',
                'Confirm_Password.regex' => 'Mật khẩu không đúng định dạng',
                'Confirm_Password.same' => 'Mật khẩu không khớp'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            
            
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                if ( $this->check($request->Email,$request->Old_Password) ) {
                    $this->sendMail($request->Email);
                    DB::table('account')->where('email',$request->Email)->update([
                        'password' => bcrypt($request->Password)
                    ]);
                    return redirect('/login');
                  
                } else {
                    return back()->withInput()->withErrors("Email hoặc mật khẩu không đúng");
                  
                }
                
            }
        }
        else return view('admin.resetPassword');
    }

     public function sendMail($mail) {
        $this->email = $mail;

        Mail::send('resetpassword',['id' => $this->email,'name' => $this->email],function($message) {
            //Lấy địa chỉ email của người dùng
            $message->to($this->email,'');
            //Chưa check xem mail có tồn tại hay không
            $message->subject('Thay đổi mật khẩu');
        });

        if( count(Mail::failures()) > 0) {
            $error = '';

            foreach(Mail::failures() as $email_address) {
               $error = $error." - ".$email_address." <br />";
            }
            return $error;
        }
        return 'Thành công';
    }

    public function check($email,$pass) {
        $value = DB::table('account')
        ->where('email' ,'=', $email)->get();
        $count = DB::table('account')
        ->where('email' ,'=', $email)->count();
        //dd( $value);
        if($count == 0 ) return false;
        if(Hash::check($pass, $value[0]->password)) {
            return true;
        }

        return false;
    }
}


