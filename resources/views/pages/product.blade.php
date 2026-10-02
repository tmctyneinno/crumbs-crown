{{-- resources/views/products/show.blade.php --}}
<x-layouts.app :title="$product->name . ' | Crumbs & Crown'">
    <x-layouts.header />

    <livewire:shop.product-show :product="$product" />

    <livewire:layouts.site-footer />
</x-layouts.app>