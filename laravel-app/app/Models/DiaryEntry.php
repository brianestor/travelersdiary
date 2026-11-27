<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiaryEntry extends Model
{
    public $timestamps = false;

    protected $fillable = ['slug', 'title', 'place', 'entry_date', 'tour_id', 'paragraphs'];

    protected $casts = [
        'entry_date' => 'date',
        'paragraphs' => 'array',
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
