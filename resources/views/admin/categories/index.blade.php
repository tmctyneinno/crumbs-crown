@extends('admin.layout')

@section('title', 'Categories')
@section('heading', 'Categories')

@section('content')
    <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
        <p class="text-sm text-stone-600">{{ $categories->total() }} categories</p>
        <a href="{{ route('admin.categories.create') }}" class="rounded-md bg-[#633e2c] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#4f3022]">Add category</a>
    </div>

    <div class="overflow-hidden rounded-md border border-stone-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="bg-stone-50 text-xs uppercase tracking-wide text-stone-500">
                    <tr>
                        <th class="px-5 py-3 font-semibold">S/N</th>
                        <th class="px-5 py-3 font-semibold">Category</th>
                        <th class="px-5 py-3 font-semibold">Slug</th>
                        <th class="px-5 py-3 font-semibold">Products</th>
                        <th class="px-5 py-3 font-semibold">Visibility</th>
                        <th class="px-5 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-5 py-3 text-stone-500">{{ $categories->firstItem() + $loop->index }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    @if ($category->image_url)
                                        <img src="{{ $category->image_url }}" alt="" class="h-10 w-10 rounded object-cover">
                                    @endif
                                    <span class="font-medium text-stone-900">{{ $category->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-stone-600">{{ $category->slug }}</td>
                            <td class="px-5 py-3 text-stone-600">{{ $category->products_count }}</td>
                            <td class="px-5 py-3">
                                <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $category->is_active ? 'bg-emerald-50 text-emerald-800' : 'bg-stone-100 text-stone-600' }}">{{ $category->is_active ? 'Active' : 'Hidden' }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="font-medium text-[#633e2c] hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Remove this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="font-medium text-rose-700 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-10 text-center text-stone-500">No categories yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($categories->hasPages())
            <div class="border-t border-stone-200 px-5 py-4">{{ $categories->links() }}</div>
        @endif
    </div>
@endsection