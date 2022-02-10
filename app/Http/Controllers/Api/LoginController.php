<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Devices;
use App\Models\Licences;
use Illuminate\Support\Facades\Hash;
use App\Classes\Email;
use Exception;
use PharIo\Manifest\License;

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


    public function login(Request $request)
    {
        $input = $request->all();
        $required = $this->checkRequiredParams($input,[
            'email','password','company_id','unique_token','device_token','type'
        ]);
        if(!$required):
            $email  = Devices::where('email',$input['email'])->count();
            if($email):
                $check = Devices::where('email',$input['email'])
                    ->get()->first()->toArray();
                    if(Hash::check($input['password'], $check['password'])):
                        $company_id = $input['company_id'];
                        $licences = Licences::where('company_id',$company_id)->get()->first()->toArray();
                        if(count($licences) && $licences['expiration_date'] >= date('Y-m-d')):
                            $token = $this->updateToken($input,$check['device_id']);
                            if($token):
                                return json_encode([
                                    'error'=>false,
                                    'message'=>'Logged in succesfully',
                                    'token'  => $token,
                                    'data'   =>$check,
                                    'code'   =>200
                                ]); 
                            else:
                                return json_encode([
                                    'error'=>true,
                                    'message'=>'Licence devices limit reached. Please contact Admin',
                                    'code'=>201
                                ]); 
                            endif;
                        else:
                            return json_encode([
                                'error'=>true,
                                'message'=>'Licence expired or not created yet. Please contact Admin',
                                'code'=>201
                            ]); 
                        endif;
                    else:
                        return json_encode([
                            'error'=>true,
                            'message'=>'Please check your password',
                            'code'=>201
                        ]); 
                    endif; 
            else:    
                return json_encode([
                    'error'=>true,
                    'message'=>'Email id not exist',
                    'code'=>201
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'code'=>201
            ]);
        endif;
        
    }

    public function forgotPasswordSendOtp(Request $request){
        $input = $request->all();
        $required = $this->checkRequiredParams($input,[
            'email'
        ]);
        if(!$required):
            $check = Devices::where('email',$input['email'])->get()->count();
            if($check):
                $otp = rand(100000,999999);
                Devices::where('email',$input['email'])->update([
                    'otp'=>$otp
                ]);
                Email::sendOtpMail("Agent",$input['email'],'Forget password OTP','Agent',"Please do not share otp $otp with any one.");
                return json_encode([
                    'error'=>false,
                    'message'=>"OTP sent successfully.",
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Please check email.",
                    'code'=>201
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'code'=>201
            ]);
        endif;
    }

    public function forgotPasswordReset(Request $request){
        $input = $request->all();
        $required = $this->checkRequiredParams($input,[
            'email','password','otp'
        ]);
        if(!$required):
            $check = Devices::where('email',$input['email'])->get()->count();
            if($check):
                $checkotp = Devices::where('email',$input['email'])
                                  ->where('otp',$input['otp'])->get()->count();
                if($checkotp):
                    Devices::where('email',$input['email'])
                                  ->where('otp',$input['otp'])->update([
                                        'password'=>Hash::make($input['password'])
                                  ]);
                    return json_encode([
                        'error'=>false,
                        'message'=>"Password updated successfully.",
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"invalid otp.",
                        'code'=>201
                    ]);
                endif;                  
               
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Please check email.",
                    'code'=>201
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'code'=>201
            ]);
        endif;
    }


   private function updateToken($input,$device_id){
                  
        $token = $this->generateToken($input['device_token']);  
                 
            Devices::where('device_id',$device_id)
                        ->update([
                            'device_token'=>$input['device_token'],
                            'login_token'=> $token
                        ]);    
            return $token;                    
        
   }

   private function checkRequiredParams($input,$required){
        foreach($required as $r):
            if(isset($input["$r"])==false || $r=''):
                return $r;
            endif;
        endforeach;
        return false;
   }

    private function generateToken($id)
    {
        return  md5($id.time());
    }

    
}
