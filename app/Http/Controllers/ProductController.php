<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products')); // Ganti ke products.index
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'status'      => 'nullable|string|in:active,inactive',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi image
        ]);

        $data = $request->only('name', 'price', 'stock', 'category', 'description');

        // Set default status jika tidak ada
        $data['status'] = $request->status ?? 'active';

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Generate unique filename
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            // Store image in public/storage/products
            $imagePath = $image->storeAs('products', $filename, 'public');

            $data['image'] = $imagePath;
        }

        Product::create($data);

        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'status'      => 'nullable|string|in:active,inactive',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only('name', 'price', 'stock', 'category', 'description');
        $data['status'] = $request->status ?? 'active';

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('products', $filename, 'public');

            $data['image'] = $imagePath;
        }

        if ($request->has('delete_image') && $product->image) {
            Storage::disk('public')->delete($product->image);
            $data['image'] = null;
            session()->flash('debug_message', 'Gambar berhasil dihapus!');  // Debug message
        } else if ($request->has('delete_image')) {
            session()->flash('debug_message', 'Delete_image terdeteksi, tapi tidak ada gambar untuk dihapus.');  // Debug for no image
        }

        $product->update($data);

        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil dihapus.');
    }
}
