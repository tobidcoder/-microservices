<?php

namespace App\Http\Controllers;

use App\Employer;
use App\Http\Resources\Employer as EmployerResource;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;

use Validator;

class EmployerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employer = Employer::all();
    
        return $this->sendResponse(EmployerResource::collection($employer), 'Employer retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'sector' => 'required',
            'employer' => 'required',
            'employer_address' => 'required',
            'office_email' => 'required|email',
            'office_phone' => 'required|regex:/^\+234[0-9]{10}/',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $employer = Employer::create($input);
   
        return $this->sendResponse(new EmployerResource($employer), 'Employer created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $employer = Employer::find($id);
  
        if (is_null($employer)) {
            return $this->sendError('Employer not found.');
        }
   
        return $this->sendResponse(new EmployerResource($employer), 'Employer retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function edit(employer $employer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employer $employer)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'sector' => 'required',
            'employer' => 'required',
            'employer_address' => 'required',
            'office_email' => 'required|email',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $employer->sector = $input['sector'];
        $employer->employer = $input['employer'];
        $employer->employer_address = $input['employer_address'];
        $employer->office_email = $input['office_email'];
        $employer->office_phone = $input['office_phone'];
        $employer->save();
   
        return $this->sendResponse(new EmployerResource($employer), 'Employer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employer $employer)
    {
        $employer->delete();
   
        return $this->sendResponse([], 'Employer deleted successfully.');
    }

    public function showEmployerStaff(){

        $employerStaff = Employer::with('users')->get();
        if($employerStaff->count() === 0){ 
            return response()->json([ 
            'success' => false, 
            'message' => 'Employer staff not found' 
        ], 404); 
 
      } 
       
      elseif($employerStaff){ 
            return response()->json([ 
                'data' => $employerStaff->toArray(), 
                ], 200); 
        } else { 
            return response()->json(['error' => 'UnAuthorised'], 401); 
        } 

    }
}


