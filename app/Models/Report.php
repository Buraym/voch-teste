<?php

namespace App\Models;


use App\Observers\ReportObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([ReportObserver::class])]
class Report extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ["name", "url"];
}
