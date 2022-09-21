<?php

namespace App\Http\Controllers\API\ERP;

use App\Models\Clients;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Licences;
use App\Models\Devices;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Exception;

class AppUserController extends Controller
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
                'data'=>(object)[],
                'code'=>201
            ]);
            die();
        endif;
        if(!$this->checkToken()):
            echo json_encode([
                'error'=>true,
                'message'=>"Invalid Token",
                'data'=>(object)[],
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
    public function detail(Request $request){
        $input = $request->all();
        $required = $this->checkRequiredParams($input,[
            'device_id','company_id'
        ]);
        if(!$required):
            $comCheck = Company::where('company_id',$input['company_id'])->get()->count();
            if($comCheck):
            $device = Devices::select('device_id','company_id','email','status')
                ->where('device_id',$input['device_id'])
                ->where('company_id',$input['company_id'])->get()->first();
            if($device):
                return json_encode([
                    'error'=>false,
                    'message'=>"Device details listed",
                    'data'=> $device,
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Invalid device id",
                    'data'=>(object)[],
                    'code'=>203
                ]);
            endif;
            else:
                return json_encode([
                    'error'=>false,
                    'message'=>"Company not exist",
                    'data'=>(object)[],
                    'code'=>202
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'data'=>(object)[],
                'code'=>201
            ]);
        endif;
    }
    public function add(Request $request)
    {
        $input = $request->all();
        $required = $this->checkRequiredParams($input,[
            'company_id','email','status','password'
        ]);
        if(!$required):
            $comCheck = Company::where('company_id',$input['company_id'])->get()->count();
            if($comCheck):
            $licence = Licences::where('company_id',$input['company_id'])->get()->first();
            if($licence):
                $isExpired = Licences::where('company_id',$input['company_id'])
                    ->where('expiration_date','>=',date('Y-m-d'))
                    ->count();
                if($isExpired):
                    $allowedDevices = Devices::where('company_id',$input['company_id'])->get()->count();
                    if($licence->device_count > $allowedDevices):
                        $checkEmail = Devices::where('email',$input['email'])->get()->count();
                        if($checkEmail==0):
                            $data = [
                                "company_id"  => $input["company_id"],
                                "email"       => $input["email"],
                                "status"      => $input["status"],
                                "password"    => Hash::make($input["password"])
                            ];
                            try{
                                Devices::create($data);
                                return json_encode([
                                    'error'=>false,
                                    'message'=>'Device created successfully.',
                                    'data' => Devices::select('device_id','company_id','email','status')->where('email',$input['email'])->where('company_id',$input['company_id'])->get()->first(),
                                    'code' => 200
                                ]);
                            }catch(Exception $e){
                                return json_encode([
                                    'error'=>true,
                                    'message'=>'Exception occured.',
                                    'data'=> $e,
                                    'code' => 207
                                ]);
                            }
                        else:
                            return json_encode([
                                'error'=>true,
                                'message'=>'Email already used',
                                'data'=> (object)[],
                                'code' => 206
                            ]);
                        endif;
                    else:
                        return json_encode([
                            'error'=>true,
                            'message'=>'Already devices reached to allowed devices count',
                            'data'=> (object)[],
                            'code' => 205
                        ]);
                    endif;
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>'License expired. Please check with Admin',
                        'data'=> (object)[],
                        'code' => 204
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>'License not issued yet. Please check with Admin',
                    'data'=> (object)[],
                    'code' => 203
                ]);
            endif;
            else:
                return json_encode([
                    'error'=>false,
                    'message'=>"Company not exist",
                    'data'=>(object)[],
                    'code'=>202
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'data'=>(object)[],
                'code'=>201
            ]);
        endif;

    }

    public function update(Request $request)
    {
        $input = $request->all();
        $required = $this->checkRequiredParams($input,[
            'company_id','device_id','status'
        ]);
        if(!$required):
            $comCheck = Company::where('company_id',$input['company_id'])->get()->count();
            if($comCheck):
            $licence = Licences::where('company_id',$input['company_id'])->get()->first();
            if($licence):
                $isExpired = Licences::where('company_id',$input['company_id'])
                    ->where('expiration_date','>=',date('Y-m-d'))
                    ->count();
                if($isExpired):
                        $device_id = $input['device_id'];
                        $data = [
                            "status"   => $input["status"]
                        ];
                        if(isset($input['password']) &&  $input['password']!=""){
                            $data['password'] = Hash::make($input["password"]);
                        }
                       try{
                        Devices::where('device_id',$device_id)->where('company_id',$input['company_id'])->update($data);
                        return json_encode([
                            'error'=>false,
                            'message'=>'Device updated successfully.',
                            'data' => (object) [],
                            'code' => 200
                        ]);
                       }catch(Exception $e){
                        return json_encode([
                            'error'=>true,
                            'message'=>'Exception occured.',
                            'data'=> $e,
                            'code'=> 205
                        ]);
                       }
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>'Licence expired. Please check with Admin',
                        'data'=> (object)[],
                        'code' => 204
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>'Licence not created yet. Please check with Admin',
                    'data'=> (object)[],
                    'code' => 203
                ]);
            endif;
            else:
                return json_encode([
                    'error'=>false,
                    'message'=>"Company not exist",
                    'data'=>(object)[],
                    'code'=>202
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'data'=>(object)[],
                'code'=>201
            ]);
        endif;
    }

    public function listByCompany(Request $request){
        $input = $request->all();
        $required = $this->checkRequiredParams($input,[
            'company_id','page','count'
        ]);
        if(!$required):
            $comCheck = Company::where('company_id',$input['company_id'])->get()->count();
            if($comCheck):
            $clients = Devices::select('device_id','company_id','email','status')
                ->where('company_id',$input['company_id'])
                ->skip($input['page']*$input['count'])
                ->take($input['count'])
                ->get();
            return json_encode([
                'error'=>false,
                'message'=>"listing done",
                'data'=> $clients,
                'code'=>200
            ]);
            else:
                return json_encode([
                    'error'=>false,
                    'message'=>"Company not exist",
                    'data'=>(object)[],
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

    public function delete(Request $request){
        $input = $request->all();
        $required = $this->checkRequiredParams($input,[
            'company_id','device_id'
        ]);
        if(!$required):
            $comCheck = Company::where('company_id',$input['company_id'])->get()->count();
            if($comCheck):
                if($this->checkDevice($input['device_id'])):
                    try{
                        Devices::where('company_id',$input['company_id'])
                            ->where('device_id',$input['device_id'])->delete();
                        return json_encode([
                            'error'=>false,
                            'message'=>"Device deleted successfully",
                            'data'=> (object)[],
                            'code'=>200
                        ]);
                    }catch(Exception $e){
                        return json_encode([
                            'error'=>true,
                            'message'=>"Exception Occurred",
                            'data'=> (object)[],
                            'code'=>204
                        ]);
                    }
                    else:
                        return json_encode([
                            'error'=>false,
                            'message'=>"Device not exist",
                            'data'=>(object)[],
                            'code'=>203
                        ]);
                        endif;

            else:
                return json_encode([
                    'error'=>false,
                    'message'=>"Company not exist",
                    'data'=>(object)[],
                    'code'=>202
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'data'=> (object)[],
                'code'=>201
            ]);
        endif;
    }

    private function checkDevice($device_id){
        return Devices::where('device_id',$device_id)->get()->count();
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

}
