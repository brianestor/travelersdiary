<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItineraryDay extends Model
{
    public $timestamps = false;

    protected $fillable = ['tour_id', 'day', 'title', 'body'];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
