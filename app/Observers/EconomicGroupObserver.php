<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\EconomicGroup;
use Illuminate\Support\Facades\Auth;

class EconomicGroupObserver
{
    /**
     * Handle the Model "created" event.
     */
    public function created(EconomicGroup $model): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => 'created',
            'description' => "Criou o grupo econômico '".$model->name."'",
            'old_values' => null,
            'new_values' => $model->getAttributes(),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Model "updated" event.
     */
    public function updated(EconomicGroup $model): void
    {
        $old_values = $model->getAttributes();
        foreach ($model->getChanges() as $key => $_value) {
            $old_values[$key] = $model->getOriginal()[$key];
        }
        AuditLog::create([
            'user_id' => Auth::id(),
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => 'updated',
            'description' => "Alterou o nome do grupo econômico '".$old_values["name"]."'",
            'old_values' => $old_values,
            'new_values' => $model->getAttributes(),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Model "deleted" event.
     */
    public function deleted(EconomicGroup $model): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => 'deleted',
            'description' => "Deletou o grupo econômico '".$model->name."'",
            'old_values' => $model->getAttributes(),
            'new_values' => null,
            'ip_address' => request()->ip(),
        ]);
    }
}
