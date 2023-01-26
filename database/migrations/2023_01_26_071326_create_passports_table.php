<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable("passports")) {
			Schema::create('passports', function (Blueprint $table) {
				$table->id();
				$table->string("series");
				$table->string("num");
				$table->timestamps();
			});
		}

		Schema::table("passports", function (Blueprint $table) {
			$table->unsignedBigInteger('user_id');
			$table->foreign("user_id")->references("id")->on("users");
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passports');
    }
};
