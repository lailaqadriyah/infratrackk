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
        Schema::table('apbd', function (Blueprint $table) {
            if (!Schema::hasColumn('apbd', 'alokasi')) {
                $table->decimal('alokasi', 15, 2)->nullable()->after('pagu');
            }
            if (!Schema::hasColumn('apbd', 'program')) {
                $table->string('program')->nullable()->after('alokasi');
            }
            if (!Schema::hasColumn('apbd', 'nama_daerah')) {
                $table->string('nama_daerah')->nullable()->after('program');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apbd', function (Blueprint $table) {
            if (Schema::hasColumn('apbd', 'nama_daerah')) {
                $table->dropColumn('nama_daerah');
            }
            if (Schema::hasColumn('apbd', 'program')) {
                $table->dropColumn('program');
            }
            if (Schema::hasColumn('apbd', 'alokasi')) {
                $table->dropColumn('alokasi');
            }
        });
    }
};
