<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $search   = $request->query('search');
        $showTrash = $request->boolean('trash');

        $query = Product::with('category')
            ->leftJoin('categories', 'product.id_kategori', '=', 'categories.id_kategori')
            ->select('product.*');

        $query->when($search, function ($q, $search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('product.nama_produk', 'like', "%{$search}%")
                       ->orWhere('product.kode_produk', 'like', "%{$search}%")
                       ->orWhere('categories.nama_kategori', 'like', "%{$search}%");
                });
            });

        if ($showTrash) {
            $query->onlyTrashed()->orderBy('product.deleted_at', 'desc');
        } else {
            $query->orderByRaw('COALESCE(product.updated_at, product.created_at) DESC')
                  ->orderBy('product.id_produk', 'desc');
        }

        $products  = $query->paginate(15)->withQueryString();
        $categories = Category::query()->orderBy('nama_kategori', 'asc')->get();
        $trashedCount = Product::onlyTrashed()->count();

        return view('product.index', compact('products', 'categories', 'search', 'showTrash', 'trashedCount'));
    }

    public function restore($id): RedirectResponse
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('product.index', ['trash' => 1])
            ->with('success', "Produk \"{$product->nama_produk}\" berhasil dipulihkan!");
    }

    public function forceDelete($id): RedirectResponse
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $nama    = $product->nama_produk;

        if ($product->foto_produk) {
            Storage::disk('public')->delete($product->foto_produk);
        }
        $product->forceDelete();

        return redirect()->route('product.index', ['trash' => 1])
            ->with('success', "Produk \"{$nama}\" dihapus permanen!");
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_produk'        => 'required|string|max:50|unique:product,kode_produk',
            'nama_produk'        => 'required|string|max:255',
            'id_kategori'        => 'nullable|exists:categories,id_kategori',
            'satuan_terkecil'    => 'nullable|string|max:50',
            'satuan_besar'       => 'nullable|string|max:50',
            'isi_per_satuan_besar' => 'nullable|integer|min:1',
            'lokasi_produk'      => 'nullable|string|max:100',
            'stok_minimum'       => 'nullable|integer|min:0',
            'stok_produk'        => 'nullable|integer|min:0',
            'harga_beli_terakhir' => 'nullable|numeric|min:0',
            'harga_jual'         => 'required|numeric|min:0',
            'foto_produk'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'kode_produk.required'  => 'Kode produk wajib diisi.',
            'kode_produk.unique'    => 'Kode produk sudah digunakan.',
            'nama_produk.required'  => 'Nama produk wajib diisi.',
            'harga_jual.required'   => 'Harga jual wajib diisi.',
            'harga_jual.numeric'    => 'Harga jual harus berupa angka.',
            'harga_jual.min'        => 'Harga jual tidak boleh minus (minimal 0).',
            'harga_beli_terakhir.min' => 'Harga beli tidak boleh minus (minimal 0).',
            'stok_produk.min'       => 'Jumlah stok tidak boleh minus (minimal 0).',
            'stok_minimum.min'      => 'Stok minimum tidak boleh minus (minimal 0).',
            'foto_produk.required'  => 'Foto produk wajib diunggah.',
            'foto_produk.image'     => 'File harus berupa gambar.',
            'foto_produk.mimes'     => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'foto_produk.max'       => 'Ukuran gambar maksimal 2MB.',
        ]);

        if (isset($validated['stok_produk'])) {
            $validated['stok_produk'] = max(0, (int) $validated['stok_produk']);
        }
        if (isset($validated['stok_minimum'])) {
            $validated['stok_minimum'] = max(0, (int) $validated['stok_minimum']);
        }
        if (isset($validated['harga_beli_terakhir'])) {
            $validated['harga_beli_terakhir'] = max(0, (float) $validated['harga_beli_terakhir']);
        }
        if (isset($validated['harga_jual'])) {
            $validated['harga_jual'] = max(0, (float) $validated['harga_jual']);
        }

        if ($request->hasFile('foto_produk')) {
            $path = $request->file('foto_produk')->store('products', 'public');
            $validated['foto_produk'] = $path;
        }

        Product::create($validated);

        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'kode_produk'        => 'required|string|max:50|unique:product,kode_produk,' . $id . ',id_produk',
            'nama_produk'        => 'required|string|max:255',
            'id_kategori'        => 'nullable|exists:categories,id_kategori',
            'satuan_terkecil'    => 'nullable|string|max:50',
            'satuan_besar'       => 'nullable|string|max:50',
            'isi_per_satuan_besar' => 'nullable|integer|min:1',
            'lokasi_produk'      => 'nullable|string|max:100',
            'stok_minimum'       => 'nullable|integer|min:0',
            'stok_produk'        => 'nullable|integer|min:0',
            'harga_beli_terakhir' => 'nullable|numeric|min:0',
            'harga_jual'         => 'required|numeric|min:0',
            'foto_produk'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'kode_produk.required'  => 'Kode produk wajib diisi.',
            'kode_produk.unique'    => 'Kode produk sudah digunakan.',
            'nama_produk.required'  => 'Nama produk wajib diisi.',
            'harga_jual.required'   => 'Harga jual wajib diisi.',
            'harga_jual.numeric'    => 'Harga jual harus berupa angka.',
            'harga_jual.min'        => 'Harga jual tidak boleh minus (minimal 0).',
            'harga_beli_terakhir.min' => 'Harga beli tidak boleh minus (minimal 0).',
            'stok_produk.min'       => 'Jumlah stok tidak boleh minus (minimal 0).',
            'stok_minimum.min'      => 'Stok minimum tidak boleh minus (minimal 0).',
            'foto_produk.image'     => 'File harus berupa gambar.',
            'foto_produk.mimes'     => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'foto_produk.max'       => 'Ukuran gambar maksimal 2MB.',
        ]);

        if (isset($validated['stok_produk'])) {
            $validated['stok_produk'] = max(0, (int) $validated['stok_produk']);
        }
        if (isset($validated['stok_minimum'])) {
            $validated['stok_minimum'] = max(0, (int) $validated['stok_minimum']);
        }
        if (isset($validated['harga_beli_terakhir'])) {
            $validated['harga_beli_terakhir'] = max(0, (float) $validated['harga_beli_terakhir']);
        }
        if (isset($validated['harga_jual'])) {
            $validated['harga_jual'] = max(0, (float) $validated['harga_jual']);
        }

        if ($request->hasFile('foto_produk')) {
            // Hapus foto lama jika ada
            if ($product->foto_produk) {
                Storage::disk('public')->delete($product->foto_produk);
            }
            $validated['foto_produk'] = $request->file('foto_produk')->store('products', 'public');
        } else {
            // Pertahankan foto lama
            unset($validated['foto_produk']);
        }

        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Data produk berhasil diperbarui!');
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $product = Product::findOrFail($id);
            $nama = $product->nama_produk;

            if ($product->foto_produk) {
                Storage::disk('public')->delete($product->foto_produk);
            }

            $product->delete();

            return redirect()->route('product.index')->with('success', "Produk \"{$nama}\" berhasil dihapus!");
        } catch (\Exception $e) {
            return redirect()->route('product.index')->with('error', 'Gagal menghapus produk karena data masih terikat dengan transaksi.');
        }
    }
}
