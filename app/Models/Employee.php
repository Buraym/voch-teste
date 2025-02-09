<?php

namespace App\Models;

use App\Observers\EmployeeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([EmployeeObserver::class])]
class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ["name", "email", "cpf", "unit_id"];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
