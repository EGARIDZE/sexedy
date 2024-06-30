database/migrations/0001_01_01_000000_create_users_table.php
database/migrations/0001_01_01_000001_create_cache_table.php database/migrations/0001_01_01_000002_create_jobs_table.php
database/migrations/2024_06_01_092707_create_personal_access_tokens_table.php
database/migrations/2024_06_01_192827_create_categories_table.php
database/migrations/2024_06_09_090720_create_brands_table.php
database/migrations/2024_06_10_090730_create_products_table.php
database/migrations/2024_06_10_090731_create_offers_table.php
database/migrations/2024_06_17_165753_create_attributes_table.php
database/migrations/2024_06_17_170027_create_attribute_options_table.php
database/migrations/2024_06_20_125840_create_product_details_table.php
database/migrations/2024_06_20_130127_create_product_fabrics_table.php
database/migrations/2024_06_20_130150_create_product_cares_table.php database/migrations/2024_06_23_205953_create_product_images_table.php<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};