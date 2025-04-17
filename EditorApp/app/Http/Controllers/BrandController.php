<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return Inertia::render('Brands/BrandList', [
            'brands' => $brands,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Brands/AddBrand');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imageLocation = '';
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('images', $imageName, 'shared');
                $imageLocation = Storage::disk('shared')->url($imagePath);
            }

            Brand::create([
                'name' => $request->name,
                'image' => $imageLocation,
            ]);

            return redirect()->route('brands.index')->with('success', 'Brand created successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
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
        $brand = Brand::findOrFail($id);
        return Inertia::render('Brands/EditBrand', [
            'brand' => $brand,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $brand = Brand::findOrFail($id);

            $imageLocation = $brand->image;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('images', $imageName, 'shared');
                $imageLocation = Storage::disk('shared')->url($imagePath);
            }

            $brand->update([
                'name' => $request->name,
                'image' => $imageLocation,
            ]);

            return redirect()->route('brands.index')->with('success', 'Brand updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        if ($brand->image) {
            $imagePath = str_replace(Storage::disk('shared')->url(''), '', $brand->image);

            if (Storage::disk('shared')->exists($imagePath)) {
                Storage::disk('shared')->delete($imagePath);
            }
        }

        $brand->delete();
    }
}
