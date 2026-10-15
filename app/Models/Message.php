<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Message model for contact form inquiries.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $message
 * @property bool $is_read
 */
class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Scope: unread messages.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
