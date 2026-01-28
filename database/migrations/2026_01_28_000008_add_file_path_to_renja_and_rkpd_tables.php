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
        Schema::table('renja', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('anggaran');
        });

        Schema::table('rkpd', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('anggaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('renja', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });

        Schema::table('rkpd', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });
    }
};
