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
        Schema::table('thong_bao', function (Blueprint $table) {
            $table->foreign(['idNguoiDung'])->references(['idNguoiDung'])->on('nguoi_dung')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['idPhieuMuon'])->references(['idPhieuMuon'])->on('phieu_muon')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['idSach'])->references(['idSach'])->on('sach')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thong_bao', function (Blueprint $table) {
            $table->dropForeign('thong_bao_idnguoidung_foreign');
            $table->dropForeign('thong_bao_idphieumuon_foreign');
            $table->dropForeign('thong_bao_idsach_foreign');
        });
    }
};
