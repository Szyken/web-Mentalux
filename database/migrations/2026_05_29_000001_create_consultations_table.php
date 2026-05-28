<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id');
            $table->integer('psychologist_id')->nullable();
            $table->string('psychologist_name', 255);
            $table->enum('status', ['active', 'ended'])->default('active');
            $table->timestamps();

            // Index untuk performa query
            $table->index('patient_id');
            $table->index('psychologist_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};

