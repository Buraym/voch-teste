<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class EmployeeObserver
{
    /**
     * Handle the Employee "created" event.
     */
    public function created(Employee $employee): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'model_type' => get_class($employee),
            'model_id' => $employee->id,
            'action' => 'created',
            'description' => "Criou o colaborador '".$employee->name."'",
            'old_values' => null,
            'new_values' => $employee->getAttributes(),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Employee "updated" event.
     */
    public function updated(Employee $employee): void
    {
        $old_values = $employee->getAttributes();
        foreach ($employee->getChanges() as $key => $_value) {
            $old_values[$key] = $employee->getOriginal()[$key];
        }
        AuditLog::create([
            'user_id' => Auth::id(),
            'model_type' => get_class($employee),
            'model_id' => $employee->id,
            'action' => 'updated',
            'description' => "Alterou o colaborador '".$old_values["name"]."'",
            'old_values' => $old_values,
            'new_values' => $employee->getAttributes(),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Employee "deleted" event.
     */
    public function deleted(Employee $employee): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'model_type' => get_class($employee),
            'model_id' => $employee->id,
            'action' => 'deleted',
            'description' => "Deletou o colaborador '".$employee->name."'",
            'old_values' => $employee->getAttributes(),
            'new_values' => null,
            'ip_address' => request()->ip(),
        ]);
    }
}