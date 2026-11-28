<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanRequest extends Model
{
    protected $fillable = [
        'reference', 'start_date', 'duration_days', 'safari_type', 'adults', 'children',
        'child_ages', 'budget', 'accommodation', 'first_name', 'last_name', 'email',
        'country_code', 'phone', 'contact_method', 'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'child_ages' => 'array',
    ];

    public function safariLabel(): string
    {
        return [
            'safari' => 'Normal safari',
            'kilimanjaro' => 'Mount Kilimanjaro',
            'zanzibar' => 'Zanzibar',
        ][$this->safari_type] ?? $this->safari_type;
    }

    public function stayLabel(): string
    {
        return [
            'explorer' => 'Explorer',
            'signature' => 'Signature',
            'premium' => 'Premium',
        ][$this->accommodation] ?? $this->accommodation;
    }
}
