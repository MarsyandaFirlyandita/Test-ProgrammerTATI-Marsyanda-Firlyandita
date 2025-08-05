<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogHarian extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'user_id',
        'tanggal',
        'kegiatan',
        'status',
    ];

    /**
     * Relasi: Log harian dimiliki oleh user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
