<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'is_read',
        'data'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Method to create a notification
    public static function createForAdmin($type, $title, $message, $data = null)
    {
        // Find admin user
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            return self::create([
                'user_id' => $admin->id,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'data' => $data,
                'is_read' => false
            ]);
        }

        return null;
    }
}
