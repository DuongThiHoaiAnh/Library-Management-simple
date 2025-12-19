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
        Schema::table('phieu_muon', function (Blueprint $table) {
            $table->foreign(['idNguoiDung'])->references(['idNguoiDung'])->on('nguoi_dung')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phieu_muon', function (Blueprint $table) {
            $table->dropForeign('phieu_muon_idnguoidung_foreign');
        });
    }
};
