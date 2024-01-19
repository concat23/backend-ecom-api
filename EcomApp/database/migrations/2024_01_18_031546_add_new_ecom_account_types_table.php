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
        $tableName = 'ecom_account_types';

        // Check if the table doesn't exist before creating it
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id()->comment('ID');
                $table->string('account_type_name', 100)->nullable(false)->comment('Account type name');
                $table->unsignedBigInteger('language')->nullable(false)->comment('Language classification');
                $table->timestamps(); // Add timestamps if needed
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecom_account_types');
    }
};
