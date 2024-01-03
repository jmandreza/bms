<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\User;

class NotificationController extends Controller
{
    public function unreadNotification()
    {
        $notifications = Auth::user()->unreadNotifications;
        $users = User::with('resident')->whereIn('id', $notifications->pluck('data.id', 'data.id')->toArray())->get()->keyBy('id');
        
        $count = $notifications->count();
        $view = view('notification.notification')->with(['notifications' => $notifications, 'users' => $users])->render();
        
        return response()->json(['view' => $view, 'count' => $count]);
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        try {
            $notification->markAsRead();
            $notification->save();
            return redirect($notification->data['link']);
        }
        catch(\Exception $e) {
            return redirect()->back();
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $notifications = Auth::user()->fresh()->unreadNotifications;
        $users = User::with('resident')->whereIn('id', $notifications->pluck('data.id', 'data.id')->toArray())->get()->keyBy('id');
        
        $count = $notifications->count();
        $view = view('notification.notification')->with(['notifications' => $notifications, 'users' => $users])->render();
        return response()->json(["view" => $view, "count" => $count]);
    }
}
