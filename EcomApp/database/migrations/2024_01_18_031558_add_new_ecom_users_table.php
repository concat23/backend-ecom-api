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
        // Check if the 'ecom_users' table exists
        if (!Schema::hasTable('ecom_users')) {
            Schema::create('ecom_users', function (Blueprint $table) {
                $table->id();
                $table->string('user_avatar', 250)->nullable()->comment('User avatar');
                $table->unsignedBigInteger('account_type')->nullable()->comment('Account type');
                $table->timestamps();

                // Foreign key constraint
                $table->foreign('account_type', 'ecom_users_FK_1')
                    ->references('id')
                    ->on('ecom_account_types')
                    ->onUpdate('RESTRICT')
                    ->onDelete('RESTRICT');
            });
        } else {
            // Modify existing 'ecom_users' table
            Schema::table('ecom_users', function (Blueprint $table) {
                if (!Schema::hasColumn('ecom_users', 'user_avatar')) {
                    $table->string('user_avatar', 250)->nullable()->comment('User avatar');
                }
                if (!Schema::hasColumn('ecom_users', 'account_type')) {
                    $table->unsignedBigInteger('account_type')->nullable()->comment('Account type');
                }

                // Check if the foreign key already exists
                if (!$this->isForeignKey('ecom_users', 'ecom_users_FK_1')) {
                    $table->engine = 'InnoDB';
                    $table->foreign('account_type', 'ecom_users_FK_1')
                        ->references('id')
                        ->on('ecom_account_types')
                        ->onUpdate('RESTRICT')
                        ->onDelete('RESTRICT');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'ecom_users' table if it was created in this migration
        Schema::dropIfExists('ecom_users');
    }

    /**
     * Check if a foreign key exists on a specific column
     */
    function isForeignKey(string $table, string $fkName): bool
    {
        $fkColumns = Schema::getConnection()
            ->getDoctrineSchemaManager()
            ->listTableForeignKeys($table);

        return collect($fkColumns)->pluck('name')->contains($fkName);
    }
};
