<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    protected $fillable = ['slug', 'title', 'region', 'country', 'duration_days', 'summary', 'field_note'];

    public function days(): HasMany
    {
        return $this->hasMany(ItineraryDay::class)->orderBy('day');
    }

    public function lines(): HasMany
    {
        return $this->hasMany(TourLine::class)->orderBy('sort');
    }

    public function departures(): HasMany
    {
        return $this->hasMany(Departure::class)->orderBy('start_date');
    }

    public function diaryEntries(): HasMany
    {
        return $this->hasMany(DiaryEntry::class);
    }

    public function inclusions(): HasMany
    {
        return $this->lines()->where('kind', 'inclusion');
    }

    public function exclusions(): HasMany
    {
        return $this->lines()->where('kind', 'exclusion');
    }

    public function priceFrom(): int
    {
        return (int) $this->departures->min('price_per_person');
    }
}
