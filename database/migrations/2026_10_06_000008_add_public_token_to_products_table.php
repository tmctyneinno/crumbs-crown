<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('public_token', 10)->nullable()->unique();
        });

        DB::table('products')->select('id')->orderBy('id')->each(function (object $product): void {
            do {
                $token = Str::random(10);
            } while (DB::table('products')->where('public_token', $token)->exists());

            DB::table('products')
                ->where('id', $product->id)
                ->update(['public_token' => $token]);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['public_token']);
            $table->dropColumn('public_token');
        });
    }
};
