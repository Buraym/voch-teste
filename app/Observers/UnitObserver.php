<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;

class UnitObserver
{
    /**
     * Handle the Unit "created" event.
     */
    public function created(Unit $unit): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'model_type' => get_class($unit),
            'model_id' => $unit->id,
            'action' => 'created',
            'description' => "Criou a unidade '".$unit->name."'",
            'old_values' => null,
            'new_values' => $unit->getAttributes(),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Unit "updated" event.
     */
    public function updated(Unit $unit): void
    {
        $old_values = $unit->getAttributes();
        foreach ($unit->getChanges() as $key => $_value) {
            $old_values[$key] = $unit->getOriginal()[$key];
        }
        AuditLog::create([
            'user_id' => Auth::id(),
            'model_type' => get_class($unit),
            'model_id' => $unit->id,
            'action' => 'updated',
            'description' => "Alterou a unidade '".$old_values["name"]."'",
            'old_values' => $old_values,
            'new_values' => $unit->getAttributes(),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Unit "deleted" event.
     */
    public function deleted(Unit $unit): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'model_type' => get_class($unit),
            'model_id' => $unit->id,
            'action' => 'deleted',
            'description' => "Deletou a unidade '".$unit->name."'",
            'old_values' => $unit->getAttributes(),
            'new_values' => null,
            'ip_address' => request()->ip(),
        ]);
    }
}
