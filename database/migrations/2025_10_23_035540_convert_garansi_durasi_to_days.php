<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('garansis', function (Blueprint $table) {
            DB::table('garansis')
                ->where('durasi', '>', 0)
                ->update([
                    'durasi' => DB::raw('durasi * 30')
                ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('garansis', function (Blueprint $table) {
            DB::table('garansis')
                ->where('durasi', '>', 0)
                ->update([
                    'durasi' => DB::raw('durasi / 30')
                ]);
        });
    }
};
