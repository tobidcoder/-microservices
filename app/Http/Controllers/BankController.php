<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Http\Resources\Bank as BankResource;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;

use Validator;

class BankController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank  = Bank::all();
    
        return $this->sendResponse(BankResource::collection($bank), 'Bank retrieved successfully.');
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
            'account_number' => 'required|digits:10',
            'bank' => 'required',
            'bvn' => 'required|digits:11',
            'user_id' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $bank = Bank::create($input);
   
        return $this->sendResponse(new BankResource($bank), 'Bank created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $bank = Bank::find($id);
  
        if (is_null($bank)) {
            return $this->sendError('Bank not found.');
        }
   
        return $this->sendResponse(new BankResource($bank), 'Bank retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'account_number' => 'required|digits:10',
            'bank' => 'required',
            'bvn' => 'required|digits:11',
            'user_id' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $bank->account_number = $input['account_number'];
        $bank->bank = $input['bank'];
        $bank->bvn = $input['bvn'];
        $bank->user_id = $input['user_id'];
        $bank->save();
   
        return $this->sendResponse(new BankResource($bank), 'Bank updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();
   
        return $this->sendResponse([], 'Bank deleted successfully.');
    }
}


