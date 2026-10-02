@extends('admin.layout')

@section('title', 'Products')
@section('heading', 'Products')

@section('content')
    <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
        <p class="text-sm text-stone-600">{{ $products->total() }} {{ \Illuminate\Support\Str::plural('product', $products->total()) }} in your catalog</p>
        <a href="{{ route('admin.products.create') }}" class="rounded-md bg-[#633e2c] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#4f3022]">Add product</a>
    </div>

    <div class="overflow-hidden rounded-md border border-stone-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-sm">
                <thead class="bg-stone-50 text-xs uppercase tracking-wide text-stone-500">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Product</th>
                        <th class="px-5 py-3 font-semibold">Category</th>
                        <th class="px-5 py-3 font-semibold">Price</th>
                        <th class="px-5 py-3 font-semibold">Visibility</th>
                        <th class="px-5 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $product->image_url }}" alt="" class="h-11 w-11 rounded object-cover">
                                    <span class="min-w-0">
                                        <a href="{{ route('products.show', $product) }}" class="block truncate font-medium text-stone-900 hover:underline">{{ $product->name }}</a>
                                        <span class="mt-0.5 block max-w-sm truncate text-xs text-stone-500">{{ $product->description }}</span>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-stone-600">{{ $product->category?->name ?? 'Uncategorized' }}</td>
                            <td class="px-5 py-3 font-medium text-stone-800">&#8358;{{ number_format($product->price) }}</td>
                            <td class="px-5 py-3">
                                <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $product->is_active ? 'bg-emerald-50 text-emerald-800' : 'bg-stone-100 text-stone-600' }}">{{ $product->is_active ? 'Active' : 'Hidden' }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="font-medium text-[#633e2c] hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Remove this product from the shop?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="font-medium text-rose-700 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-stone-500">No products found. Add a product to populate the shop.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($products->hasPages())
            <div class="border-t border-stone-200 px-5 py-4">{{ $products->links() }}</div>
        @endif
    </div>
@endsection