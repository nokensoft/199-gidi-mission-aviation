<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['ip_address', 'user_agent', 'page', 'visited_at'];

    protected function casts(): array
    {
        return [
            'visited_at' => 'datetime',
        ];
    }
}
