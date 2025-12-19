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
        Schema::create('phieu_muon', function (Blueprint $table) {
            $table->bigIncrements('idPhieuMuon');
            $table->unsignedBigInteger('idNguoiDung')->index('phieu_muon_idnguoidung_foreign');
            $table->date('ngayMuon');
            $table->date('hanTra');
            $table->string('trangThai', 20)->default('pending');
            $table->string('ghiChu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phieu_muon');
    }
};
