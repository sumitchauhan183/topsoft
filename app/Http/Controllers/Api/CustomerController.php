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


    private $input; 
    public function __construct(Request $request)
    {
        $this->input = $request->all();
        $required = $this->checkRequiredParams($this->input,['device_id','token']);
        if($required):
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'code'=>201
            ]);
        endif;
        if(!$this->checkToken()):
            return json_encode([
                'error'=>true,
                'message'=>"Invalid Token",
                'code'=>201
            ]);
        endif;
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


    public function add()
    {
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'email','password','company_id','unique_token','device_token','type'
        ]);
        if(!$required):
            
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'code'=>201
            ]);
        endif;
        
    }

    public function update(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'email','password','company_id','unique_token','device_token','type'
        ]);
        if(!$required):
            
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'code'=>201
            ]);
        endif;
    }

    public function list(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'email','password','company_id','unique_token','device_token','type'
        ]);
        if(!$required):
            
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'code'=>201
            ]);
        endif;
    }


   private function checkToken(){
                  
                
           $check = Devices::where('device_id',$this->input['device_id'])
                        ->where('login_token',$this->input['token'])
                        ->get()->count();    
            return $check;                    
        
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
