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
        Schema::create('dat_cho', function (Blueprint $table) {
            $table->bigIncrements('idDatCho');
            $table->unsignedBigInteger('idNguoiDung')->index('dat_cho_idnguoidung_foreign');
            $table->unsignedBigInteger('idSach')->index('dat_cho_idsach_foreign');
            $table->date('ngayDat');
            $table->string('status', 20)->default('waiting');
            $table->unsignedInteger('queueOrder')->default(0);
            $table->date('thoiGianHetHan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dat_cho');
    }
};
