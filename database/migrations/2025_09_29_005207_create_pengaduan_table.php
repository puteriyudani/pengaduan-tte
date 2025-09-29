<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->string('opd');
            $table->string('keterangan');
            $table->date('tanggal')->default(DB::raw('CURRENT_DATE'));
            $table->string('hari')->default(DB::raw('DAYNAME(CURRENT_DATE)'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
