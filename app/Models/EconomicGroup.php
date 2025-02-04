<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EconomicGroup extends Model
{
    use HasFactory;
    protected $fillable = ["name"];

    public function rules()
    {
        return [
            "name" => "required",
        ];
    }

    public function feedback()
    {
        return [
            "required" => "O campo :attribute é obrigatório",
        ];
    }
}
