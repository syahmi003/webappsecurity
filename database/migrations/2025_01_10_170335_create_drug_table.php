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
        Schema::create('drug', function (Blueprint $table) {
            $table->id();
            $table->string('drug_name');
            $table->date('manufacture_date');
            $table->date('expiry_date');
            $table->decimal('price', 8, 2);
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drug');
    }
};
