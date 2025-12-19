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
        Schema::create('thong_bao', function (Blueprint $table) {
            $table->bigIncrements('idThongBao');
            $table->unsignedBigInteger('idNguoiDung')->index('thong_bao_idnguoidung_foreign');
            $table->unsignedBigInteger('idSach')->nullable()->index('thong_bao_idsach_foreign');
            $table->unsignedBigInteger('idPhieuMuon')->nullable()->index('thong_bao_idphieumuon_foreign');
            $table->unsignedBigInteger('idPhat')->nullable();
            $table->unsignedBigInteger('idDatCho')->nullable();
            $table->unsignedBigInteger('idPhieuTra')->nullable();
            $table->string('loaiThongBao', 50)->nullable();
            $table->text('noiDung')->nullable();
            $table->dateTime('thoiGianGui')->useCurrent();
            $table->string('trangThai', 20)->default('unread');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thong_bao');
    }
};
