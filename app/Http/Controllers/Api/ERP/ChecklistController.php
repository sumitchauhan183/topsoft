<?php

namespace App\Http\Controllers\Api\ERP;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Checklist;

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
            'company_id','checklist_text'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if(!$this->checkText($input)):
                    Checklist::create([
                            "company_id"=> $input['company_id'],
                            "checklist_text"=> $input["checklist_text"]
                    ]);
                    return json_encode([
                        'error'=>false,
                        'message'=>"Checklist created successfully",
                        'data'=> Checklist::where('company_id',$input['company_id'])
                            ->where('checklist_text',$input['checklist_text'])->get()->first(),
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"Checklist item already exist",
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
            'company_id','checklist_id','checklist_text'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if(!$this->checkText($input)):
                Checklist::where('checklist_id',$input['checklist_id'])
                    ->where('company_id',$input['company_id'])->update([
                        "checklist_text"=> $input["checklist_text"]
                ]);
                return json_encode([
                    'error'=>false,
                    'message'=>"Checklist updated successfully",
                    'data'=> Checklist::where('checklist_id',$input['checklist_id'])->get()->first(),
                    'code'=>200
                ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"Checklist already exists",
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
            'company_id','checklist_id'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkChecklist($input)):
                    $detail = Checklist::where('company_id',$input['company_id'])
                        ->where('checklist_id',$input['checklist_id'])
                        ->get()->first();
                    return json_encode([
                        'error'=>false,
                        'message'=>"details listed",
                        'data'=> $detail,
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"Checklist not exists",
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
                    $types = Checklist::where('company_id',$input['company_id'])->get();
                    return json_encode([
                        'error'=>false,
                        'message'=>"Checklist items listed",
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
            'company_id','checklist_id'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkChecklist($input)):
                    Checklist::where('company_id',$input['company_id'])
                        ->where('checklist_id',$input['checklist_id'])
                        ->delete();
                    return json_encode([
                        'error'=>false,
                        'message'=>"Checklist item removed",
                        'data'=> (object)[],
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"Checklist item not exists",
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

    public function deleteall(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                    Checklist::where('company_id',$input['company_id'])
                        ->delete();
                    return json_encode([
                        'error'=>false,
                        'message'=>"All checklist items removed",
                        'data'=> (object)[],
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





    private function checkCompany($company_id){
        return Company::where('company_id',$company_id)->get()->count();
    }

    private function checkChecklist($input){
        return Checklist::where('company_id',$input['company_id'])
                   ->where('checklist_id',$input['checklist_id'])
                   ->get()->count();
    }

    private function checkText($input){
        if(isset($input['checklist_id'])):
            return Checklist::where('checklist_text',$input['checklist_text'])
                ->where('company_id',$input['company_id'])
                ->where('checklist_id','!=',$input['checklist_id'])
                ->get()->count();
        else:
                return Checklist::where('checklist_text',$input['checklist_text'])
                    ->where('company_id',$input['company_id'])
                    ->get()->count();
        endif;

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
