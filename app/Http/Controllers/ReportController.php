<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSimpleReportRequest;
use App\Models\Report;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private $report;
    public  function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->report->all(), 200);
    }

    /**
     * Find report by id
     *
     * @param  string  $id
     * @return \App\Models\Report
     *
     * @throws \Exception
    */
    public function show($id)
    {
        $report = $this->report->find($id);
        if ($report == null) {
            return response()->json(["error"=> "Reporte não encontrado"],404);
        }
        return response()->json($report, 200);
    }

    /**
     * Store a newly created simple report in storage
     *
     * @param  FormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
    */
    public function simple(StoreSimpleReportRequest $request) {
        return redirect()->route("reports");
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
        
        $reportsFound = $this->report->where("name", "LIKE", "%{$query}%")
            ->get()
            ->map(fn($report) => [$report->id, $report->name, $report->created_at])
            ->toArray();
        
        return redirect()->route("reports", $query == "" ? [] : compact("query", "reportsFound"));
    }

    /**
     * Remove the specified resource from storage.
     * @param string id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $report = $this->report->find($id);
        if ($report == null) {
            return redirect()->route("reports", ['error' => "Reporte não encontrado !"]);
        }
        $report->delete();
        return redirect()->route("reports", ["message" => "Reporte removido com sucesso !"]);
    }
}
