<?php
   
namespace App\Http\Controllers;
   
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class RegisterController extends BaseController
{
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^\+234[0-9]{10}/',
            'date_of_birth' => 'required|date|before:-18 years',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('microservices_tobi')->accessToken;
        $success['First name'] =  $user->first_name;
        $success['Last name'] = $user->last_name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
   
    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('microservices_tobi')-> accessToken; 
            $success['First name'] =  $user->first_name;
            $success['Last name'] =  $user->last_name;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function createEmployment(Request $request){
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'employer_id' => 'required',
            'employment_status' => 'required',
            'designation' => 'required',
            'user_id'  => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $user = User::find($input['employer_id']);
        $user->employer_id = $input['employer_id'];
        $user->employment_status = $input['employment_status'];
        $user->designation = $input['designation'];
        $user->update();
   
        return $this->sendResponse(new UserResource($user), 'Employment created successfully.');
    }

    public function updateEmployment(Request $request){
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'employer_id' => 'required',
            'employment_status' => 'required',
            'designation' => 'required',
            'user_id'  => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $user = User::find($input['employer_id']);
        $user->employer_id = $input['employer_id'];
        $user->employment_status = $input['employment_status'];
        $user->designation = $input['designation'];
        $user->update();
   
        return $this->sendResponse(new UserResource($user), 'Employment updated successfully.');
    }

}