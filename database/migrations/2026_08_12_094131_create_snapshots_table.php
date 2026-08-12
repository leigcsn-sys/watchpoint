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
        Schema::create('snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('watch_id')->constrained()->cascadeOnDelete();
            $table->longText('content_text');
            $table->string('content_hash');
            $table->timestamp('fetched_at');
            $table->timestamps();
            $table->index('watch_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('snapshots');
    }
};
