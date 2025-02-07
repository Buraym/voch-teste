<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSimpleReportRequest;
use App\Http\Requests\StoreUnitReportRequest;
use App\Models\Employee;
use App\Models\Report;
use App\Models\Unit;
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
     * Store a newly created unit report in storage
     *
     * @param  \App\Http\Requests\StoreUnitReportRequest $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
    */
    public function unit(StoreUnitReportRequest $request) {

        $validatedRequest = $request->validated();
        
        $selectedEmployeeIds = $validatedRequest["employees"];

        $selectedUnits = Unit::whereIn("id", $validatedRequest["units"])
            ->with(['employees' => function ($query) use ($selectedEmployeeIds) {
                $query->whereIn('id', $selectedEmployeeIds);
            }])
            ->get();

        // dd($selectedUnits);

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

        foreach ($selectedUnits as $key => $unit) {
            if ($key == 0) {
                $sheet = $spreadsheet->getActiveSheet();
            } else {
                $sheet = $spreadsheet->createSheet();
            }

            $sheet->setTitle(mb_strlen($unit->name) <= 35 ? mb_strtoupper($unit->name) : substr($unit->name, 0, 35));

            $unitReportTitle = new RichText();
            $boldText = $unitReportTitle->createTextRun("REPORTE DE COLABORADORES DA EMPRESA ");
            $boldText->getFont()->setBold(true);
            $boldAnditalicText = $unitReportTitle->createTextRun(mb_strtoupper($unit->name));
            $boldAnditalicText->getFont()->setBold(true);
            $boldAnditalicText->getFont()->setItalic(true);

            $sheet->setCellValue('A1', $unitReportTitle);
            $sheet->mergeCells('A1:D1');
            $sheet->getStyle('A1')->applyFromArray($allImportStyles);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
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
            $sheet->mergeCells('C2:D2');
            $sheet->setCellValue('C2', $createdByReportText);
            $sheet->getStyle('C2:D2')->applyFromArray($allImportStyles);

            $unitNameReportText = new RichText();
            $boldText = $unitNameReportText->createTextRun("NOME FANTASIA: ");
            $unitNameReportText->createText($unit->name);
            $boldText->getFont()->setBold(true);
            $sheet->mergeCells('A3');
            $sheet->setCellValue('A3', $unitNameReportText);
            $sheet->getStyle('A3')->applyFromArray($allImportStyles);

            $unitSocialReportText = new RichText();
            $boldText = $unitSocialReportText->createTextRun("RAZÃO SOCIAL: ");
            $unitSocialReportText->createText($unit->social);
            $boldText->getFont()->setBold(true);
            $sheet->mergeCells('B3');
            $sheet->setCellValue('B3', $unitSocialReportText);
            $sheet->getStyle('B3')->applyFromArray($allImportStyles);

            $unitCNPJReportText = new RichText();
            $boldText = $unitCNPJReportText->createTextRun("CNPJ: ");
            $unitCNPJReportText->createText($unit->cnpj);
            $boldText->getFont()->setBold(true);
            $sheet->mergeCells('C3');
            $sheet->setCellValue('C3', $unitCNPJReportText);
            $sheet->getStyle('C3')->applyFromArray($allImportStyles);

            $unitFlagReportText = new RichText();
            $boldText = $unitFlagReportText->createTextRun("BANDEIRA: ");
            $unitFlagReportText->createText($unit->flag->name);
            $boldText->getFont()->setBold(true);
            $sheet->mergeCells('D3');
            $sheet->setCellValue('D3', $unitFlagReportText);
            $sheet->getStyle('D3')->applyFromArray($allImportStyles);

            $sheet->mergeCells('A4:D4');
            $sheet->getStyle('A4:D4')->applyFromArray($commonEvenImportStyles);

            $sheet->setCellValue('A5', '# ID');
            $sheet->getStyle('A5')->applyFromArray($allImportStyles);
            $sheet->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('A5')->getFont()->setBold(true);

            $sheet->setCellValue('B5', 'NOME');
            $sheet->getStyle('B5')->applyFromArray($allImportStyles);
            $sheet->getStyle('B5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B5')->getFont()->setBold(true);

            $sheet->setCellValue('C5', 'EMAIL');
            $sheet->getStyle('C5')->applyFromArray($allImportStyles);
            $sheet->getStyle('C5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C5')->getFont()->setBold(true);

            $sheet->setCellValue('D5', 'CPF');
            $sheet->getStyle('D5')->applyFromArray($allImportStyles);
            $sheet->getStyle('D5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D5')->getFont()->setBold(true);

            $sheet->freezePane('A6');

            foreach ($unit->employees as $index => $employee) {
                $sheet->setCellValue('A'.$index + 6, $employee["id"]);
                $sheet->getStyle('A'.$index + 6)->applyFromArray($index % 2 == 0 ? $commonEvenImportStyles : $commonOddImportStyles);
                $sheet->getStyle('A'.$index + 6)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('A'.$index + 6)->getFont()->setBold(true);

                $sheet->setCellValue('B'.$index + 6, $employee["name"]);
                $sheet->getStyle('B'.$index + 6)->applyFromArray($index % 2 == 0 ? $commonEvenImportStyles : $commonOddImportStyles);
                $sheet->getStyle('B'.$index + 6)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('C'.$index + 6, $employee["email"]);
                $sheet->getStyle('C'.$index + 6)->applyFromArray($index % 2 == 0 ? $commonEvenImportStyles : $commonOddImportStyles);
                $sheet->getStyle('C'.$index + 6)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('D'.$index + 6, $employee["cpf"]);
                $sheet->getStyle('D'.$index + 6)->applyFromArray($index % 2 == 0 ? $commonEvenImportStyles : $commonOddImportStyles);
                $sheet->getStyle('D'.$index + 6)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            }
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
