<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile;

        return Inertia::render('Dashboard', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    public function profile(Request $request)
    {
        $request->validate([
            'cus_name' => 'required|string',
            'cus_add' => 'required|string',
            'cus_city' => 'required|string',
            'cus_state' => 'required|string',
            'cus_postcode' => 'required|string',
            'cus_country' => 'required|string',
            'cus_phone' => 'required|string',
            'cus_fax' => 'required|string',
            'ship_name' => 'required|string',
            'ship_add' => 'required|string',
            'ship_city' => 'required|string',
            'ship_state' => 'required|string',
            'ship_postcode' => 'required|string',
            'ship_country' => 'required|string',
            'ship_phone' => 'required|string'
        ]);

        $user = auth()->user();
        $profile = $user->profile;

        $profile->updateOrCreate([
            'user_id' => $user->id,
        ], [
            'cus_name' => $request->cus_name,
            'cus_add' => $request->cus_add,
            'cus_city' => $request->cus_city,
            'cus_state' => $request->cus_state,
            'cus_postcode' => $request->cus_postcode,
            'cus_country' => $request->cus_country,
            'cus_phone' => $request->cus_phone,
            'cus_fax' => $request->cus_fax,
            'ship_name' => $request->ship_name,
            'ship_add' => $request->ship_add,
            'ship_city' => $request->ship_city,
            'ship_state' => $request->ship_state,
            'ship_postcode' => $request->ship_postcode,
            'ship_country' => $request->ship_country,
            'ship_phone' => $request->ship_phone
        ]);

        return redirect()->back()->with('success','Profile updated successfully');
    }

    public function profileMail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = auth()->user();
     
        $isExist = User::where('email', $request->email)->where('id', '!=', $user->id)->exists();
        if( $isExist ) {
            return redirect()->back()->with('error','Email already exist');
        }

        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success','Email updated successfully');
    }

    public function profilePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();
     
        if(!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error','Current password is incorrect');
        }

        $user->password = $request->password;
        $user->save();

        return redirect()->back()->with('success','Password updated successfully');
    }
}
