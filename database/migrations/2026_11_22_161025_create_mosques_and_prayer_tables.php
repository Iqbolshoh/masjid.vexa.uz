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
        // 1. Districts table
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->string('name_uz');
            $table->string('name_ky')->nullable();
            $table->string('slug')->unique();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 2. Add role, phone and active status to users
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('mosque_admin')->after('email'); // superadmin, mosque_admin
            $table->string('phone')->nullable()->after('role');
            $table->boolean('is_active')->default(true)->after('phone');
        });

        // 3. Mosques table
        Schema::create('mosques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('district_id')->constrained('districts')->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('address');
            $table->string('landmark')->nullable(); // landmark / orientation point
            $table->string('phone')->nullable();
            $table->string('imam_name')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('image')->nullable();
            $table->integer('capacity')->nullable();
            $table->boolean('has_women_area')->default(false);
            $table->boolean('has_ablution')->default(true); // ablution facility
            $table->boolean('has_parking')->default(false);
            $table->text('description')->nullable();
            $table->boolean('is_verified')->default(true);
            $table->timestamps();
        });

        // 4. Prayer times table
        Schema::create('prayer_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained('mosques')->cascadeOnDelete()->unique();
            
            // Fajr prayer
            $table->string('fajr_adhan', 10)->default('05:55');
            $table->string('fajr_iqama', 10)->default('06:25');
            $table->string('sunrise', 10)->default('07:22');
            
            // Dhuhr prayer
            $table->string('dhuhr_adhan', 10)->default('12:45');
            $table->string('dhuhr_iqama', 10)->default('13:00');
            
            // Asr prayer
            $table->string('asr_adhan', 10)->default('15:15');
            $table->string('asr_iqama', 10)->default('15:30');
            
            // Maghrib prayer
            $table->string('maghrib_adhan', 10)->default('17:08');
            $table->string('maghrib_iqama', 10)->default('17:15');
            
            // Isha prayer
            $table->string('isha_adhan', 10)->default('18:40');
            $table->string('isha_iqama', 10)->default('19:00');
            
            // Friday Juma prayer
            $table->string('juma_bayan', 10)->default('12:30');
            $table->string('juma_iqama', 10)->default('13:00');
            
            // Announcements and audit
            $table->text('announcement')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 5. Prayer time edit logs
        Schema::create('prayer_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained('mosques')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->json('changes_payload')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prayer_logs');
        Schema::dropIfExists('prayer_times');
        Schema::dropIfExists('mosques');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'is_active']);
        });
        Schema::dropIfExists('districts');
    }
};
