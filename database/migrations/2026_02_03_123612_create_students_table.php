<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->date('dob')->nullable();
            $table->string('country_of_interest')->nullable();
            $table->enum('current_stage', [
                'lead',
                'counseling',
                'payment',
                'application',
                'offer',
                'visa',
                'enrolled',
            ])->default('lead');
            $table->string('current_status', 50)->nullable();

            $table->foreignId('assigned_marketing_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_consultant_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_application_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['current_stage', 'current_status']);
            $table->index(['assigned_marketing_id', 'assigned_consultant_id', 'assigned_application_id'], 'students_assignment_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
