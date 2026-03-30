<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ChatThread extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'thread_id');
    }

    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class, 'thread_id')->latestOfMany();
    }

    public function requiresAdminAttention(): bool
    {
        return strtoupper((string) $this->latestMessage?->sender_type) === 'USER';
    }

    public static function chatTablesReady(): bool
    {
        return Schema::hasTable('chat_threads') && Schema::hasTable('chat_messages');
    }

    public static function adminAttentionCount(): int
    {
        if (! static::chatTablesReady()) {
            return 0;
        }

        return static::query()
            ->with('latestMessage')
            ->get()
            ->filter(fn (self $thread) => $thread->requiresAdminAttention())
            ->count();
    }
}
