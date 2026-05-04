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
            $table->integer('age')->nullable();
            $table->string('education')->nullable();
            $table->string('profile_image')->nullable();
            
            // Teacher fields
            $table->string('expertise')->nullable();
            $table->text('teaching_experience')->nullable();
            
            // Student fields
            $table->text('academic_info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'age',
                'education',
                'profile_image',
                'expertise',
                'teaching_experience',
                'academic_info'
            ]);
        });
    }
};
