<?php

namespace App\Filament\Pages;

use App\Models\Notification;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;

class NotificationsInbox extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-bell';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Notifications';
    protected static ?string $title           = 'Notifications Inbox';
    protected static ?int    $navigationSort  = 10;
    protected static string  $view            = 'filament.pages.notifications-inbox';

    public static function getNavigationBadge(): ?string
    {
        $count = Notification::unread()->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return Notification::unread()->count() > 0 ? 'danger' : null;
    }

    public function getNotifications()
    {
        return Notification::latest()->limit(60)->get();
    }

    public function markRead(int $id): void
    {
        Notification::where('id', $id)->update(['is_read' => true]);
        FilamentNotification::make()->title('Marked as read')->success()->send();
    }

    public function markAllRead(): void
    {
        Notification::unread()->update(['is_read' => true]);
        FilamentNotification::make()->title('All notifications marked as read')->success()->send();
    }

    public function deleteNotification(int $id): void
    {
        Notification::destroy($id);
    }

    public function clearAll(): void
    {
        Notification::truncate();
        FilamentNotification::make()->title('All notifications cleared')->success()->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('markAllRead')
                ->label('Mark All Read')
                ->icon('heroicon-o-check')
                ->color('success')
                ->action('markAllRead'),

            Action::make('clearAll')
                ->label('Clear All')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->action('clearAll'),
        ];
    }
}

