<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        // Fetch unread notifications for the current admin
        $notifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'notifications' => $notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'icon' => $this->getNotificationIcon($notification->type),
                    'bgClass' => $this->getNotificationBgClass($notification->type),
                    'iconColor' => $this->getNotificationIconColor($notification->type)
                ];
            }),
            'total_unread' => $notifications->count()
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        // Mark all unread notifications for the current user as read
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }

    // Helper methods to determine icon and background
    private function getNotificationIcon($type)
    {
        $icons = [
            'santri_registration' => 'fa-user-plus',
            'santri_transaction' => 'fa-shopping-cart',
            'topup' => 'fa-money-bill-wave',
            // Add more types as needed
        ];
        return $icons[$type] ?? 'fa-bell';
    }

    private function getNotificationBgClass($type)
    {
        $bgClasses = [
            'santri_registration' => 'bg-green-100',
            'santri_transaction' => 'bg-blue-100',
            'topup' => 'bg-emerald-100',
            // Add more types as needed
        ];
        return $bgClasses[$type] ?? 'bg-blue-100';
    }

    private function getNotificationIconColor($type)
    {
        $iconColors = [
            'santri_registration' => 'text-green-600',
            'santri_transaction' => 'text-blue-600',
            'topup' => 'text-emerald-600',
            // Add more types as needed
        ];
        return $iconColors[$type] ?? 'text-blue-600';
    }
}
