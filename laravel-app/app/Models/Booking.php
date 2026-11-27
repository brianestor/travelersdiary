<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'reference', 'tour_id', 'departure_id', 'adults', 'children',
        'lead_name', 'email', 'phone', 'notes', 'status',
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function departure(): BelongsTo
    {
        return $this->belongsTo(Departure::class);
    }
}
