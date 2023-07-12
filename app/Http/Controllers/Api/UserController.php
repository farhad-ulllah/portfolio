<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $activeReferrals = $user->activeReferrals()->get();
        $successfulReferrals = $user->successfulReferrals()->get();
        $declinedReferrals = $user->declinedReferrals()->get();
        $totalReferrals = $user->totalReferrals();
        $totalEarnings = $user->totalEarnings();
        $thisMonthEarnings = $user->thisMonthEarnings();

        $dashboardData = [
            'active_referrals' => $activeReferrals,
            'successful_referrals' => $successfulReferrals,
            'declined_referrals' => $declinedReferrals,
            'total_referrals' => $totalReferrals,
            'total_earnings' => $totalEarnings,
            'this_month_earnings' => $thisMonthEarnings,
        ];

        return response()->json($dashboardData);
    }
    //Update User Profile
    public function updateProfile(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'old_password' => ['nullable', 'string', function ($attribute, $value, $fail) use ($user) {
                if (!\Hash::check($value, $user->password)) {
                    $fail('The old password is incorrect.');
                }
            }],
        ]);

        // Update the user's profile information
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        if ($request->filled('password')) {
            $user->password = bcrypt($validatedData['password']);
        }
        $user->save();

        return response()->json(['message' => 'Profile updated successfully'], 200);
    }
}
