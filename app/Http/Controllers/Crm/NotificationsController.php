<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(30);
        $unread = Notification::where('is_read', false)->count();
        return view('crm.notifications.index', compact('notifications', 'unread'));
    }

    public function markRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);
        return back();
    }

    public function readAll()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'All notifications marked as read.');
    }
}

