<?php

namespace App\Models;

use Database\Factories\AnalyticFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Analytic extends Model
{
    /** @use HasFactory<AnalyticFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'link_id',
        'user_agent',
    ];

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }
}
