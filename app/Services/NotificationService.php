<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    /**
     * Create an in-app notification.
     */
    public static function notify(
        string $title,
        string $description = '',
        string $type = 'info',   // info | success | warning | danger
        string $icon = 'heroicon-o-bell',
        string $link = '',
        ?int $userId = null,
        string $businessId = 'ST-001'
    ): void {
        Notification::create([
            'business_id' => $businessId,
            'user_id'     => $userId,
            'title'       => $title,
            'description' => $description,
            'icon'        => $icon,
            'link'        => $link,
            'type'        => $type,
            'is_read'     => false,
        ]);
    }

    public static function success(string $title, string $desc = '', string $link = ''): void
    {
        static::notify($title, $desc, 'success', 'heroicon-o-check-circle', $link);
    }

    public static function warning(string $title, string $desc = '', string $link = ''): void
    {
        static::notify($title, $desc, 'warning', 'heroicon-o-exclamation-triangle', $link);
    }

    public static function danger(string $title, string $desc = '', string $link = ''): void
    {
        static::notify($title, $desc, 'danger', 'heroicon-o-x-circle', $link);
    }

    public static function info(string $title, string $desc = '', string $link = ''): void
    {
        static::notify($title, $desc, 'info', 'heroicon-o-information-circle', $link);
    }
}

