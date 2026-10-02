@extends('admin.layout')

@section('title', $formTitle)
@section('heading', $formTitle)

@section('content')
    @if ($errors->any())
        <div role="alert" class="mb-5 rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
            <p class="font-semibold">Please check the category details.</p>
            <ul class="mt-2 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" enctype="multipart/form-data" class="max-w-3xl rounded-md border border-stone-200 bg-white p-5 sm:p-7">
        @csrf
        @if ($category->exists)
            @method('PUT')
        @endif

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="name" class="mb-1.5 block text-sm font-medium">Name</label>
                <input id="name" name="name" required maxlength="120" value="{{ old('name', $category->name) }}" class="w-full rounded-md border border-stone-300 px-3 py-2.5 text-sm focus:border-[#936447] focus:outline-none focus:ring-2 focus:ring-[#936447]/20">
            </div>
            <div>
                <label for="slug" class="mb-1.5 block text-sm font-medium">Slug</label>
                <input id="slug" name="slug" required maxlength="140" value="{{ old('slug', $category->slug) }}" class="w-full rounded-md border border-stone-300 px-3 py-2.5 text-sm focus:border-[#936447] focus:outline-none focus:ring-2 focus:ring-[#936447]/20">
            </div>
            <div class="sm:col-span-2">
                <label for="description" class="mb-1.5 block text-sm font-medium">Description <span class="font-normal text-stone-500">(optional)</span></label>
                <textarea id="description" name="description" rows="3" maxlength="1000" class="w-full rounded-md border border-stone-300 px-3 py-2.5 text-sm focus:border-[#936447] focus:outline-none focus:ring-2 focus:ring-[#936447]/20">{{ old('description', $category->description) }}</textarea>
            </div>
            <div>
                <label for="sort_order" class="mb-1.5 block text-sm font-medium">Display order</label>
                <input id="sort_order" name="sort_order" type="number" min="0" max="10000" required value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="w-full rounded-md border border-stone-300 px-3 py-2.5 text-sm focus:border-[#936447] focus:outline-none focus:ring-2 focus:ring-[#936447]/20">
            </div>
            <div class="flex items-end pb-2">
                <label class="flex items-center gap-2 text-sm">
                    <input name="is_active" type="checkbox" value="1" @checked(old('is_active', $category->exists ? $category->is_active : true)) class="rounded border-stone-300 text-[#633e2c] focus:ring-[#936447]">
                    Visible on the storefront
                </label>
            </div>
            <div>
                <label for="image" class="mb-1.5 block text-sm font-medium">Category image</label>
                @if ($category->image_url)
                    <img src="{{ $category->image_url }}" alt="Current {{ $category->name }} image" class="mb-3 h-16 w-16 rounded object-cover">
                @endif
                <input id="image" name="image" type="file" accept="image/*" class="block w-full text-sm text-stone-600 file:mr-3 file:rounded-md file:border-0 file:bg-stone-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-stone-700">
            </div>
            <div>
                <label for="icon" class="mb-1.5 block text-sm font-medium">Category icon <span class="font-normal text-stone-500">(optional)</span></label>
                @if ($category->icon_url)
                    <img src="{{ $category->icon_url }}" alt="Current {{ $category->name }} icon" class="mb-3 h-10 w-10 object-contain">
                @endif
                <input id="icon" name="icon" type="file" accept="image/*" class="block w-full text-sm text-stone-600 file:mr-3 file:rounded-md file:border-0 file:bg-stone-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-stone-700">
            </div>
        </div>

        <div class="mt-7 flex flex-wrap items-center gap-3 border-t border-stone-200 pt-5">
            <button type="submit" class="rounded-md bg-[#633e2c] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#4f3022]">Save category</button>
            <a href="{{ route('admin.categories.index') }}" class="rounded-md border border-stone-300 px-5 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50">Cancel</a>
        </div>
    </form>
@endsection