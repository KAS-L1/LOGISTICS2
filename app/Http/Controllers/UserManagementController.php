<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    /** index page */
    public function userProfilePage()
    {
        return view('usermanagement.users-profile');
    }

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
}
