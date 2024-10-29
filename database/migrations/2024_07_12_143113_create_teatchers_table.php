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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id(); // Creates an unsignedBigInteger 'id'
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('name');
            $table->string('ppr')->unique();
            $table->unsignedBigInteger('subject_id')->nullable(); // Should be unsignedBigInteger to match 'id'
            $table->string('province');
            $table->string('etablissement');
            $table->timestamps();
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
                ->onDelete('set null'); // Foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teatchers');
    }
};