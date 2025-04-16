<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Helpers\MailerHelper;
use App\Models\CustomerProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginPage()
    {
        return Inertia::render("Auth/Login");
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                "email" => "required|email",
                "password" => "required|string"
            ]);

            $email = $request->email;
            $password = $request->password;

            if (!Auth::attempt(["email" => $email, "password" => $password], true)) {
                return redirect()->back()->with("error", "Invalid credentials");
            }

            return redirect('/')->with('success', 'Login success');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function registerPage()
    {
        return Inertia::render('Auth/Register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);


        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $customerProfile = CustomerProfile::updateOrCreate([
            'user_id' => $user->id,
        ], [
            'cus_name' => $request->name,
            'ship_name' => $request->name,
        ]);

        $otp = MailerHelper::sendOtp($user->email);

        $user->update([
            'otp' => $otp,
        ]);

        return redirect()->route('verify', [
            'email' => $user->email,
        ])->with('success', 'Registration success, please verify your email');

    }


    public function verifyPage(Request $request)
    {
        $email = $request->query('email');
        return Inertia::render('Auth/Verify', [
            'email' => $email,
        ]);
    }

    public function verify(Request $request)
    {
        try {
            $request->validate([
                'otp' => 'required|numeric|digits:4',
                'email' => 'required|email',
            ]);

            $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

            if (!$user) {
                return redirect()->back()->with('error', 'Invalid OTP');
            }

            $user->otp = null;
            $user->save();

            Auth::login($user);

            return redirect('/')->with('success', 'Registration completed successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function resend(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return redirect()->back()->with('error', 'Invalid Email');
            }

            $otp = MailerHelper::sendOtp($user->email);

            $user->otp = null;
            $user->save();

            return redirect()->route('verify', [
                'email' => $user->email,
            ])->with('success', ' OTP resent successfully, please check your email');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }



    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logout success');
    }
}
