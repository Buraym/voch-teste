<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreUnitRequest;

class UnitController extends Controller
{
    private $unit;
    public  function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->unit->all(), 200);
    }

    /**
     * Find unit by id
     *
     * @param  string  $id
     * @return \App\Models\Unit
     *
     * @throws \Exception
    */
    public function show($id)
    {
        $unit = $this->unit->find($id);
        if ($unit == null) {
            return response()->json(["error"=> "Unidade não encontrada"],404);
        }
        return response()->json($unit, 200);
    }

    /**
     * Find unit by name
     *
     * @param  FormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
    */
    public function search(FormRequest $request)
    {
        $query = $request->query('q');
        
        $unitsFound = $this->unit->where("name", "LIKE", "%{$query}%")
            ->get()
            ->map(fn($unit) => [$unit->id, $unit->name, $unit->social, $unit->cnpj, $unit->flag->name])
            ->toArray();
        
        return redirect()->route("units", $query == "" ? [] : compact("query", "unitsFound"));
    }

    /**
     * Store a newly created unit in storage.
     * @param App\Http\Requests\StoreUnitRequest
     */
    public function store(StoreUnitRequest $request)
    {
        $validatedRequest = $request->validated();
        $this->unit->create($validatedRequest);
        return redirect()->route("units");
    }

    /**
     * Update unit atributes
     * @param FormRequest
     * @param string id
     * @return Unit
     * 
     * @throws \Exception
    */
    public function update(FormRequest $request, $id)
    {
        $unit = $this->unit->findOrFail($id);
        $validatedData = $request->validateWithBag('unit', [
            "name" => "required",
            "social" => "required",
            "cnpj" => [
                "required",
                "regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/",
                "unique:units,cnpj,".$id
            ],
            "flag_id" => "required|exists:flags,id",
        ]);
        $unit->update($validatedData);
        return redirect()->route("units", ['message' => 'Unidade atualizada com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     * @param string id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $unit = $this->unit->find($id);
        if ($unit == null) {
            return redirect()->route("units", ['error' => "Unidade não encontrada !"]);
        }
        $unit->delete();
        return redirect()->route("units", ["message" => "Unidade removida com sucesso !"]);
    }
}
