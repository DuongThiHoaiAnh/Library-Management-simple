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
        Schema::create('phat', function (Blueprint $table) {
            $table->bigIncrements('idPhat');
            $table->unsignedBigInteger('idPhieuTra')->nullable()->index('phat_idphieutra_foreign');
            $table->unsignedBigInteger('idPhieuMuonChiTiet')->nullable()->index('phat_idphieumuonchitiet_foreign');
            $table->unsignedBigInteger('idNguoiDung')->nullable()->index('phat_idnguoidung_foreign');
            $table->integer('soNgayTre')->default(0);
            $table->decimal('soTienPhat', 10)->default(0);
            $table->string('trangThaiThanhToan', 20)->default('pending');
            $table->string('ghiChu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phat');
    }
};
