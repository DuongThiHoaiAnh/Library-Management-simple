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
        Schema::create('nguoi_dung', function (Blueprint $table) {
            $table->bigIncrements('idNguoiDung');
            $table->string('hoTen', 100);
            $table->string('email', 100)->unique();
            $table->string('matKhau');
            $table->string('soDienThoai', 20)->nullable()->index();
            $table->string('diaChi')->nullable();
            $table->string('vaiTro', 20)->default('reader');
            $table->timestamp('ngayDangKy')->useCurrent();

            $table->boolean('trangThai')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nguoi_dung');
    }
};
