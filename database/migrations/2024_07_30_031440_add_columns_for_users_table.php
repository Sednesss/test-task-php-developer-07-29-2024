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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('remember_token');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('father_name')->nullable()->after('last_name');
            $table->string('phone')->nullable()->after('father_name');
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->string('address')->nullable()->after('date_of_birth');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('phone');
            $table->dropColumn('father_name');
            $table->dropColumn('last_name');
            $table->dropColumn('first_name');
        });
    }
};
