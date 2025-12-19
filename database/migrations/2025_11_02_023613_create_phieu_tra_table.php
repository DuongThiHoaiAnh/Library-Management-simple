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
        Schema::create('phieu_tra', function (Blueprint $table) {
            $table->bigIncrements('idPhieuTra');
            $table->unsignedBigInteger('idPhieuMuonChiTiet')->index('phieu_tra_idphieumuonchitiet_foreign');
            $table->date('ngayTra');
            $table->string('trangThaiXuLy', 20)->default('processed');
            $table->string('ghiChu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phieu_tra');
    }
};
