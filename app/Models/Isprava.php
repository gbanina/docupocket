<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Isprava extends Model
{
    use HasFactory;

    protected $table = 'isprave';

    protected $fillable = [
        'user_id',
        'name',
        'category',
        'document_number',
        'issuer',
        'issued_at',
        'expires_at',
        'reminder_enabled',
        'reminder_days',
        'note',
        'front_image_path',
        'back_image_path',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'date',
            'expires_at' => 'date',
            'reminder_enabled' => 'boolean',
            'reminder_days' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
