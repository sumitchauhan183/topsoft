<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\Checklist;
use App\Models\Company;
use Exception;

class ChecklistController extends Controller
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
            echo json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'code'=>201
            ]);
            die();
        endif;
        if(!$this->checkToken()):
            echo json_encode([
                'error'=>true,
                'message'=>"Invalid Token",
                'code'=>201
            ]);
            die();
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

    public function list(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id'
        ]);
        if(!$required):
            $checklist  = Checklist::where('company_id',$input['company_id'])
                            ->get();
                    return json_encode([
                        'error'=>false,
                        'message'=>"Check List",
                        'data'=>$checklist,
                        'code'=>200
                    ]);
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


    private function SetColumnsToBlank($input,$required){
     foreach($required as $r):
         if(isset($input["$r"])==false):
             $input["$r"] = '';
         endif;
     endforeach;
     return $input;
 }
    
}
