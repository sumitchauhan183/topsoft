<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Classes\Email;
use Exception;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return "Wrong page";
    }

    public function checkEmail(Request $request)
    {
        $input = $request->all();
        if(isset($input['email'])):
            $check = Admin::where('email',$input['email'])->count();
            if($check>0):
                return json_encode([
                    'error'=>false
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>'This email is not authorised for Administrative use'
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>'Email id is required'
            ]);
        endif;
    }

    public function update(Request $request)
    {
        $input     = $request->all();
        $data = [
            "name"  => $input["name"],
            "email" => $input["email"]
        ];
        if($input['is_password']!="false"){
            $data['password'] = Hash::make($input["password"]);
        }
        try{
            Admin::where('admin_id',1)->update($data);
            return json_encode([
                'error'=>false,
                'message'=>'profile updated successfully.'
            ]);
        }catch(Exception $e){
            return json_encode([
                'error'=>true,
                'message'=>'Exception occured.',
                'exception'=> $e
            ]);
        }

    }

    public function login(Request $request)
    {
        $input = $request->all();
        $email  = Admin::where('email',$input['email'])->count();
        if($email<1):
            return json_encode([
                'error'=>true,
                'message'=>'Email id not exist'
            ]);
        endif;
        $check = Admin::where('email',$input['email'])
                ->get()->first()->toArray();
        if(Hash::check($input['password'], $check['password'])):
            $admin_id = $check['admin_id'];

            $token = $this->generateToken($admin_id);
            Admin::where('admin_id',$admin_id)->update(['login_token'=>$token]);
            $admin = Admin::where('admin_id',$admin_id)
                ->get()->first()->toArray();
            session()->put('admin',[
                "type"=>'admin',
                "data"=>$admin,
                "token" => $token
            ]);

            return json_encode([
                'error'=>false,
                'message'=>'Login Successful',
                'admin_id'=> $admin_id,
                'token'=> $token
            ]);
        else:
            return json_encode([
                'error'=>true,
                'message'=>'Please check your password'
            ]);
        endif;
    }



    private function generateToken($admin_id)
    {
        $token = md5($admin_id.time());
        Admin::where('admin_id',$admin_id)
                ->update(['login_token'=>$token]);
        return $token;
    }


}
