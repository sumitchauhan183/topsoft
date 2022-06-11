<?php

namespace App\Http\Controllers\Api\ERP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Exception;

class CompanyController extends Controller
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
        $required = $this->checkRequiredParams($this->input,['token']);
        
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

    public function devices(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id'
        ]);
        if(!$required):
            $devices = Devices::select('device_id','email','type','status','created_at')
                        ->where('company_id',$input['company_id'])->get();
                return json_encode([
                    'error'=>false,
                    'message'=>"device listed",
                    'data'=> $devices,
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

    public function detail(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id'
        ]);
        if(!$required):
            $company = Company::select('company_id','name','greek_name','public_key as email','status')
                              ->where('company_id',$input['company_id'])->get()->first();
            if($company):
                return json_encode([
                    'error'=>false,
                    'message'=>"details listed",
                    'data'=> $company,
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Invalid customer id",
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

    public function add()
    {
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'name','greek_name','email','password'
        ]);
        if(!$required):
            $check = Company::where('public_key',$input['email'])->get()->count();
            if(!$check):
                $company = Company::create([
                        'name' => $input['name'],
                        'greek_name' => $input['greek_name'],
                        'public_key' => $input['email'],
                        'private_key' => Hash::make($input['password']),
                        'status' => 'active'
                ]);
                if($company):
                    //$company->company_id = $company->id;
                    //unset($company->id);
                    unset($company->private_key);
                    unset($company->public_key);
                    return json_encode([
                        'error'=>false,
                        'message'=>"Company created successfully",
                        'code'=>201,
                        'data'=>$company
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"server issue client not created",
                        'code'=>201
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"email already use for another company",
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

    public function update(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','name','greek_name','email'
        ]);
        if(!$required):
            $check  = Company::where('public_key',$input['email'])
                            ->where('company_id','!=',$input['company_id'])
                            ->get()->count();
            if(!$check):
                $data = [
                    "name"=> $input['name'],
                    "greek_name"=> $input['greek_name'],
                    "public_key"=> $input['email']
                ];	
                if(isset($input['password'])):
                    $data['private_key'] = Hash::make($input['password']);
                endif;
                $company = Company::where('company_id',$input['company_id'])->update(
                    $data
                );
                
                if($company):
                    return json_encode([
                        'error'=>false,
                        'message'=>"Details updated successfully",
                        'code'=>201
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"server issue client not created",
                        'code'=>201
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"email already use for another company",
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

    public function list(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'page','count'
        ]);
        if(!$required):
            $company = Company::select('company_id','name','greek_name','public_key as email','status')
                       ->skip($input['page']*$input['count'])->take($input['count'])->get();
            return json_encode([
                'error'=>false,
                'message'=>"listing done",
                'data'=> $company,
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
           $token = $this->input['token'];
           if(env('erp_token')!=$token):
               return false;
           else:
               return true;
           endif;                    
        
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
