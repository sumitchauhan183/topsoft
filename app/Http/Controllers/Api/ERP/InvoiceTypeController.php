<?php

namespace App\Http\Controllers\Api\ERP;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InvoiceTypes;

class InvoiceTypeController extends Controller
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
            'company_id','name'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                    $types = InvoiceTypes::create([
                            "company_id"=> $input['company_id'],
                            "name"=> $input["name"]
                    ]);
                    return json_encode([
                        'error'=>false,
                        'message'=>"Invoice Type created successfully",
                        'data'=> InvoiceTypes::where('type_id',$types->id)->get()->first(),
                        'code'=>200
                    ]);
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
            'company_id','type_id','name','status'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkInvoiceType($input)):
                $types = InvoiceTypes::where('type_id',$input['type_id'])->update([
                    "status"=> $input['status'],
                    "name"=> $input["name"]
                ]);
                return json_encode([
                    'error'=>false,
                    'message'=>"Invoice Type updated successfully",
                    'data'=> InvoiceTypes::where('type_id',$input['type_id'])->get()->first(),
                    'code'=>200
                ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"Type id not exists",
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

    public function list(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                    $types = InvoiceTypes::where('company_id',$input['company_id'])->get();
                    return json_encode([
                        'error'=>false,
                        'message'=>"Invoice Type listed",
                        'data'=> $types,
                        'code'=>200
                    ]);
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
            'company_id','type_id'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkInvoiceType($input)):
                    $types = InvoiceTypes::where('type_id',$input['type_id'])->delete();
                    return json_encode([
                        'error'=>false,
                        'message'=>"Invoice Type removed",
                        'data'=> (object)[],
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"Type id not exists",
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

    private function checkInvoiceType($input){
        return InvoiceTypes::where('type_id',$input['type_id'])
                   ->where('company_id',$input['company_id'])
                   ->get()->count();
    }

    private function checkDevice($input){
        return Devices::where('device_id',$input['device_id'])
            ->where('company_id',$input['company_id'])
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

    private function generateToken($id)
    {
        return  md5($id.time());
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
