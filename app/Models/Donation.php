<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'donor_name', 'donor_phone', 'donor_email', 'package',
        'custom_amount', 'commitment_type', 'payment_method',
        'transfer_proof', 'admin_proof', 'status', 'notes',
        'confirmed_by', 'confirmed_at',
    ];

    protected function casts(): array
    {
        return [
            'custom_amount' => 'decimal:2',
            'confirmed_at' => 'datetime',
        ];
    }

    public function confirmedByUser()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function testimonial()
    {
        return $this->hasOne(Testimonial::class);
    }

    public function getPackageLabelAttribute(): string
    {
        return match($this->package) {
            'level_01' => 'Sahabat Misi (Rp 500.000)',
            'level_02' => 'Sayap Kasih (Rp 5.000.000)',
            'level_03' => 'Duta Dirgantara (Rp 10.000.000+)',
            'custom' => 'Mitra Sukarela (Rp ' . number_format($this->custom_amount, 0, ',', '.') . ')',
            default => $this->package,
        };
    }

    public function getAmountAttribute(): float
    {
        return match($this->package) {
            'level_01' => 500000,
            'level_02' => 5000000,
            'level_03' => 10000000,
            'custom' => (float) $this->custom_amount,
            default => 0,
        };
    }
}
