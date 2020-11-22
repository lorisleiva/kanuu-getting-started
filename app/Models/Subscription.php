<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    // Disable mass-assignment exceptions.
    protected $guarded = [];

    // Cast 'cancelled_at' to a Carbon instance.
    protected $dates = ['cancelled_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', 'active');
    }

    public function onGracePeriod(): bool
    {
        return $this->cancelled_at
            && $this->cancelled_at->isFuture();
    }
}
