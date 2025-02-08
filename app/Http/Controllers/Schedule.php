<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Create a new schedule.
     */
    public function createSchedule(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'dep_id' => 'required|exists:departments,id', // Ensure dep_id exists in departments table
            'title' => 'required|string|max:255',
            'link_image' => 'nullable|url', // Optional URL validation
        ]);

        // Create the schedule
        $schedule = Schedule::create([
            'dep_id' => $validatedData['dep_id'],
            'title' => trim($validatedData['title']), // Trim whitespace
            'link_image' => $validatedData['link_image'] ?? null, // Handle optional field
        ]);

        // Return response with created schedule data
        return response()->json([
            'message' => 'Schedule created successfully',
            'schedule' => $schedule,
        ]);
    }
}