@extends('admin.layout')

@section('title', $formTitle)
@section('heading', $formTitle)

@section('content')
    @if ($errors->any())
        <div role="alert" class="mb-5 rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
            <p class="font-semibold">Please check the product details.</p>
            <ul class="mt-2 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data" class="max-w-4xl rounded-md border border-stone-200 bg-white p-5 sm:p-7">
        @csrf
        @if ($product->exists)
            @method('PUT')
        @endif

        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="name" class="mb-1.5 block text-sm font-medium">Product name</label>
                <input id="name" name="name" required maxlength="255" value="{{ old('name', $product->name) }}" class="w-full rounded-md border border-stone-300 px-3 py-2.5 text-sm focus:border-[#936447] focus:outline-none focus:ring-2 focus:ring-[#936447]/20">
            </div>

            <div class="sm:col-span-2">
                <label for="description" class="mb-1.5 block text-sm font-medium">Description</label>
                <textarea id="description" name="description" rows="3" required maxlength="2000" class="w-full rounded-md border border-stone-300 px-3 py-2.5 text-sm focus:border-[#936447] focus:outline-none focus:ring-2 focus:ring-[#936447]/20">{{ old('description', $product->description) }}</textarea>
            </div>

            <div>
                <label for="price" class="mb-1.5 block text-sm font-medium">Price (&#8358;)</label>
                <input id="price" name="price" type="number" min="0" step="1" required value="{{ old('price', $product->price) }}" class="w-full rounded-md border border-stone-300 px-3 py-2.5 text-sm focus:border-[#936447] focus:outline-none focus:ring-2 focus:ring-[#936447]/20">
            </div>
            <div>
                <label for="rating" class="mb-1.5 block text-sm font-medium">Rating</label>
                <input id="rating" name="rating" type="number" min="0" max="5" step="0.5" required value="{{ old('rating', $product->rating ?? 5) }}" class="w-full rounded-md border border-stone-300 px-3 py-2.5 text-sm focus:border-[#936447] focus:outline-none focus:ring-2 focus:ring-[#936447]/20">
            </div>

            <div>
                <label for="category_id" class="mb-1.5 block text-sm font-medium">Category</label>
                <select id="category_id" name="category_id" required class="w-full rounded-md border border-stone-300 bg-white px-3 py-2.5 text-sm focus:border-[#936447] focus:outline-none focus:ring-2 focus:ring-[#936447]/20">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="occasion" class="mb-1.5 block text-sm font-medium">Occasion <span class="font-normal text-stone-500">(optional)</span></label>
                <input id="occasion" name="occasion" maxlength="80" placeholder="Birthday" value="{{ old('occasion', $product->occasion ? \Illuminate\Support\Str::headline($product->occasion) : '') }}" class="w-full rounded-md border border-stone-300 px-3 py-2.5 text-sm focus:border-[#936447] focus:outline-none focus:ring-2 focus:ring-[#936447]/20">
            </div>

            <div class="sm:col-span-2">
                <label for="dietary" class="mb-1.5 block text-sm font-medium">Dietary tags <span class="font-normal text-stone-500">(optional, comma-separated)</span></label>
                <input id="dietary" name="dietary" placeholder="Eggless, gluten-free" value="{{ old('dietary', implode(', ', $product->dietary ?? [])) }}" class="w-full rounded-md border border-stone-300 px-3 py-2.5 text-sm focus:border-[#936447] focus:outline-none focus:ring-2 focus:ring-[#936447]/20">
            </div>

            <div class="sm:col-span-2">
                <label for="image" class="mb-1.5 block text-sm font-medium">Product image</label>
                @if ($product->exists)
                    <img src="{{ $product->image_url }}" alt="Current {{ $product->name }} image" class="mb-3 h-24 w-24 rounded-md object-cover">
                @endif
                <input id="image" name="image" type="file" accept="image/*" class="block w-full text-sm text-stone-600 file:mr-3 file:rounded-md file:border-0 file:bg-stone-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-stone-700 hover:file:bg-stone-200">
                <p class="mt-1.5 text-xs text-stone-500">JPG, PNG, or WebP up to 5 MB.</p>
            </div>

            <div class="sm:col-span-2 flex flex-wrap gap-x-8 gap-y-3 border-t border-stone-200 pt-5">
                <label class="flex items-center gap-2 text-sm">
                    <input name="is_active" type="checkbox" value="1" @checked(old('is_active', $product->exists ? $product->is_active : true)) class="rounded border-stone-300 text-[#633e2c] focus:ring-[#936447]">
                    Visible in shop
                </label>
                <label class="flex items-center gap-2 text-sm">
                    <input name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $product->is_featured)) class="rounded border-stone-300 text-[#633e2c] focus:ring-[#936447]">
                    Feature near top
                </label>
            </div>
        </div>

        <div class="mt-7 flex flex-wrap items-center gap-3 border-t border-stone-200 pt-5">
            <button type="submit" class="rounded-md bg-[#633e2c] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#4f3022]">Save product</button>
            <a href="{{ route('admin.products.index') }}" class="rounded-md border border-stone-300 px-5 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50">Cancel</a>
        </div>
    </form>
@endsection