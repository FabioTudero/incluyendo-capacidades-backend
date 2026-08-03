<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'client_id',
        'date',
    ];

    protected $appends = ['total', 'total_hours'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(InvoiceLine::class);
    }

    public function getTotalAttribute(): float
    {
        return $this->lines->sum(fn (InvoiceLine $line) => $line->hours * $line->price);
    }

    public function getTotalHoursAttribute(): float
    {
        return $this->lines->sum('hours');
    }
}
