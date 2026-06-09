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
        /*Schema::create('medicals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });*/
        Schema::create('medical', function (Blueprint $table) {
            $table->id();
            $table->string('record_id');
            $table->string('patient_name');
            $table->string('diagnosis');
            $table->string('treatment');
            $table->string('doctor');
            $table->date('date_of_record');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicals');
    }
};
