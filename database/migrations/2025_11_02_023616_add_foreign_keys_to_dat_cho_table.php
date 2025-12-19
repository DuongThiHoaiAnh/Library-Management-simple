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
        Schema::table('dat_cho', function (Blueprint $table) {
            $table->foreign(['idNguoiDung'])->references(['idNguoiDung'])->on('nguoi_dung')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['idSach'])->references(['idSach'])->on('sach')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dat_cho', function (Blueprint $table) {
            $table->dropForeign('dat_cho_idnguoidung_foreign');
            $table->dropForeign('dat_cho_idsach_foreign');
        });
    }
};
