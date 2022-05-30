<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->get('id') ? $request->get('id') : null;
        $notifications = auth()->user()->notifications;
        return Inertia::render('Notification/Index', compact(['notifications', 'id']));
    }

    public function markAsRead(Request $request) {
        $id = $request->get('id');
        $notification = auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);

        return response()->json([
            "notification" => $notification
        ]);
    }

    public function markAllAsRead(Request $request) {
        $all_notifications = $request->get('not_read');

        $array = [];

        foreach ($all_notifications as $notification) {
            $new = auth()->user()->notifications()->where('id', $notification["id"])->update(['read_at' => now()]);
            $new2 = auth()->user()->notifications()->where('id', $notification["id"])->first();
            $array[] = $new2;
        }

        return response()->json([
            "notifications_read" => $array
        ]);
    }
}
