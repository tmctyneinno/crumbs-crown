<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Hashids\Hashids;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'rating',
        'category_id',
        'occasion',
        'dietary',
        'image_path',
        'is_active',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'dietary' => 'array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'rating' => 'decimal:1',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getDescAttribute(): string
    {
        return $this->description;
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image_path) {
            return asset('images/cakes/birthday-classic.svg');
        }

        return str_starts_with($this->image_path, 'images/')
            ? asset($this->image_path)
            : Storage::disk('public')->url($this->image_path);
    }

    public function getDetailUrlAttribute(): string
    {
        return route('products.show', ['token' => self::hashids()->encode($this->id)]);
    }

    public static function detailUrlForId(int $id): string
    {
        return route('products.show', ['token' => self::hashids()->encode($id)]);
    }

    public static function findByHashid(string $token): ?self
    {
        if ($token === '' || ! preg_match('/\A[A-Za-z0-9]+\z/', $token)) {
            return null;
        }

        $decoded = self::hashids()->decode($token);

        if (count($decoded) !== 1 || $decoded[0] < 1) {
            return null;
        }

        return static::query()->find($decoded[0]);
    }

    private static function hashids(): Hashids
    {
        return new Hashids((string) config('app.key'));
    }
}
