<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Licences;
use Illuminate\Support\Facades\Hash;
use App\Classes\Email;
use Exception;

class LicenseController extends Controller
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

    public function add(Request $request)
    {
        $input = $request->all();
        $data = [
                "company_id"      => $input["company_id"],
                "licence_key"     => $this->generateLicenseKey($input["company_id"]),
                "device_count"    => $input["device_count"],
                "expiration_date" => $input["expiration_date"]
        ];
       try{
        Licences::create($data);
        return json_encode([
            'error'=>false,
            'message'=>'License created successfully.'
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
        $license_id = $input['license_id'];
        $data = [
            "device_count"    => $input["device_count"],
            "expiration_date" => $input["expiration_date"],
            
        ];
       try{
        Licences::where('licence_id',$license_id)->update($data);
        return json_encode([
            'error'=>false,
            'message'=>'licence updated successfully.'
        ]);
       }catch(Exception $e){
        return json_encode([
            'error'=>true,
            'message'=>'Exception occured.',
            'exception'=> $e
        ]);
       }
        
    } 

    private function generateLicenseKey($id){
        return md5($id.time());
    }


}