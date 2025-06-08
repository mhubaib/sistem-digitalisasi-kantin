<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Create a notification for admin
     *
     * @param string $type
     * @param string $title
     * @param string $message
     * @param mixed $data
     * @return Notification|null
     */
    public function createForAdmin($type, $title, $message, $data = null)
    {
        // Find admin user
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            return Notification::create([
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

    /**
     * Create a notification for wali
     *
     * @param int $wali_id
     * @param string $type
     * @param string $title
     * @param string $message
     * @param mixed $data
     * @return Notification|null
     */
    public function createForWali($wali_id, $type, $title, $message, $data = null)
    {
        $wali = User::where('id', $wali_id)->where('role', 'wali')->first();

        if ($wali) {
            return Notification::create([
                'user_id' => $wali->id,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'data' => $data,
                'is_read' => false
            ]);
        }

        return null;
    }

    /**
     * Create a notification for santri
     *
     * @param int $santri_id
     * @param string $type
     * @param string $title
     * @param string $message
     * @param mixed $data
     * @return Notification|null
     */
    public function createForSantri($santri_id, $type, $title, $message, $data = null)
    {
        $santri = User::where('id', $santri_id)->where('role', 'santri')->first();

        if ($santri) {
            return Notification::create([
                'user_id' => $santri->id,
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
