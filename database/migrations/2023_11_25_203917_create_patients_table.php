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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('IdCard', 20);
            $table->string('Gender', 10)->nullable();
            $table->string('Name', 50);
            $table->string('Surname', 50);
            $table->string('DateOfBirth');
            $table->string('Address', 100)->nullable();
            $table->string('Postcode', 20)->nullable();
            $table->string('ContactNumber1', 25);
            $table->string('ContactNumber2', 25)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
