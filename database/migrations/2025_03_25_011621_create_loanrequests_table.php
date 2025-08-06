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
        Schema::create('loanrequests', function (Blueprint $table) {
            $table->id();
            $table->integer('memberId');
            $table->integer('loanAmount');
            $table->integer('mainCategoryId');
            $table->integer('subCategoryId');
            $table->integer('userTypeId');
            $table->integer('status');
            $table->text('documents')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loanrequests');
    }
};
