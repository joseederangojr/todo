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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table
                ->enum('status', ['triage', 'todo', 'doing', 'done', 'abandon'])
                ->default('triage');
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('space_id');
            $table->unsignedBigInteger('space_column_id');
            $table->unsignedBigInteger('assigned_to_id')->nullable();
            $table->unsignedBigInteger('created_by_id');
            $table->unsignedBigInteger('updated_by_id');
            $table->timestamps();
            $table->softDeletes();

            $table
                ->foreign('assigned_to_id')
                ->references('id')
                ->on('users');
            $table
                ->foreign('created_by_id')
                ->references('id')
                ->on('users');
            $table
                ->foreign('updated_by_id')
                ->references('id')
                ->on('users');
            $table
                ->foreign('space_id')
                ->references('id')
                ->on('spaces');

            $table
                ->foreign('space_column_id')
                ->references('id')
                ->on('space_columns')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
