<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;



class Admin extends Controller
{
    public function newStudent(Request $req)
    {
        // Validate input
        $validatedData = $req->validate([
            'names' => 'required|array',
            'names.*' => 'required|string|max:255',
        ]);

        $namesArray = array_map('trim', $validatedData['names']);

        // Loop through names and create users with random 4-digit passwords
        $users = [];
        foreach ($namesArray as $name) {
            $password = random_int(100000, 999999); // Generate a random 4-digit password
            $hashed_password=bcrypt($password);

            $user = User::create([
                'name' => $name,
                'password' => $hashed_password,
            ]);

            // Add user info with plain-text password for returning or logging purposes
            $users[] = [
                'name' => $name,
                'password' => $password, // Plain-text password
            ];
        }

        // Return the created users with their generated passwords
        return response()->json([
            'message' => 'Users created successfully',
            'users' => $users,
        ]);
    }
}
