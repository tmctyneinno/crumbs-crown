<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'rating',
        'category',
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
}
