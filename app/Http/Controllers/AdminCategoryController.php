<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => Category::query()
                ->withCount('products')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.form', [
            'category' => new Category,
            'formTitle' => 'Add category',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedCategory($request);
        $image = $data['image'] ?? null;
        $icon = $data['icon'] ?? null;
        unset($data['image'], $data['icon']);

        if ($image) {
            $data['image_path'] = $image->store('categories', 'public');
        }

        if ($icon) {
            $data['icon_path'] = $icon->store('categories/icons', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('status', 'Category added.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.form', [
            'category' => $category,
            'formTitle' => 'Edit category',
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validatedCategory($request, $category);
        $image = $data['image'] ?? null;
        $icon = $data['icon'] ?? null;
        unset($data['image'], $data['icon']);
        $oldImage = $category->image_path;
        $oldIcon = $category->icon_path;

        if ($image) {
            $data['image_path'] = $image->store('categories', 'public');
        }

        if ($icon) {
            $data['icon_path'] = $icon->store('categories/icons', 'public');
        }

        $category->update($data);

        if ($image && $oldImage && ! str_starts_with($oldImage, 'images/')) {
            Storage::disk('public')->delete($oldImage);
        }

        if ($icon && $oldIcon && ! str_starts_with($oldIcon, 'images/')) {
            Storage::disk('public')->delete($oldIcon);
        }

        return redirect()->route('admin.categories.index')->with('status', 'Category changes saved.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'Move or delete this category’s products before removing it.');
        }

        foreach ([$category->image_path, $category->icon_path] as $path) {
            if ($path && ! str_starts_with($path, 'images/')) {
                Storage::disk('public')->delete($path);
            }
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Category removed.');
    }

    private function validatedCategory(Request $request, ?Category $category = null): array
    {
        $request->merge([
            'slug' => Str::slug($request->input('slug') ?: $request->input('name')),
        ]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:140', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('categories', 'slug')->ignore($category?->id)],
            'description' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:10000'],
            'image' => ['nullable', 'image', 'max:5120'],
            'icon' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['name'] = trim($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
