<?php

namespace App\Services;

use App\Models\Product;

class ShoppingCart
{
    private const SESSION_KEY = 'cart';
    private const LINES_SESSION_KEY = 'cart_lines';

    public function add(Product $product, int $quantity = 1, array $options = []): void
    {
        if ($quantity < 1) {
            return;
        }

        $lines = $this->lines();
        $lineId = $this->lineId($product, $options);
        $line = $lines[$lineId] ?? [
            'product_id' => $product->id,
            'quantity' => 0,
            'options' => $options,
        ];
        $line['quantity'] += $quantity;
        $lines[$lineId] = $line;

        $this->saveLines($lines);
    }

    public function changeQuantity(int $productId, int $change): void
    {
        $lines = $this->lines();
        $lineId = $this->findLineId($lines, $productId);

        if ($lineId === null) {
            return;
        }

        $this->changeLineQuantity($lineId, $change);
    }

    public function changeLineQuantity(string|int $lineId, int $change): void
    {
        $lines = $this->lines();
        $lineId = (string) $lineId;

        if (! isset($lines[$lineId])) {
            return;
        }

        $quantity = $lines[$lineId]['quantity'] + $change;

        if ($quantity < 1) {
            unset($lines[$lineId]);
        } else {
            $lines[$lineId]['quantity'] = $quantity;
        }

        $this->saveLines($lines);
    }

    public function remove(int $productId): void
    {
        $lines = collect($this->lines())
            ->reject(fn (array $line) => (int) $line['product_id'] === $productId)
            ->all();

        $this->saveLines($lines);
    }

    public function removeLine(string|int $lineId): void
    {
        $lines = $this->lines();
        unset($lines[(string) $lineId]);

        $this->saveLines($lines);
    }

    public function clear(): void
    {
        session()->forget([self::SESSION_KEY, self::LINES_SESSION_KEY]);
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
        $lines = $this->lines();

        if ($lines === []) {
            return [];
        }

        $products = Product::active()
            ->whereKey(collect($lines)->pluck('product_id')->unique()->all())
            ->get()
            ->keyBy('id');

        $items = [];

        foreach ($lines as $lineId => $line) {
            $productId = (int) $line['product_id'];
            $product = $products->get($productId);

            if (! $product) {
                continue;
            }

            $options = $line['options'] ?? [];

            $items[] = [
                'id' => $product->id,
                'line_id' => (string) $lineId,
                'name' => $product->name,
                'description' => $product->description,
                'size' => $options['size'] ?? $product->category?->name ?? '',
                'options' => $options,
                'price' => (int) ($options['unit_price'] ?? $product->price),
                'qty' => $line['quantity'],
                'image' => $product->image_url,
            ];
        }

        return $items;
    }

    private function contents(): array
    {
        $quantities = [];

        foreach ($this->lines() as $line) {
            $productId = (int) $line['product_id'];
            $quantities[$productId] = ($quantities[$productId] ?? 0) + $line['quantity'];
        }

        return $quantities;
    }

    private function lines(): array
    {
        $lines = session()->get(self::LINES_SESSION_KEY);

        if (is_array($lines)) {
            return $lines;
        }

        return collect(session()->get(self::SESSION_KEY, []))
            ->mapWithKeys(fn ($quantity, $productId) => [(string) (int) $productId => [
                'product_id' => (int) $productId,
                'quantity' => max(1, (int) $quantity),
                'options' => [],
            ]])
            ->all();
    }

    private function saveLines(array $lines): void
    {
        session()->put(self::LINES_SESSION_KEY, $lines);
        session()->put(self::SESSION_KEY, $this->aggregateQuantities($lines));
    }

    private function aggregateQuantities(array $lines): array
    {
        $quantities = [];

        foreach ($lines as $line) {
            $productId = (int) $line['product_id'];
            $quantities[$productId] = ($quantities[$productId] ?? 0) + $line['quantity'];
        }

        return $quantities;
    }

    private function lineId(Product $product, array $options): string
    {
        if ($options === []) {
            return (string) $product->id;
        }

        return $product->id . '-' . substr(hash('sha256', serialize($options)), 0, 16);
    }

    private function findLineId(array $lines, int $productId): string|int|null
    {
        if (array_key_exists((string) $productId, $lines)) {
            return (string) $productId;
        }

        foreach ($lines as $lineId => $line) {
            if ((int) $line['product_id'] === $productId) {
                return $lineId;
            }
        }

        return null;
    }
}
