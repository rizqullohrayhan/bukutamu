<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GuestBook extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];
    public function problemCategory(): BelongsTo
    {
        return $this->belongsTo(ProblemCategory::class);
    }
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }
}
