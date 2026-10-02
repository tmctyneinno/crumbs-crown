@extends('admin.layout')

@section('title', 'Overview')
@section('heading', 'Overview')

@section('content')
    <div class="grid gap-4 sm:grid-cols-3">
        <article class="rounded-md border border-stone-200 bg-white p-5">
            <p class="text-sm text-stone-500">Products in catalog</p>
            <p class="mt-3 font-serif text-4xl font-semibold text-[#34231d]">{{ $totalProducts }}</p>
        </article>
        <article class="rounded-md border border-stone-200 bg-white p-5">
            <p class="text-sm text-stone-500">Visible in shop</p>
            <p class="mt-3 font-serif text-4xl font-semibold text-emerald-800">{{ $activeProducts }}</p>
        </article>
        <article class="rounded-md border border-stone-200 bg-white p-5">
            <p class="text-sm text-stone-500">Product categories</p>
            <p class="mt-3 font-serif text-4xl font-semibold text-[#936447]">{{ $categoryCount }}</p>
        </article>
    </div>

    <section class="mt-8 overflow-hidden rounded-md border border-stone-200 bg-white">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-stone-200 px-5 py-4">
            <div>
                <h2 class="font-semibold text-[#34231d]">Recently updated products</h2>
                <p class="mt-1 text-sm text-stone-500">Latest items in your catalog</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="text-sm font-semibold text-[#633e2c] hover:underline">Manage products</a>
        </div>
        <div class="divide-y divide-stone-100">
            @forelse ($latestProducts as $product)
                <a href="{{ route('admin.products.edit', $product) }}" class="flex items-center gap-4 px-5 py-3.5 hover:bg-stone-50">
                    <img src="{{ $product->image_url }}" alt="" class="h-12 w-12 rounded object-cover">
                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-sm font-medium text-stone-900">{{ $product->name }}</span>
                        <span class="mt-1 block text-xs text-stone-500">{{ $product->category?->name ?? 'Uncategorized' }}</span>
                    </span>
                    <span class="text-sm font-semibold text-stone-800">&#8358;{{ number_format($product->price) }}</span>
                    <span class="text-xs {{ $product->is_active ? 'text-emerald-700' : 'text-stone-400' }}">{{ $product->is_active ? 'Active' : 'Hidden' }}</span>
                </a>
            @empty
                <p class="px-5 py-8 text-sm text-stone-500">No products yet. Add the first item to start your catalog.</p>
            @endforelse
        </div>
    </section>
@endsection