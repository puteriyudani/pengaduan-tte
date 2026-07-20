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

            $table->foreignId('kategori_id')
                ->constrained('kategori')
                ->onDelete('restrict');

            $table->foreignId('opd_id')
                ->constrained('opd')
                ->onDelete('restrict');

            $table->string('keterangan');

            $table->dateTime('tanggal')
                ->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->string('hari')
                ->default(DB::raw('DAYNAME(CURRENT_DATE)'));

            $table->string('status')->default('pending');

            $table->dateTime('tanggal_selesai')->nullable();

            $table->string('whatsapp')->nullable();

            $table->timestamps();
            $table->softDeletes();
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
