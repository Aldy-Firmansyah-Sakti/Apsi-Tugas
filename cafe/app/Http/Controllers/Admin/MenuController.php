<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        // Check if user is admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak');
        }

        $products = Product::with('category')->get();
        $categories = Category::all();
        
        return view('admin.menu.index', compact('products', 'categories'));
    }

    public function create()
    {
        // Check if user is admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak');
        }

        $categories = Category::all();
        return view('admin.menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Check if user is admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak');
        }

        $request->validate([
            'nama' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_url' => 'nullable|url|max:500',
            'stock' => 'nullable|integer|min:0',
        ]);

        $data = $request->only(['nama', 'category_id', 'harga', 'deskripsi', 'stock']);
        $data['slug'] = Str::slug($request->nama);

        // Handle image - prioritize URL over file upload
        if ($request->filled('foto_url')) {
            $data['foto'] = $request->foto_url;
        } elseif ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($menu)
    {
        // Check if user is admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak');
        }

        $product = Product::findOrFail($menu);
        $categories = Category::all();
        return view('admin.menu.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $menu)
    {
        // Check if user is admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak');
        }

        $product = Product::findOrFail($menu);

        $request->validate([
            'nama' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_url' => 'nullable|url|max:500',
            'stock' => 'nullable|integer|min:0',
        ]);

        $data = $request->only(['nama', 'category_id', 'harga', 'deskripsi', 'stock']);
        $data['slug'] = Str::slug($request->nama);

        // Handle image - prioritize URL over file upload
        if ($request->filled('foto_url')) {
            // Delete old photo if it's a local file (not URL)
            if ($product->foto && !filter_var($product->foto, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($product->foto);
            }
            $data['foto'] = $request->foto_url;
        } elseif ($request->hasFile('foto')) {
            // Delete old photo if it's a local file (not URL)
            if ($product->foto && !filter_var($product->foto, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($product->foto);
            }
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diupdate');
    }

    public function destroy($menu)
    {
        // Check if user is admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak');
        }

        $product = Product::findOrFail($menu);

        if ($product->foto && !filter_var($product->foto, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($product->foto);
        }
        
        $product->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus');
    }
}
