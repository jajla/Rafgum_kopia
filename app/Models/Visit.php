<?php

namespace App\Models;

use App\Enums\Services;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'time',
        'service_type',
    ];

    protected function casts(): array
    {
        return [
            'service_type' => Services::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
