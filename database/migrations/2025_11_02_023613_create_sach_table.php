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
        Schema::create('sach', function (Blueprint $table) {
            $table->bigIncrements('idSach');
            $table->string('maSach', 50)->nullable()->index();
            $table->string('tenSach', 200)->index();
            $table->string('tacGia', 200)->nullable();
            $table->year('namXuatBan')->nullable();
            $table->integer('soLuong')->default(1);
            $table->unsignedBigInteger('idDanhMuc')->index('sach_iddanhmuc_foreign');
            $table->text('moTa')->nullable();
            $table->string('vitri', 100)->nullable();
            $table->string('anhBia')->nullable();
            $table->string('trangThai', 20)->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sach');
    }
};
