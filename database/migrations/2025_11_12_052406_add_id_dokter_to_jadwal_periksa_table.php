<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_periksa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_dokter')->after('id'); // posisi setelah kolom id
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_periksa', function (Blueprint $table) {
            $table->dropColumn('id_dokter');
        });
    }
};
