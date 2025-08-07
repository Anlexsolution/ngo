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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('meeting_title');
            $table->date('meeting_date');
            $table->time('meeting_time');
            $table->string('resource_person')->nullable();
            $table->string('resource_position')->nullable();
            $table->string('resource_contact_no')->nullable();
            $table->string('meeting_type');
            $table->integer('division_id')->nullable();
            $table->integer('village_id')->nullable();
            $table->integer('small_group_id')->nullable();
            $table->longText('memberData')->nullable();

            $table->timestamps();

            // Optional: If you want to enforce foreign keys
            // $table->foreign('division_id')->references('id')->on('divisions')->onDelete('set null');
            // $table->foreign('village_id')->references('id')->on('villages')->onDelete('set null');
            // $table->foreign('small_group_id')->references('id')->on('small_groups')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
