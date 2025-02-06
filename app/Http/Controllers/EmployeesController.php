<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{

    private $employee;
    public  function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->employee->all(), 200);
    }

    /**
     * Find employee by id
     *
     * @param  string  $id
     * @return \App\Models\Employee
     *
     * @throws \Exception
    */
    public function show($id)
    {
        $employee = $this->employee->find($id);
        if ($employee == null) {
            return response()->json(["error"=> "Colaborador não encontrado"],404);
        }
        return response()->json($employee, 200);
    }

    /**
     * Find employee by name
     *
     * @param  FormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
    */
    public function search(FormRequest $request)
    {
        $query = $request->query('q');
        
        $employeesFound = $this->employee->where("name", "LIKE", "%{$query}%")
            ->get()
            ->map(fn($employee) => [$employee->id, $employee->name, $employee->email, $employee->cpf, $employee->unit->name])
            ->toArray();
        
        return redirect()->route("employees", $query == "" ? [] : compact("query", "employeesFound"));
    }

    /**
     * Store a newly created employee in storage.
     * @param App\Http\Requests\StoreEmployeeRequest
     */
    public function store(StoreEmployeeRequest $request)
    {
        $validatedRequest = $request->validated();
        $this->employee->create($validatedRequest);
        return redirect()->route("employees");
    }

    /**
     * Update employee atributes
     * @param FormRequest
     * @param string id
     * @return Unit
     * 
     * @throws \Exception
    */
    public function update(FormRequest $request, $id)
    {
        $employee = $this->employee->findOrFail($id);
        $validatedData = $request->validateWithBag('unit', [
            "name" => "required",
            "email" => "required|email|unique:employees,email,".$id,
            "cpf" => [
                "required",
                "regex:/^\d{11}$|^\d{3}\.\d{3}\.\d{3}\-\d{2}$/",
                "unique:employees,cpf,".$id
            ],
            "unit_id" => "required|exists:units,id",
        ]);
        $employee->update($validatedData);
        return redirect()->route("employees", ['message' => 'Colaborador atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     * @param string id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $employee = $this->employee->find($id);
        if ($employee == null) {
            return redirect()->route("employees", ['error' => "Colaborador não encontrado !"]);
        }
        $employee->delete();
        return redirect()->route("employees", ["message" => "Colaborador removido com sucesso !"]);
    }
}
