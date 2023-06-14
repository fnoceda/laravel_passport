<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CEO;
use Illuminate\Http\Request;
use App\Http\Resources\CEOResource;
use Illuminate\Support\Facades\Validator;

class CEOController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ceos = CEO::all();
        return response(['ceos' => CEOResource::collection($ceos), 'message'=>'Retrieved Successfully'], status:200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'company' => 'required|max:255',
            'year' => 'required|max:255',
            'company_headquarters' => 'required|max:255',
            'what_company_does' => 'required|max:255',
        ]);

        if($validator->fails()){
            return response(['error'=>$validator->errors(), 'message' => 'Validation Fail'], status:422);
        }

        $ceo = CEO::create($data);

        return response(['ceo' => new CEOResource($ceo), 'message' => 'Created Successfully'], status:201);

    }

    /**
     * Display the specified resource.
     */
    public function show(CEO $ceo)
    {
        return response(['ceo' => new CEOResource($ceo), 'message'=>'Retrieved Successfully'], status:200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CEO $ceo)
    {
        $ceo->update($request->all());
        return response(['ceo' => new CEOResource($ceo), 'message'=>'Updated Successfully'], status:200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CEO $ceo)
    {
        $ceo->delete();
        return response(['ceo' => CEOResource($ceo), 'message'=>'Deleted Successfully'], status:200);

    }
}
