<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'price_service_client')
                    ->withPivot('price')
                    ->withTimestamps();
    }
}
