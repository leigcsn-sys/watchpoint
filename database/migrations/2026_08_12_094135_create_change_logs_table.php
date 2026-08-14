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
        Schema::create('change_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('watch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('old_snapshot_id')->nullable()->constrained('snapshots');
            $table->foreignId('new_snapshot_id')->constrained('snapshots');
            $table->text('diff_summary');
            $table->timestamp('detected_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_logs');
    }
};
