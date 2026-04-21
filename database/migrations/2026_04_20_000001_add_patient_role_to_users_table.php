<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Change the enum on users.role to include 'patient'
        // SQLite doesn't support ALTER COLUMN enum, so we use a raw statement for MySQL
        // For SQLite compatibility (used in testing), we'll use a workaround
        try {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'doctor', 'nurse', 'secretary', 'patient') NOT NULL DEFAULT 'doctor'");
        } catch (\Exception $e) {
            // SQLite fallback: no-op (SQLite stores as TEXT anyway)
        }

        // Step 2: Add user_id to patients table if it doesn't exist
        if (!Schema::hasColumn('patients', 'user_id')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('patients', 'user_id')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }

        try {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'doctor', 'nurse', 'secretary') NOT NULL DEFAULT 'doctor'");
        } catch (\Exception $e) {
            // SQLite fallback
        }
    }
};
