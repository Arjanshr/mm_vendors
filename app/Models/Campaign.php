<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
        'background_image',
        'color_theme',
        'campaign_banner',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('campaign_price')
            ->withTimestamps(); // If pivot table has timestamps
    }

    public function scopeNotStarted($query)
    {
        return $query->where('start_date', '>', now());
    }

    public function scopeRunning($query)
    {
        return $query->where('status', 'active') // Fixed enum check
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', now());
    }

    public function scopeTimeUntilStart($query)
    {
        return $query->selectRaw('TIMESTAMPDIFF(SECOND, NOW(), start_date) AS time_until_start');
    }

    public function scopeTimeSinceStarted($query)
    {
        return $query->selectRaw('TIMESTAMPDIFF(SECOND, start_date, NOW()) AS time_since_started');
    }

    public function scopeTimeUntilExpiry($query)
    {
        return $query->selectRaw('TIMESTAMPDIFF(SECOND, NOW(), end_date) AS time_until_expiry');
    }

    public function scopeTimeSinceExpired($query)
    {
        return $query->selectRaw('TIMESTAMPDIFF(SECOND, end_date, NOW()) AS time_since_expired');
    }

    public function hasStarted(): bool
    {
        return $this->start_date <= now();
    }

    // Accessors
    public function getTimeUntilStartAttribute()
    {
        return Carbon::parse($this->start_date)->diffForHumans(now(), true);
    }

    public function getTimeSinceStartedAttribute()
    {
        return Carbon::parse($this->start_date)->diffForHumans(now(), true);
    }

    public function getTimeUntilExpiryAttribute()
    {
        return Carbon::parse($this->end_date)->diffForHumans(now(), true);
    }

    public function getTimeSinceExpiredAttribute()
    {
        return Carbon::parse($this->end_date)->diffForHumans(now(), true);
    }
}
