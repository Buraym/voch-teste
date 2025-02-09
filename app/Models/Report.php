<?php

namespace App\Models;


use App\Observers\ReportObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([ReportObserver::class])]
class Report extends Model
{
    use HasFactory;
    protected $fillable = ["name", "url"];
}
