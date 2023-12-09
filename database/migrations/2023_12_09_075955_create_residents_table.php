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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('fname', 150);
            $table->string('mname', 100)->nullable();
            $table->string('lname', 100);
            $table->date('birthdate');
            $table->enum('gender', ['male', 'female', 'others']);
            $table->string('phone', 13);
            $table->integer('household_no');
            $table->integer('zone');
            $table->enum('civil_status', ['single', 'married', 'widowed', 'separated']);
            $table->string('occupation', 150);
            $table->string('nationality', 100);
            $table->boolean('fourps_member');
            $table->boolean('fully_vaxxed');
            $table->boolean('voter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
