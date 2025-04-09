<?php

namespace App\Http\Controllers;

use App\Models\SSLCommerzCredential;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SSLCommerzCredentialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = SSLCommerzCredential::first();
        return Inertia::render('Settings/Settings', [
            'setting' => $setting,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'store_id' => 'required|string',
                'store_password' => 'required|string',
                'currency' => 'required|string',
                'success_url' => 'required|string',
                'fail_url' => 'required|string',
                'cancel_url' => 'required|string',
                'ipn_url' => 'required|string',
                'init_url' => 'required|string',
            ]);

            $setting = SSLCommerzCredential::first();
            $setting->update($request->all());
            return redirect()->back()->with('success', 'SSLCommerz settings updated successfully.');
            
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
