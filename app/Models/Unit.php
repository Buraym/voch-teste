<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;
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
