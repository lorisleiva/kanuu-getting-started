<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['cancelled_at'];

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
