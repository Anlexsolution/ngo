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
        Schema::create('resourcepeople', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->unsignedBigInteger('division_id')->nullable();
            $table->unsignedBigInteger('village_id')->nullable();
            $table->string('type')->nullable();
            $table->string('designation')->nullable();
            $table->unsignedBigInteger('main_qualification')->nullable();
            $table->unsignedBigInteger('sub_qualification')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('nic', 20)->nullable();
            $table->string('contact_no', 20)->nullable();
            $table->string('whatsapp_no', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resourcepeople');
    }
};
