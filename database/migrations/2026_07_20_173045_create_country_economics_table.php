<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('country_economics', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            $table->decimal('gdp',20,2)->nullable();

            $table->decimal('inflation',8,2)->nullable();

            $table->decimal('export',20,2)->nullable();

            $table->decimal('import',20,2)->nullable();

            $table->year('year')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('country_economics');
    }
};