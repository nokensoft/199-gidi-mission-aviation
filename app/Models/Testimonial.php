<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'donation_id', 'name', 'role_title', 'content',
        'visibility', 'is_approved', 'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->visibility === 'anonymous' ? 'Anonim' : $this->name;
    }
}
