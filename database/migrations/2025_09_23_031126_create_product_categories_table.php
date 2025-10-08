<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->json('created_by')->nullable();
            $table->json('updated_by')->nullable();
            $table->json('deleted_by')->nullable();
            $table->foreign('parent_id')->references('id')->on('product_categories')->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('product_categories');
    }
};
