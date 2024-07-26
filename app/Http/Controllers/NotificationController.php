<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notif = Notification::get()->first();
        return $notif;
    }

    public function update(Request $request, Notification $notification)
    {
        $notification->update([
            'notification_name' => $request->notification
        ]);
        $notification->save();
        return $notification;
    }
}
