<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Referral;

class AdminController extends Controller
{
    public function getAllUsers()
    {
        $users = User::all();
        return response()->json(['users' => $users], 200);
    }

    public function getUserReferrals(User $user)
    {
        $referrals = $user->referrals;
        return response()->json(['referrals' => $referrals], 200);
    }

    public function addBonusToUser(User $user, Request $request)
    {
        $validatedData = $request->validate([
            'bonus' => 'required|numeric',
        ]);

        $user->bonus += $validatedData['bonus'];
        $user->save();

        return response()->json(['message' => 'Bonus added successfully'], 200);
    }
}
