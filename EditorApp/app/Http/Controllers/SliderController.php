<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = Slider::all();

        return Inertia::render("Sliders/SliderList", [
            'slides' => $slides,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("Sliders/AddSlider");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'active' => 'required|in:0,1',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageLocation = '';
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('images', $imageName, 'shared');
                $imageLocation = Storage::disk('shared')->url($imagePath);
            }

            Slider::create([
                'active' => $request->active,
                'image' => $imageLocation,
            ]);

            return redirect()->route('sliders.index')->with('success', 'Slide created successfully.');
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
        $slide = Slider::findOrFail($id);
        return Inertia::render('Sliders/EditSlider', [
            'slide' => $slide
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'active' => 'required|in:0,1',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $slide = Slider::findOrFail($id);

            $imageLocation = $slide->image;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('images', $imageName, 'shared');
                $imageLocation = Storage::disk('shared')->url($imagePath);
            }

            $slide->update([
                'active' => $request->active,
                'image' => $imageLocation,
            ]);

            return redirect()->route('sliders.index')->with('success', 'Slide updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slide = Slider::findOrFail($id);
        if ($slide->image) {
            $imagePath = str_replace(Storage::disk('shared')->url(''), '', $slide->image);
            if(Storage::disk('shared')->exists($imagePath)) {
                Storage::disk('shared')->delete($imagePath);
            }
        }

        $slide->delete();
        return redirect()->route('sliders.index')->with('success', 'Slide deleted successfully.');
    }
}
