<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSimpleReportRequest;
use App\Models\Employee;
use App\Models\Report;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
     * @param  \App\Http\Requests\StoreSimpleReportRequest $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
    */
    public function simple(StoreSimpleReportRequest $request) {
        $validatedRequest = $request->validated();
        $selectedEmployees = Employee::whereIn("id", $validatedRequest["employees"])
            ->get()
            ->map(
                fn($employee) => [
                    "id" => $employee->id,
                    "name" => $employee->name,
                    "email" => $employee->email,
                    "cpf" => $employee->cpf,
                    "unit" => $employee->unit->name
                ]
        );

        $allImportStyles = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFFF00'],
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $commonOddImportStyles = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD9D9D9'],
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $commonEvenImportStyles = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFFFFF'], // Amarelo
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("REPORTE SIMPLES");
        $sheet->setCellValue('A1', 'REPORTE SIMPLES DE COLABORADORES');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->applyFromArray($allImportStyles);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true);

        $createdAtReportText = new RichText();
        $boldText = $createdAtReportText->createTextRun("CRIADO: ");
        $createdAtReportText->createText(date('d/m/Y - H:i:s'));
        $boldText->getFont()->setBold(true);
        $sheet->mergeCells('A2:B2');
        $sheet->setCellValue('A2', $createdAtReportText);
        $sheet->getStyle('A2:B2')->applyFromArray($allImportStyles);

        $createdByReportText = new RichText();
        $boldText = $createdByReportText->createTextRun("USUARIO: ");
        $createdByReportText->createText($request->all()["user_name"]);
        $boldText->getFont()->setBold(true);
        $sheet->mergeCells('C2:E2');
        $sheet->setCellValue('C2', $createdByReportText);
        $sheet->getStyle('C2:E2')->applyFromArray($allImportStyles);

        $sheet->mergeCells('A3:E3');
        $sheet->getStyle('A3:E3')->applyFromArray($commonEvenImportStyles);

        $sheet->setCellValue('A4', '# ID');
        $sheet->getStyle('A4')->applyFromArray($allImportStyles);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('A4')->getFont()->setBold(true);

        $sheet->setCellValue('B4', 'NOME');
        $sheet->getStyle('B4')->applyFromArray($allImportStyles);
        $sheet->getStyle('B4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B4')->getFont()->setBold(true);

        $sheet->setCellValue('C4', 'EMAIL');
        $sheet->getStyle('C4')->applyFromArray($allImportStyles);
        $sheet->getStyle('C4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C4')->getFont()->setBold(true);

        $sheet->setCellValue('D4', 'CPF');
        $sheet->getStyle('D4')->applyFromArray($allImportStyles);
        $sheet->getStyle('D4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D4')->getFont()->setBold(true);
        
        $sheet->setCellValue('E4', 'UNIDADE');
        $sheet->getStyle('E4')->applyFromArray($allImportStyles);
        $sheet->getStyle('E4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E4')->getFont()->setBold(true);

        $sheet->freezePane('A5');

        foreach ($selectedEmployees as $index => $employee) {
            $sheet->setCellValue('A'.$index + 5, $employee["id"]);
            $sheet->getStyle('A'.$index + 5)->applyFromArray($index % 2 == 0 ? $commonEvenImportStyles : $commonOddImportStyles);
            $sheet->getStyle('A'.$index + 5)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('A'.$index + 5)->getFont()->setBold(true);

            $sheet->setCellValue('B'.$index + 5, $employee["name"]);
            $sheet->getStyle('B'.$index + 5)->applyFromArray($index % 2 == 0 ? $commonEvenImportStyles : $commonOddImportStyles);
            $sheet->getStyle('B'.$index + 5)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('C'.$index + 5, $employee["email"]);
            $sheet->getStyle('C'.$index + 5)->applyFromArray($index % 2 == 0 ? $commonEvenImportStyles : $commonOddImportStyles);
            $sheet->getStyle('C'.$index + 5)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('D'.$index + 5, $employee["cpf"]);
            $sheet->getStyle('D'.$index + 5)->applyFromArray($index % 2 == 0 ? $commonEvenImportStyles : $commonOddImportStyles);
            $sheet->getStyle('D'.$index + 5)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
            $sheet->setCellValue('E'.$index + 5, $employee["unit"]);
            $sheet->getStyle('E'.$index + 5)->applyFromArray($index % 2 == 0 ? $commonEvenImportStyles : $commonOddImportStyles);
            $sheet->getStyle('E'.$index + 5)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        $temp_file = tempnam(sys_get_temp_dir(), 'xlsx');
        $writer = new Xlsx($spreadsheet);
        $writer->save($temp_file);
        $uuid = Str::uuid();
        $path = $validatedRequest["name"].'-'.$uuid.'.xlsx';
        Storage::put($path, file_get_contents($temp_file));
        unlink($temp_file);

        $this->report->create([
            "name" => $validatedRequest["name"],
            "url" => $path
        ]);

        return redirect()->route("reports");
    }

    /**
     * Download a report by its id
     *
     * @param  \App\Http\Requests\StoreSimpleReportRequest $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
    */
    public function download($id) {
        $report = $this->report->find($id);
        if ($report == null) {
            return redirect()->route("reports", ['error' => "Reporte não encontrado !"]);
        }
        
        return Storage::download($report->url);
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
            ->map(fn($report) => [$report->id, $report->name, $report->id, $report->name, $report->url, date('d/m/Y - H:i:s', strtotime($report->created_at))])
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
        Storage::delete($report->url);
        $report->delete();
        return redirect()->route("reports", ["message" => "Reporte removido com sucesso !"]);
    }
}
