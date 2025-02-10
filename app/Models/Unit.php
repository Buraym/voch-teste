<?php

namespace App\Models;

use App\Observers\UnitObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([UnitObserver::class])]
class Unit extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ["name", "social", "cnpj", "flag_id"];

    public function flag(): BelongsTo
    {
        return $this->belongsTo(Flag::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class)->chaperone();
    }
}
