<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NotificationController extends BaseController
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth'); // Now works!
    }

    public function index()
    {
        $notifications = Auth::user()->notifications() // Now works!
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'notifications' => $notifications
        ]);
    }

    /**
     * Get single notification
     */
    public function show(Notification $notification)
    {
        $this->authorize('view', $notification);

        return response()->json([
            'status' => 'success',
            'notification' => $notification
        ]);
    }

    /**
     * Create new notification
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'link' => 'nullable|url',
        ]);

        $notification = Notification::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Notification created successfully',
            'notification' => $notification
        ], 201);
    }

    /**
     * Update notification
     */
    public function update(Request $request, Notification $notification)
    {
        $this->authorize('update', $notification);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'message' => 'sometimes|string',
            'link' => 'nullable|url',
            'is_read' => 'sometimes|boolean'
        ]);

        $notification->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Notification updated successfully',
            'notification' => $notification
        ]);
    }

    /**
     * Delete notification
     */
    public function destroy(Notification $notification)
    {
        $this->authorize('delete', $notification);

        $notification->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Notification deleted successfully'
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification)
    {
        $this->authorize('update', $notification);

        $notification->update(['is_read' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'Notification marked as read'
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Auth::user()->notifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'All notifications marked as read'
        ]);
    }
}