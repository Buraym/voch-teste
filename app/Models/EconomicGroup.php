<?php

namespace App\Models;

use App\Observers\EconomicGroupObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([EconomicGroupObserver::class])]
class EconomicGroup extends Model
{
    use HasFactory;
    protected $fillable = ["name"];

    public function flags(): HasMany
    {
        return $this->hasMany(Flag::class)->chaperone();
    }
}
