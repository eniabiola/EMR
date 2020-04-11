<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DrugCreationRequest;
use App\Http\Resources\DrugResource;
use App\Models\Drug;
use Validator;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drugs = Drug::paginate(15);
        return DrugResource::collection($drugs);
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
        'name' => 'required|max:255|min:3',
        'description' => 'required',
        'code' => 'required|max:10|unique:drugs'
        ]);
   
        if($validator->fails()){
            // return $this->sendError('Validation Error.', $validator->errors());      
        }
   
        $drug = Drug::create($input);
   
        // return $this->sendResponse(new DrugResource($drug), 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {  
        //Get single Article
        $Drug = Drug::findOrFail($id);

        //Return single article as a resource;
        return new DrugResource($Drug);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $input = $request->all();
   
        $validator = Validator::make($input, [ 
        'name' => 'required|max:255|min:3',
        'description' => 'required',
        'code' => 'required|max:10|unique:drugs'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $drug = Drug::update($input);
   
        return $this->sendResponse(new DrugResource($drug), 'Product created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
