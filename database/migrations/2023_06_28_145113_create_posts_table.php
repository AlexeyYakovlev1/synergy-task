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
		if (!Schema::hasTable("posts"))
		{
			Schema::create("posts", function (Blueprint $table)
			{
				$table->id();
				$table->integer("likes")->default(0);
				$table->integer("dislikes")->default(0);
				$table->integer("comments")->default(0);
				$table->longText("content");
				$table->string("cover")->default("");
				$table->timestamps();
			});
		}

		Schema::table("posts", function (Blueprint $table)
		{
			$table->unsignedBigInteger("owner_id");
			$table->foreign("owner_id")->references("id")->on("users");
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("posts");
    }
};
