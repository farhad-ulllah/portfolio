<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validate the registration data
            $validatedData = $request->validate([
                'username' => 'required|string|max:255',
                'contact_no' => 'required|string|regex:/^[0-9]{11}$/',
                'email' => 'required|string|email|unique:users|max:255',
                'password' => 'required|string|min:6|confirmed',
            ]);

            // Create the user
            $user = User::create([
                'name' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'contact_no' => $validatedData['contact_no'],
            ]);

            // Assign the "user" role to the user
            $userRole = Role::findByName('user');
            $user->assignRole($userRole);
            // Generate a new access token
            $accessToken = $user->createToken('authToken')->accessToken;
            event(new Registered($user));

            // Generate the verification URL
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                [
                    'id' => $user->id,
                    'hash' => sha1($user->getEmailForVerification())
                ]
            );

            // Send the verification email
            $user->sendEmailVerificationNotification($verificationUrl);

            return response()->json(['message' => 'Registration successful. Please check your email for verification.', 'token' => $accessToken], 200);

            // return response()->json(['access_token' => $accessToken, 'message' => 'Registration successful'], 200);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        try {
            // Validate the login data
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            // Attempt to log in the user
            if (!Auth::attempt($credentials)) {
                return response()->json(['status' => 'fail', 'message' => 'Invalid Email Or Password']);
            }

            // Get the authenticated user
            $user = Auth::user();
            // Check if the user's email is verified
            // if (!$user->hasVerifiedEmail()) {
            //     return response()->json(['status' => 'fail', 'message' => 'Email not verified. Please verify your email before logging in.']);
            // }
            // Generate a new access token
            $accessToken = $user->createToken('authToken')->accessToken;
            return response()->json(['status' => 'success', 'access_token' => $accessToken]);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
    public function AdminDashboard()
    {
        return view('admin.dashboard');
    }
    public function logout(Request $request)
    {
        if (auth()->check()) {
            $user = $request->user();
            $accessToken = $user->token();

            $tokenRepository->revokeAccessToken($accessToken->id);
            return response()->json(['status' => 'success', 'message' => 'Logged out successfully']);
        }
        return response()->json(['status' => 'error', 'message' => 'User is not authenticated']);
    }
    public function ForgotPassword()
    {
        try {
            return view('admin.auth.forgot_password');
        } catch (\Exception $e) {
            return response()->json(array('status' => "fail", 'msg' => $e->getMessage()));
        }
    }
    public function ResetPassword($token)
    {
        try {
            $updatePassword = DB::table('password_resets')
                ->where([
                    'token' => $token
                ])
                ->first();
            if ($updatePassword) {
                return response()->json(['status' => 'success', 'token' => $updatePassword->token]);
                // return view('admin.auth.password_reset', ['token' => $updatePassword->token]);
            } else {
                abort('404');
            }
        } catch (\Exception $e) {
            return response()->json(array('status' => "fail", 'msg' => $e->getMessage()));
        }
    }
    public function ForgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), []);
        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
        }
        try {
            $user = User::where('email', $request->email)->first();
            if ($user && !is_null($user)) {
                $reset_email = DB::table('password_resets')
                    ->where([
                        'email' => $request->email
                    ])
                    ->first();
                if ($reset_email) {
                    DB::table('password_resets')->where(['email' => $request->email])->delete();
                }
                $token = Str::random(64);
                DB::table('password_resets')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
                Mail::send('emails.forgetpassword', ['token' => $token, 'users' => $user], function ($message) use ($request) {
                    $message->to($request->email)
                        ->from('email@investors-portal.baramdatsol.com', 'password Forget')
                        ->subject('Reset Password');
                });
                return response()->json(['status' => 'success', 'msg' => 'We have emailed your password reset link, please checkout your mail']);
            } else {
                return response()->json(['status' => 'fail', 'msg' => 'Email not exist on portal!']);
            }
        } catch (\Exception $e) {
            return response()->json(array('status' => "fail", 'msg' => $e->getMessage()));
        }
    }

    public function SubmitResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
        }
        try {
            $updatePassword = DB::table('password_resets')
                ->where([
                    'token' => $request->token
                ])
                ->first();
            if (empty($updatePassword)) {
                return response()->json(['status' => 'fail', 'msg' => 'Invalid token']);
            } else {
                $user = User::where('email', $updatePassword->email)
                    ->update(['password' => Hash::make($request->password)]);
                DB::table('password_resets')->where(['email' => $updatePassword->email])->delete();
                return response()->json(['status' => 'success', 'msg' => 'Your password has been changed']);
            }
        } catch (\Exception $e) {
            return response()->json(array('status' => "fail", 'msg' => $e->getMessage()));
        }
    }
    public function AddSupperAdmin()
    {
        // $user = User::find(6);
        // $user->assignRole('Super-admin');
        // $user = User::find(1);
        // $role = Role::where('id', 2)->first();
        // $role->givePermissionTo('add post');
        // return $user;
    }
}
