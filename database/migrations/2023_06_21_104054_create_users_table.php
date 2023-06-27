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
        Schema::create('users', function (Blueprint $table) {
           	$table->id();
			$table->string('first_name');
			$table->string('last_name');
			$table->string('patronymic');
			$table->string('email')->unique();
			$table->string('password');
			$table->text('description')->default("Нет описания");
			$table->string('city')->default("Нет города");
			$table->string('age')->default("Нет возраста");
			$table->string('avatar')->default("avatar-default.png");
			$table->rememberToken();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
