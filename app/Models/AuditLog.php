<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'model_type',
        'model_id',
        'action',
        'description',
        'old_values',
        'new_values',
        'ip_address'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
