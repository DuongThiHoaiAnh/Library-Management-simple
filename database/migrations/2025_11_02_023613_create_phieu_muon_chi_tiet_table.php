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
        Schema::create('phieu_muon_chi_tiet', function (Blueprint $table) {
            $table->bigIncrements('idPhieuMuonChiTiet');
            $table->unsignedBigInteger('idPhieuMuon')->index('phieu_muon_chi_tiet_idphieumuon_foreign');
            $table->unsignedBigInteger('idSach')->index('phieu_muon_chi_tiet_idsach_foreign');
            $table->date('borrow_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('trangThaiCT', 20)->default('borrowed');
            $table->string('ghiChu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phieu_muon_chi_tiet');
    }
};
