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

        Schema::table('notes', function (Blueprint $table) {
            $table->string('exam')->after('class_name'); // Add exam field as string
            $table->enum('semester', ['Semester 1', 'Semester 2'])->after('exam'); // Add semester field as enum
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            //
        });
    }
};