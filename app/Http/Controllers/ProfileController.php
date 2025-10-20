<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    // update profile
    public function updateProfile(Request $request)
    {
        // find user by id
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        // validate request
        $validated = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'gender' => 'sometimes|in:male,female,other',
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string|max:500',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',

        ]);

        // if validation fails
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        // update user
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->address = $request->address;
        // handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('profile_images', 'public');
            $user->image = Storage::url($imagePath);
        }

        // save user
        $user->save();
        return response()->json(
            [
                'message' => 'Profile updated successfully',
                'user' => $user
            ],
            200
        );

    }
}
