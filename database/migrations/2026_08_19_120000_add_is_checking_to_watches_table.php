<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('watches', function (Blueprint $table) {
            $table->boolean('is_checking')->default(false)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('watches', function (Blueprint $table) {
            $table->dropColumn('is_checking');
        });
    }
};
