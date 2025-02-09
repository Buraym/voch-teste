<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportObserver
{
    /**
     * Handle the Report "created" event.
     */
    public function created(Report $report): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'model_type' => get_class($report),
            'model_id' => $report->id,
            'action' => 'created',
            'description' => "Criou o reporte '".$report->name."'",
            'old_values' => null,
            'new_values' => $report->getAttributes(),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Report "deleted" event.
     */
    public function deleted(Report $report): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'model_type' => get_class($report),
            'model_id' => $report->id,
            'action' => 'deleted',
            'description' => "Deletou o reporte '".$report->name."'",
            'old_values' => $report->getAttributes(),
            'new_values' => null,
            'ip_address' => request()->ip(),
        ]);
    }
}
