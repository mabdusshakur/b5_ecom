<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $wishlist = $user->profile->wishlists->load('product');

        return Inertia::render('Wishlists/Wishlist', [
            'wishlists' => $wishlist
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
        try {
            $customer_id = auth()->user()->profile->id;
            $product_id = $request->product_id;

            Wishlist::updateOrCreate([
                'customer_id' => $customer_id,
                'product_id' => $product_id,
            ], [
                'customer_id' => $customer_id,
                'product_id' => $product_id,
            ]);

            return back()->with('success', 'Product added to wishlist');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $wishlist->delete();
        return back()->with('success','Product removed from wishlist');
    }
}
