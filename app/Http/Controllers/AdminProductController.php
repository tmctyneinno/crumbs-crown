<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'totalProducts' => Product::count(),
            'activeProducts' => Product::active()->count(),
            'categoryCount' => Category::count(),
            'latestProducts' => Product::query()->with('category')->latest()->take(5)->get(),
        ]);
    }

    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::query()->with('category')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.form', [
            'product' => new Product,
            'categories' => $this->categories(),
            'formTitle' => 'Add product',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedProduct($request);
        $image = $data['image'] ?? null;
        unset($data['image']);

        if ($image) {
            $data['image_path'] = $image->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('status', 'Product added to the shop.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => $this->categories(),
            'formTitle' => 'Edit product',
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validatedProduct($request);
        $image = $data['image'] ?? null;
        unset($data['image']);
        $oldImage = $product->image_path;

        if ($image) {
            $data['image_path'] = $image->store('products', 'public');
        }

        $product->update($data);

        if ($image && $oldImage && str_starts_with($oldImage, 'products/')) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('admin.products.index')->with('status', 'Product changes saved.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image_path && str_starts_with($product->image_path, 'products/')) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product removed from the shop.');
    }

    private function validatedProduct(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'price' => ['required', 'integer', 'min:0'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'occasion' => ['nullable', 'string', 'max:80'],
            'dietary' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $data['occasion'] = filled($data['occasion'] ?? null) ? Str::slug($data['occasion']) : null;
        $data['dietary'] = collect(explode(',', $data['dietary'] ?? ''))
            ->map(fn (string $tag) => Str::slug(trim($tag)))
            ->filter()
            ->unique()
            ->values()
            ->all();
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }

    private function categories()
    {
        return Category::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }
}
