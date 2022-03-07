<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\company;
use App\Models\Licences;
use App\Models\Devices;
use Illuminate\Support\Facades\Hash;
use App\Classes\Email;
use Exception;

class AppUserController extends Controller
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

    public function checkEmailExist(Request $request)
    {
        $input = $request->all();
        if(isset($input['email'])):
            $check = Devices::where('email',$input['email'])->count();
            if($check<1):
                return json_encode([
                    'error'=>false
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>'This email is already used by another App User'
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>'Email id is required'
            ]);
        endif;
    }

    public function checkMobileExist(Request $request)
    {
        $input = $request->all();
        if(isset($input['mobile'])):
            $check = Devices::where('mobile',$input['mobile'])->count();
            if($check<1):
                return json_encode([
                    'error'=>false
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>'This mobile is already used by another App User'
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>'Email id is required'
            ]);
        endif;
    }

    public function add(Request $request)
    {
        $input = $request->all();
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
            'message'=>'App User created successfully.'
        ]);
       }catch(Exception $e){
        return json_encode([
            'error'=>true,
            'message'=>'Exception occured.',
            'exception'=> $e
        ]);
       }
        
    } 

    public function update(Request $request)
    {
        $input     = $request->all();
        $device_id = $input['device_id'];
        $data = [
            "status"   => $input["status"]
        ];
        if($input['is_password']){
            $data['password'] = Hash::make($input["password"]);
        }
       try{
        Devices::where('device_id',$device_id)->update($data);
        return json_encode([
            'error'=>false,
            'message'=>'App User updated successfully.'
        ]);
       }catch(Exception $e){
        return json_encode([
            'error'=>true,
            'message'=>'Exception occured.',
            'exception'=> $e
        ]);
       }
        
    } 

    public function list(Request $request)
    {
        $input     = $request->all();
        $company_id = $input['company_id'];
        try{
            $devices = Devices::where('company_id',$company_id)->get()->toArray();
            return json_encode([
                'error'=>false,
                'message'=>'App User list',
                'devices'=> $devices
            ]);
        }
        catch(Excepyion $e){
            return json_encode([
                'error'=>true,
                'message'=>'Exception occured.',
                'exception'=> $e
            ]);
        }
        
        
    } 
}