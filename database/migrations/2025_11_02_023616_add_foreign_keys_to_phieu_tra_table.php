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
        Schema::table('phieu_tra', function (Blueprint $table) {
            $table->foreign(['idPhieuMuonChiTiet'])->references(['idPhieuMuonChiTiet'])->on('phieu_muon_chi_tiet')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phieu_tra', function (Blueprint $table) {
            $table->dropForeign('phieu_tra_idphieumuonchitiet_foreign');
        });
    }
};
