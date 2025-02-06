<?php

namespace App\Http\Controllers;

use App\Models\Flag;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreFlagRequest;

class FlagController extends Controller
{
    private $flag;
    public  function __construct(Flag $flag)
    {
        $this->flag = $flag;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->flag->all(), 200);
    }

    /**
     * Find flag by id
     *
     * @param  string  $id
     * @return \App\Models\Flag
     *
     * @throws \Exception
    */
    public function show($id)
    {
        $flag = $this->flag->find($id);
        if ($flag == null) {
            return response()->json(["error"=> "Bandeira não encontrado"],404);
        }
        return response()->json($flag, 200);
    }

    /**
     * Find flag by name
     *
     * @param  FormRequest $request
     * @return \App\Models\Flag
     *
     * @throws \Exception
    */
    public function search(FormRequest $request)
    {
        $query = $request->query('q');
        
        $flagsFound = $this->flag->where("name", "LIKE", "%{$query}%")
            ->get()
            ->map(fn($flag) => [$flag->id, $flag->name, $flag->economicGroup->name])
            ->toArray();
        
        return redirect()->route("flags", $query == "" ? [] : compact("query", "flagsFound"));
    }

    /**
     * Store a newly created flag in storage.
     * @param \App\Http\Requests\StoreFlagRequest
     */
    public function store(StoreFlagRequest $request)
    {
        $validatedRequest = $request->validated();
        $this->flag->create($validatedRequest);
        return redirect()->route("flags");
    }

    /**
     * Update flag atributes
     * @param FormRequest
     * @param string id
     * @return Flag
     * 
     * @throws \Exception
    */
    public function update(FormRequest $request, $id)
    {
        $flag = $this->flag->findOrFail($id);
        $validatedData = $request->validateWithBag('flag', [
            "name" => "required|unique:flags,name,".$id,
            "economic_group_id" => "required|exists:economic_groups,id",
        ]);
        $flag->update($validatedData);
        return redirect()->route("flags", ['message' => 'Bandeira atualizada com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     * @param string id
     * @throws \Exception
     */
    public function destroy($id)
    {
        $flag = $this->flag->find($id);
        if ($flag == null) {
            return redirect()->route("flags", ['error' => "Bandeira não encontrada !"]);
        }
        $flag->delete();
        return redirect()->route("flags", ["message" => "Bandeira removida com sucesso !"]);
    }
}
