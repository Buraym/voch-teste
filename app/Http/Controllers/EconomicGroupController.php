<?php

namespace App\Http\Controllers;

use App\Models\EconomicGroup;
use Illuminate\Foundation\Http\FormRequest;
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
     * Find economic group by name
     *
     * @param  FormRequest $request
     * @return \App\Models\EconomicGroup
     *
     * @throws \Exception
    */
    public function search(FormRequest $request)
    {
        $query = $request->query('q');
        
        $groupsFound = $this->economicGroup->where("name", "LIKE", "%{$query}%")
            ->get()
            ->map(fn($group) => [$group->id, $group->name])
            ->toArray();
        
        return redirect()->route("groups", $query == "" ? [] : compact("query", "groupsFound"));
    }

    /**
     * Store a newly created economic group in storage.
     * @param \App\Http\Requests\StoreEconomicGroupRequest
     */
    public function store(StoreEconomicGroupRequest $request)
    {
        $validatedRequest = $request->validated();
        $this->economicGroup->create($validatedRequest);
        return redirect()->route("groups");
    }

    /**
     * Update economic group atributes
     * @param App\Http\Requests\UpdateEconomicGroupRequest
     * @param string id
     * @return \App\Models\EconomicGroup
     * 
     * @throws \Exception
    */
    public function update(UpdateEconomicGroupRequest $request, $id)
    {
        $economicGroup = $this->economicGroup->findOrFail($id);
        $validatedData = $request->validated();
        $economicGroup->update($validatedData);
        return redirect()->route("groups", ['message' => 'Grupo Econômico atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     * @param string id
     * @throws \Exception
     */
    public function destroy($id)
    {
        $economicGroup = $this->economicGroup->find($id);
        if ($economicGroup == null) {
            return redirect()->route("groups", ['error' => "Grupo não encontrado !"]);
        }
        $economicGroup->delete();
        return redirect()->route("groups", ["message" => "Grupo removido com sucesso !"]);
    }
}
