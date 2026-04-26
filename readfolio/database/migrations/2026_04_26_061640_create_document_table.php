<?php

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
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users.id')->cascadeOnDelete();
            $table->string('title', 255);
            $table->string('filename', 255);
            $table->integer('total_pages')->default(0);
            $table->integer('last_page')->default(1);
        
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('last_read_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document');
    }
};
