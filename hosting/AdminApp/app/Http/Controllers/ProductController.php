<?php

namespace App\Http\Controllers;

use App\Models\ProductDetail;
use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all()->load('category', 'brand');
        return Inertia::render('Products/ProductList', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();

        return Inertia::render('Products/AddProduct', [
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    private function handleImage($image, $oldUrl = null)
    {

        $imageLocation = $oldUrl;
        if ($image) {
            $imageName = time() . rand(1000,9999) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'shared');
            $imageLocation = Storage::disk('shared')->url($imagePath);
        }
        return $imageLocation;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'short_des' => 'required|string|max:255',
                'price' => 'required|numeric',
                'discount_price' => 'nullable|numeric',
                'is_discount' => 'required|boolean|in:0,1',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'in_stock' => 'required|boolean|in:0,1',
                'stock' => 'required|integer',
                'remark' => 'required|string|max:255',
                'category' => 'required|exists:categories,id',
                'brand' => 'required|exists:brands,id',
                'img1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'img2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'img3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'img4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required|string',
                'color' => 'required|string|max:255',
                'size' => 'required|string|max:255',
            ]);

            $product = [
                'title' => $request->title,
                'short_des' => $request->short_des,
                'price' => $request->price,
                'is_discount' => $request->is_discount,
                'discount_price' => $request->discount_price,
                'image' => $this->handleImage($request->file('image')),
                'in_stock' => $request->in_stock,
                'stock' => $request->stock,
                'remark' => $request->remark,
                'category_id' => $request->category,
                'brand_id' => $request->brand,
            ];

            $product = Product::create($product);

            $productDetails = [
                'description' => $request->description,
                'color' => $request->color,
                'size' => $request->size,
                'img1' => $this->handleImage($request->file('img1')),
                'img2' => $this->handleImage($request->file('img2')),
                'img3' => $this->handleImage($request->file('img3')),
                'img4' => $this->handleImage($request->file('img4')),
                'product_id' => $product->id,
            ];

            ProductDetail::create($productDetails);

            return redirect()->route('products.index', $product->id)->with('success', 'Product created successfully');
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
        $categories = Category::all();
        $brands = Brand::all();
        $product = Product::findOrFail($id)->load('details');

        return Inertia::render('Products/EditProduct', [
            'categories' => $categories,
            'brands' => $brands,
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'short_des' => 'required|string|max:255',
                'price' => 'required|numeric',
                'discount_price' => 'nullable|numeric',
                'is_discount' => 'required|boolean|in:0,1',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'in_stock' => 'required|boolean|in:0,1',
                'stock' => 'required|integer',
                'remark' => 'required|string|max:255',
                'category' => 'required|exists:categories,id',
                'brand' => 'required|exists:brands,id',
                'img1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'img2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'img3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'img4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required|string',
                'color' => 'required|string|max:255',
                'size' => 'required|string|max:255',
            ]);

            $product = Product::findOrFail($id);
            $productDetail = ProductDetail::where('product_id', $product->id)->first();

            $product->update([
                'title' => $request->title,
                'short_des' => $request->short_des,
                'price' => $request->price,
                'is_discount' => $request->is_discount,
                'discount_price' => $request->discount_price,
                'image' => $this->handleImage($request->file('image'), $request->image),
                'in_stock' => $request->in_stock,
                'stock' => $request->stock,
                'remark' => $request->remark,
                'category_id' => $request->category,
                'brand_id' => $request->brand,
            ]);



            $productDetail->update([
                'description' => $request->description,
                'color' => $request->color,
                'size' => $request->size,
                'img1' => $this->handleImage($request->file('img1'), $productDetail->img1),
                'img2' => $this->handleImage($request->file('img2'), $productDetail->img2),
                'img3' => $this->handleImage($request->file('img3'), $productDetail->img3),
                'img4' => $this->handleImage($request->file('img4'), $productDetail->img4),
                'product_id' => $product->id,
            ]);


            return redirect()->route('products.index', $product->id)->with('success', 'Product created successfully');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    private function handleImageDelete($image){
        if ($image) {
            $imagePath = str_replace(Storage::disk('shared')->url(''), '', $image);
            if (Storage::disk('shared')->exists($imagePath)) {
                Storage::disk('shared')->delete($imagePath);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $productDetail = ProductDetail::where('product_id', $product->id)->first();

        $this->handleImageDelete($product->image);
        $this->handleImageDelete($productDetail->img1);
        $this->handleImageDelete($productDetail->img2);
        $this->handleImageDelete($productDetail->img3);
        $this->handleImageDelete($productDetail->img4);

        $productDetail->delete();
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
