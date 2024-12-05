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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('unit_id')->nullable();
            $table->string('unit')->nullable();
            $table->string('locationID')->nullable();
            $table->dateTime('date')->nullable();
            $table->enum('status', ['0', '1'])->default('0')->comment('0 -> Active, 1->Inactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
