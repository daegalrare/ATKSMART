<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Tampilkan daftar kategori produk.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $categories = Category::withCount('products')
            ->when($search, function ($query, $search) {
                $query->where('nama_kategori', 'like', "%{$search}%");
            })
            ->orderBy('nama_kategori', 'asc')
            ->paginate(10)
            ->withQueryString();

        $totalCategories = Category::count();
        $totalProductsInCat = \App\Models\Product::whereNotNull('id_kategori')->count();

        return view('category.index', compact('categories', 'search', 'totalCategories', 'totalProductsInCat'));
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:categories,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Kategori dengan nama ini sudah ada.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
        ]);

        Category::create($validated);

        return redirect()->route('category.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Perbarui data kategori.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:categories,nama_kategori,' . $id . ',id_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Kategori dengan nama ini sudah ada.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
        ]);

        $category->update($validated);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(int $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        // Jika kategori memiliki relasi produk, set null id_kategori pada produk terkait
        \App\Models\Product::where('id_kategori', $id)->update(['id_kategori' => null]);

        $nama = $category->nama_kategori;
        $category->delete();

        return redirect()->route('category.index')->with('success', "Kategori \"{$nama}\" berhasil dihapus.");
    }
}
