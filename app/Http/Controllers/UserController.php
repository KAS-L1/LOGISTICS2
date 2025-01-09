<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Get all users
    public function index()
    {
        $users = User::paginate(10); // Paginate results for better API response
        return response()->json($users, 200);
    }

    // Get a single user by ID
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    // Create a new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'username' => 'nullable|string|unique:users,username|max:50', // Added optional username
            'status' => 'nullable|in:Active,Inactive,Pending',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'username' => $validated['username'] ?? strtolower($validated['first_name']) . '.' . strtolower($validated['last_name']), // Generate username if not provided
            'status' => $validated['status'] ?? 'Pending',
        ]);

        return response()->json($user, 201);
    }

    // Update user details

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate input
        $request->validate([
            'profile_picture' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048', // 2MB max
            ],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'contact' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                // Delete old picture if exists
                if ($user->profile_picture) {
                    Storage::disk('public')->delete($user->profile_picture);
                }

                $image = Image::make($request->file('profile_picture'));

                // Check minimum dimensions
                if ($image->width() < 200 || $image->height() < 200) {
                    return back()->withErrors(['profile_picture' => 'Image dimensions should be at least 200x200 pixels']);
                }

                // Resize if image exceeds maximum dimensions while maintaining aspect ratio
                if ($image->width() > 2000 || $image->height() > 2000) {
                    $image->resize(2000, 2000, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }

                // Generate filename
                $filename = 'profile_' . uniqid() . '.' . $request->file('profile_picture')->getClientOriginalExtension();
                $path = 'profile_pictures/' . $filename;

                // Save the image with proper quality and format
                if ($request->file('profile_picture')->getClientOriginalExtension() == 'png') {
                    // For PNG, maintain transparency
                    $image->encode('png');
                    Storage::disk('public')->put($path, $image->stream('png'));
                } else {
                    // For JPEG/JPG, optimize quality
                    $image->encode('jpg', 80); // 80% quality
                    Storage::disk('public')->put($path, $image->stream('jpg'));
                }

                $user->profile_picture = $path;
            }

            // Update user details
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'contact' => $request->contact,
                'address' => $request->address,
                'company' => $request->company,
                'status' => $request->status,
            ]);

            return back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update profile. Please try again. Error: ' . $e->getMessage());
        }
    }




    // Delete a user
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    // Assign a role to a user
    public function assignRole(Request $request, $user_id)
    {
        // Validate the request
        $validated = $request->validate([
            'roles' => 'required|array', // Validate as an array
            'roles.*' => 'exists:roles,name', // Each role must exist in the roles table
        ]);

        // Find the user by user_id
        $user = User::where('user_id', $user_id)->firstOrFail();

        // Assign roles
        $user->syncRoles($validated['roles']); // Replaces any existing roles with new ones

        return response()->json([
            'message' => 'Roles assigned successfully',
            'roles' => $user->getRoleNames() // Returns the assigned roles
        ], 200);
    }



    // Remove a specific role from a user
    public function removeRole(Request $request, $userId)
    {
        $validated = $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->removeRole($validated['role']);

        return response()->json(['message' => 'Role removed successfully.'], 200);
    }
}
