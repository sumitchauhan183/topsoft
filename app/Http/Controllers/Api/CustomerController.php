<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\Clients;
use App\Models\Invoices;
use Exception;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    private $input;
    private $company_id;
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
        else:
            $device = $this->deviceDetail();
            $this->company_id = $device->company_id;
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

    public function invoices(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'client_id'
        ]);
        if(!$required):
            $client = Invoices::where('company_id',$this->company_id)->where('client_id',$input['client_id'])->get();
                return json_encode([
                    'error'=>false,
                    'message'=>"details listed",
                    'data'=> $client,
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
            'client_id'
        ]);
        if(!$required):
            $client = Clients::where('client_id',$input['client_id'])->get()->first();
            if($client):
                return json_encode([
                    'error'=>false,
                    'message'=>"details listed",
                    'data'=> $client,
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
            'name','address','city','postal_code','telephone','mobile','tax_number','occupation',
            'email','payment_mode'
        ]);
        if(!$required):
            $check = Clients::where('email',$input['email'])->get()->count();
            if(!$check):
                $input = $this->SetColumnsToBlank($input,[
                    'region','tax_post','discount','note','note2','latitude','longitude'
                ]);
                $client = Clients::create([
                    'company_id'=>$this->company_id,
                        'name' => $input['name'],
                        'region' => $input['region'],
                        'address' => $input['address'],
                        'city' => $input['city'],
                        'postal_code' => $input['postal_code'],
                        'telephone' => $input['telephone'],
                        'mobile' => $input['mobile'],
                        'tax_number' => $input['tax_number'],
                        'tax_post' => $input['tax_post'],
                        'occupation' => $input['occupation'],
                        'email' => $input['email'],
                        'discount' => $input['discount'],
                        'note' => $input['note'],
                        'note2' => $input['note2'],
                        'payment_mode' => $input['payment_mode'],
                        'latitude' => $input['latitude'],
                        'longitude'   => $input['longitude']

                ]);
                if($client):
                    return json_encode([
                        'error'=>false,
                        'message'=>"Customer created successfully",
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
                    'message'=>"email already use for another client",
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
            'client_id','name','region','address','city','postal_code','telephone','mobile','tax_number','tax_post','occupation',
            'email','discount','note','note2'
        ]);
        if(!$required):
            $check  = Clients::where('email',$input['email'])
                            ->where('client_id','!=',$input['client_id'])
                            ->get()->count();
            if(!$check):
                $input = $this->SetColumnsToBlank($input,[
                    'region','tax_post','latitude','longitude'
                ]);
                $client = Clients::where('client_id',$input['client_id'])->update([
                    'name' => $input['name'],
                    'region' => $input['region'],
                    'address' => $input['address'],
                    'city' => $input['city'],
                    'postal_code' => $input['postal_code'],
                    'telephone' => $input['telephone'],
                    'mobile' => $input['mobile'],
                    'tax_number' => $input['tax_number'],
                    'tax_post' => $input['tax_post'],
                    'occupation' => $input['occupation'],
                    'email' => $input['email'],
                    'discount' => $input['discount'],
                    'note' => $input['note'],
                    'note2' => $input['note2'],
                    'latitude' => $input['latitude'],
                    'longitude'   => $input['longitude']
                ]);

                if($client):
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
                    'message'=>"email already use for another client",
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
            $clients = Clients::where('company_id',$this->company_id)->skip($input['page']*$input['count'])->take($input['count'])->get();
            return json_encode([
                'error'=>false,
                'message'=>"listing done",
                'data'=> $clients,
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

    public function delete(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'client_id'
        ]);
        if(!$required):
            $client = Clients::where('client_id',$input['client_id'])->delete();
            if($client):
                return json_encode([
                    'error'=>false,
                    'message'=>"client removed successfully",
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"sever issue client not removed",
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


   private function checkToken(){
           $check = Devices::where('device_id',$this->input['device_id'])
                        ->where('login_token',$this->input['token'])
                        ->get()->count();
            return $check;

   }

   private  function deviceDetail(){
       return Devices::where('device_id',$this->input['device_id'])
           ->where('login_token',$this->input['token'])
           ->get()->first();
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
