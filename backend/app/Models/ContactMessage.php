<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'topic',
        'message',
        'is_read',
        'read_at',
        'ip_address',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function markAsRead(): void
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('is_read', false);
    }
}
