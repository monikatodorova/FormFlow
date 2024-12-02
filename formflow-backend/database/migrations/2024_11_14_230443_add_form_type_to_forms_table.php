<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->enum('form_type', ['default', 'builder', 'ai'])->nullable()->after('name');
            $table->json('fields')->nullable()->after('form_type');         
        });

        DB::table('forms')->update(['form_type' => 'default']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn('form_type');
            $table->dropColumn('fields');
        });
    }
};
