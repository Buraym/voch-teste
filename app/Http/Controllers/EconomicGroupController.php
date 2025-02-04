<?php

namespace App\Http\Controllers;

use App\Models\EconomicGroup;
use App\Http\Requests\StoreEconomicGroupRequest;
use App\Http\Requests\UpdateEconomicGroupRequest;

class EconomicGroupController extends Controller
{

    private $economicGroup;
    public  function __construct(EconomicGroup $economicGroup)
    {
        $this->economicGroup = $economicGroup;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->economicGroup->all(), 200);
    }

    /**
     * Find economic group by id
     *
     * @param  string  $id
     * @return \App\Models\EconomicGroup
     *
     * @throws \Exception
    */
    public function show($id)
    {
        $economicGroup = $this->economicGroup->find($id);
        if ($economicGroup == null) {
            return response()->json(["error"=> "Grupo não encontrado"],404);
        }
        return response()->json($economicGroup, 200);
    }

    /**
     * Store a newly created economic group in storage.
     */
    public function store(StoreEconomicGroupRequest $request)
    {
        $validatedRequest = $request->validated();
        $economicGroup = $this->economicGroup->create($validatedRequest);
        return response()->json($economicGroup, 201);
    }

    /**
     * Update economic group atributes
     * @param App\Http\Requests\UpdateEconomicGroupRequest
     * @param \App\Models\EconomicGroup
     * @return \App\Models\EconomicGroup
     * 
     * @throws \Exception
    */
    public function update(UpdateEconomicGroupRequest $request, EconomicGroup $economicGroup)
    {
        $validatedRequest = $request->validated();
        $this->economicGroup->updated($validatedRequest);
        return response()->json(['message' => 'Grupo atualizado com sucesso!', 'updated_group' => $economicGroup], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EconomicGroup $economicGroup)
    {
        $economicGroup = $this->economicGroup->find($economicGroup);
        if ($economicGroup == null) {
            return response()->json(["error"=> "Grupo não encontrado !"],404);
        }
        $economicGroup->delete();
        return response()->json(["message" => "Grupo removido com sucesso !"], 200);
    }
}
