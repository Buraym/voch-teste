<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\Flag;
use Illuminate\Support\Facades\Auth;

class FlagObserver
{
    /**
     * Handle the Flag "created" event.
     */
    public function created(Flag $flag): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'model_type' => get_class($flag),
            'model_id' => $flag->id,
            'action' => 'created',
            'description' => "Criou a bandeira '".$flag->name."'",
            'old_values' => null,
            'new_values' => $flag->getAttributes(),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Flag "updated" event.
     */
    public function updated(Flag $flag): void
    {
        $old_values = $flag->getAttributes();
        foreach ($flag->getChanges() as $key => $_value) {
            $old_values[$key] = $flag->getOriginal()[$key];
        }
        AuditLog::create([
            'user_id' => Auth::id(),
            'model_type' => get_class($flag),
            'model_id' => $flag->id,
            'action' => 'updated',
            'description' => "Alterou o nome da bandeira '".$old_values["name"]."'",
            'old_values' => $old_values,
            'new_values' => $flag->getAttributes(),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Flag "deleted" event.
     */
    public function deleted(Flag $flag): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'model_type' => get_class($flag),
            'model_id' => $flag->id,
            'action' => 'deleted',
            'description' => "Deletou a bandeira '".$flag->name."'",
            'old_values' => $flag->getAttributes(),
            'new_values' => null,
            'ip_address' => request()->ip(),
        ]);
    }
}
