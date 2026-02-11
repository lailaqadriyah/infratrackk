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
       Schema::create('realisasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_opd');
            $table->unsignedBigInteger('id_tahun');
            $table->decimal('alokasi', 15, 2)->nullable();
            $table->string('sub_kegiatan')->nullable();
            $table->string('nama_daerah')->nullable();
            $table->timestamps();

             $table->foreign('id_opd')->references('id')->on('opd')->onDelete('cascade');
            $table->foreign('id_tahun')->references('id')->on('tahun')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisasi');
    }
};
