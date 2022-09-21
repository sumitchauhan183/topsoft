<?php

namespace App\Http\Controllers\Api\ERP;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Licences;
use Illuminate\Support\Facades\DB;

class LicenseController extends Controller
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



    public function add(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','device_count','expiration_date'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkLicense($input)<1):
                    $expd = date('Y-m-d',strtotime($input["expiration_date"]));
                    if($expd > date('Y-m-d')):
                $data = [
                    "company_id"      => $input["company_id"],
                    "licence_key"     => $this->generateLicenseKey($input["company_id"]),
                    "device_count"    => $input["device_count"],
                    "expiration_date" => date('Y-m-d',strtotime($input["expiration_date"]))
                ];
                Licences::Create($data);
                    return json_encode([
                        'error'=>false,
                        'message'=>"License added successfully",
                        'data'=> Licences::where('company_id',$input['company_id'])->get(),
                        'code'=>200
                    ]);
                    else:
                        return json_encode([
                            'error'=>true,
                            'message'=>"Expiration date should be future date.",
                            'code'=>204
                        ]);
                    endif;
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"License already exist.",
                        'code'=>203
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Company not exists",
                    'code'=>202
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
    public function update(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','license_id','device_count','expiration_date'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkLicense($input)):
                    $expd = date('Y-m-d',strtotime($input["expiration_date"]));
                    if($expd > date('Y-m-d')):
                    $data = [
                        "device_count"    => $input["device_count"],
                        "expiration_date" => date('Y-m-d',strtotime($input["expiration_date"]))
                    ];
                    Licences::where('company_id',$input['company_id'])
                        ->where('licence_id',$input['license_id'])
                        ->update($data);
                    return json_encode([
                        'error'=>false,
                        'message'=>"License updated successfully",
                        'data'=> Licences::where('company_id',$input['company_id'])->get(),
                        'code'=>200
                    ]);
                    else:
                        return json_encode([
                            'error'=>true,
                            'message'=>"Expiry date should be future date",
                            'code'=>204
                        ]);
                    endif;
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"License not created yet",
                        'code'=>203
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Company not exists",
                    'code'=>202
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
    public function detail(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','license_id'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkLicense($input)):
                    return json_encode([
                        'error'=>false,
                        'message'=>"License details",
                        'data'=> Licences::where('company_id',$input['company_id'])->get(),
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"License not created yet",
                        'code'=>203
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Company not exists",
                    'code'=>202
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
    public function delete(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkLicense($input)>0):
                    Licences::where('company_id',$input['company_id'])->delete();
                    return json_encode([
                        'error'=>false,
                        'message'=>"License removed successfully",
                        'data'=> (object)[],
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"License not found",
                        'code'=>203
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Company not exists",
                    'code'=>202
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


    private function checkCompany($company_id){
        return Company::where('company_id',$company_id)->get()->count();
    }


    private function checkLicense($input){
        return Licences::where('company_id',$input['company_id'])
                         ->get()->count();
    }

    private function checkToken(){
        $token = $this->input['token'];
        if(env('erp_token'!=$token)):
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

    private function generateLicenseKey($id){
        return md5($id.time());
    }



}
