<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use App\Classes\Email;
use Exception;

class CompanyController extends Controller
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
            $check = Company::where('public_key',$input['email'])->count();
            if($check<1):
                return json_encode([
                    'error'=>false
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>'This email is already used by another company'
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
                "name"  => $input["name"],
                "greek_name" => $input["greekName"],
                "public_key"  => $input["email"],
                "private_key" => Hash::make($input["password"])
        ];
       try{
        Company::create($data);
        return json_encode([
            'error'=>false,
            'message'=>'Company created successfully.'
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
        $company_id = $input['company_id'];
        $data = [
            "name"  => $input["name"],
            "greek_name" => $input["greekName"],
            
        ];
        if($input['is_password']){
            $data['private_key'] = Hash::make($input["password"]);
        }
       try{
        Company::where('company_id',$company_id)->update($data);
        return json_encode([
            'error'=>false,
            'message'=>'company updated successfully.'
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
        try{
            $company = Company::with('license')->get()->toArray();
            return json_encode([
                'error'=>false,
                'message'=>'company list',
                'company'=> $company
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