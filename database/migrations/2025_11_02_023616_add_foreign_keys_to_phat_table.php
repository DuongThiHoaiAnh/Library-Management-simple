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
        Schema::table('phat', function (Blueprint $table) {
            $table->foreign(['idNguoiDung'])->references(['idNguoiDung'])->on('nguoi_dung')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['idPhieuMuonChiTiet'])->references(['idPhieuMuonChiTiet'])->on('phieu_muon_chi_tiet')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['idPhieuTra'])->references(['idPhieuTra'])->on('phieu_tra')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phat', function (Blueprint $table) {
            $table->dropForeign('phat_idnguoidung_foreign');
            $table->dropForeign('phat_idphieumuonchitiet_foreign');
            $table->dropForeign('phat_idphieutra_foreign');
        });
    }
};
