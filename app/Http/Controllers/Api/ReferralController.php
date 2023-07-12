<?php

namespace App\Http\Controllers\Api;

use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ReferralController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'referral_name' => 'required',
            'mobile_number' => 'required',
            'email' => 'required|email',
        ]);

        $user = $request->user(); // Get the authenticated user

        $referral = new Referral([
            'referral_name' => $request->input('referral_name'),
            'mobile_number' => $request->input('mobile_number'),
            'email' => $request->input('email'),
            'status' => 'active',
        ]);

        $user->referrals()->save($referral);

        return response()->json([
            'message' => 'Referral added successfully.',
            'referral' => $referral,
        ]);
    }

    public function update(Request $request, Referral $referral)
    {
        $request->validate([
            'referral_name' => 'required',
            'mobile_number' => 'required',
            'email' => 'required|email',
        ]);

        $referral->update([
            'referral_name' => $request->input('referral_name'),
            'mobile_number' => $request->input('mobile_number'),
            'email' => $request->input('email'),
        ]);

        return response()->json([
            'message' => 'Referral updated successfully.',
            'referral' => $referral,
        ]);
    }

    public function destroy(Referral $referral)
    {
        $referral->delete();

        return response()->json([
            'message' => 'Referral deleted successfully.',
        ]);
    }
    public function markSuccess(Referral $referral)
    {
        $referral->update([
            'status' => 'success',
            'admin_action' => 'marked_success',
        ]);

        // Perform any additional actions required

        return response()->json([
            'message' => 'Referral marked as success.',
            'referral' => $referral,
        ]);
    }

    public function markActive(Referral $referral)
    {
        $referral->update([
            'status' => 'active',
            'admin_action' => 'marked_active',
        ]);

        // Perform any additional actions required

        return response()->json([
            'message' => 'Referral marked as active.',
            'referral' => $referral,
        ]);
    }

    public function markDeclined(Referral $referral)
    {
        $referral->update([
            'status' => 'declined',
            'admin_action' => 'marked_declined',
        ]);

        // Perform any additional actions required

        return response()->json([
            'message' => 'Referral marked as declined.',
            'referral' => $referral,
        ]);
    }

    public function addBonus(Request $request, Referral $referral)
    {
        $request->validate([
            'bonus' => 'required|numeric',
        ]);

        $bonus = $request->input('bonus');

        $referral->update([
            'bonus' => $bonus,
            'admin_action' => 'bonus_added',
        ]);

        // Perform any additional actions required

        return response()->json([
            'message' => 'Bonus added to referral.',
            'referral' => $referral,
        ]);
    }
}
