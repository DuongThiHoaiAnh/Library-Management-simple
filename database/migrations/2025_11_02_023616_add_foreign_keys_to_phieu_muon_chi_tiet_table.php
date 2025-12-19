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
        Schema::table('phieu_muon_chi_tiet', function (Blueprint $table) {
            $table->foreign(['idPhieuMuon'])->references(['idPhieuMuon'])->on('phieu_muon')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['idSach'])->references(['idSach'])->on('sach')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phieu_muon_chi_tiet', function (Blueprint $table) {
            $table->dropForeign('phieu_muon_chi_tiet_idphieumuon_foreign');
            $table->dropForeign('phieu_muon_chi_tiet_idsach_foreign');
        });
    }
};
