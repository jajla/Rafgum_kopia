<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    /** @use HasFactory<\Database\Factories\StorageFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'tire_size',
        'tire_owner',
    ];
    public function tires()
    {
        return $this->belongsTo(User::class,'tire_owner');
    }

}
