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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('group_id')->nullable();
            $table->index('group_id', 'schedule_group_idx');
            $table->foreign('group_id', 'schedule_group_fk')->references('id')->on('groups')->onDelete('cascade');

            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->index('teacher_id', 'schedule_teacher_idx');
            $table->foreign('teacher_id', 'schedule_teacher_fk')->references('id')->on('teachers')->onDelete('cascade');

            $table->string('time');
            $table->date('date');
            $table->string('lesson');
            $table->string('room');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->index('category_id', 'schedule_category_idx');
            $table->foreign('category_id', 'schedule_category_fk')->references('id')->on('categories')->onDelete('cascade');

            $table->integer('position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
