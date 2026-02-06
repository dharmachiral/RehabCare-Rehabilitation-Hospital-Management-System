<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Student\Entities\Student;
use Modules\User\Rules\MatchCurrentPassword;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        // For students (role_id=7), load student data and return student profile view
        if ($user->role_id == 7) {
            $student = Student::where('user_id', $user->id)->first();
            return view('user::profile2', compact('user', 'student'));
        }

        // For regular users
        return view('user::profile', compact('user'));
    }

   public function update(Request $request)
{
    $user = Auth::user();

    // ✅ Validation
    $rules = [
        'email' => 'required|email|unique:users,email,' . $user->id,
    ];

    if ($user->role_id == 7) {
        // Student validation
        $rules['full_name'] = 'required|string|max:255';
        $rules['student_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
    } else {
        // Other user validation
        $rules['name'] = 'required|string|max:255';
        $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
    }

    $validated = $request->validate($rules);

    // ✅ Update common user fields
    $updateData = ['email' => $validated['email']];

    if ($user->role_id != 7) {
        $updateData['name'] = $validated['name'];
    }

    // ✅ Handle image for regular users (not students)
    if ($user->role_id != 7 && $request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

        $uploadPath = public_path('upload/images/users');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Delete old image
        if ($user->image && file_exists($uploadPath . '/' . $user->image)) {
            unlink($uploadPath . '/' . $user->image);
        }

        $image->move($uploadPath, $imageName);
        $updateData['image'] = $imageName;
    }

    // ✅ Save user data
    $user->update($updateData);

    // ✅ If student, update student profile too
    if ($user->role_id == 7) {
        $student = Student::where('user_id', $user->id)->first();

        if ($student) {
            $studentData = [
                'full_name' => $validated['full_name'],
            ];

            if ($request->hasFile('student_image')) {
                $image = $request->file('student_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                $uploadPath = public_path('upload/images/Students');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Delete old student image
                if ($student->image && file_exists($uploadPath . '/' . $student->image)) {
                    unlink($uploadPath . '/' . $student->image);
                }

                $image->move($uploadPath, $imageName);
                $studentData['image'] = $imageName;
            }

            $student->update($studentData);
        }
    }

    return back()->with('success', 'Profile updated successfully.');
}


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'max:255', new MatchCurrentPassword()],
            'password' => 'required|min:8|max:255|confirmed'
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        // Logout after password change
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Password changed successfully. Please login again.');
    }
}