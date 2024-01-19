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
        Schema::table('ecom_users', function (Blueprint $table) {
            $table->string('salt')->after('email')->nullable();
            $table->string('secret_key')->after('salt')->nullable();
            $table->string('first_name')->after('secret_key')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecom_users', function (Blueprint $table) {
            $table->dropColumn(['salt', 'secret_key', 'first_name', 'last_name']);
        });
    }
};
