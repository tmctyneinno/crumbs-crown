<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

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
        return self::detailUrlForId($this->id);
    }

    public static function detailUrlForId(int $id): string
    {
        $iv = random_bytes(12);
        $tag = '';
        $ciphertext = openssl_encrypt(
            (string) $id,
            'aes-256-gcm',
            self::detailUrlEncryptionKey(),
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            '',
            16,
        );

        if ($ciphertext === false) {
            throw new RuntimeException('Could not encrypt the product ID for its detail URL.');
        }

        $token = rtrim(strtr(base64_encode("\x01".$iv.$tag.$ciphertext), '+/', '-_'), '=');

        return route('products.show', ['token' => $token]);
    }

    public static function findByEncryptedId(string $token): ?self
    {
        if ($token === '' || ! preg_match('/\A[A-Za-z0-9_-]+\z/', $token)) {
            return null;
        }

        $encoded = strtr($token, '-_', '+/');
        $encoded .= str_repeat('=', (4 - strlen($encoded) % 4) % 4);
        $payload = base64_decode($encoded, true);

        if ($payload === false || strlen($payload) < 30 || $payload[0] !== "\x01") {
            return null;
        }

        $id = openssl_decrypt(
            substr($payload, 29),
            'aes-256-gcm',
            self::detailUrlEncryptionKey(),
            OPENSSL_RAW_DATA,
            substr($payload, 1, 12),
            substr($payload, 13, 16),
        );

        if ($id === false) {
            return null;
        }

        if (! ctype_digit($id) || (int) $id < 1) {
            return null;
        }

        return static::find((int) $id);
    }

    private static function detailUrlEncryptionKey(): string
    {
        return hash_hmac('sha256', 'product-detail-url', app('encrypter')->getKey(), true);
    }
}
