<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;

class ShoppingCart
{
    private const SESSION_KEY = 'cart';

    public function add(Product $product): void
    {
        $items = $this->contents();
        $items[$product->id] = ($items[$product->id] ?? 0) + 1;

        session()->put(self::SESSION_KEY, $items);
    }

    public function changeQuantity(int $productId, int $change): void
    {
        $items = $this->contents();

        if (! isset($items[$productId])) {
            return;
        }

        $quantity = $items[$productId] + $change;

        if ($quantity < 1) {
            unset($items[$productId]);
        } else {
            $items[$productId] = $quantity;
        }

        session()->put(self::SESSION_KEY, $items);
    }

    public function remove(int $productId): void
    {
        $items = $this->contents();
        unset($items[$productId]);

        session()->put(self::SESSION_KEY, $items);
    }

    public function count(): int
    {
        return array_sum($this->contents());
    }

    public function quantities(): array
    {
        return $this->contents();
    }

    public function items(): array
    {
        $quantities = $this->contents();

        if ($quantities === []) {
            return [];
        }

        $products = Product::active()
            ->whereKey(array_keys($quantities))
            ->get()
            ->keyBy('id');

        $items = [];

        foreach ($quantities as $productId => $quantity) {
            $product = $products->get($productId);

            if (! $product) {
                continue;
            }

            $items[] = [
                'id' => $product->id,
                'name' => $product->name,
                'size' => $product->category?->name ?? '',
                'price' => $product->price,
                'qty' => $quantity,
                'image' => $product->image_url,
            ];
        }

        return $items;
    }

    private function contents(): array
    {
        return collect(session()->get(self::SESSION_KEY, []))
            ->mapWithKeys(fn ($quantity, $productId) => [(int) $productId => max(1, (int) $quantity)])
            ->all();
    }
}
