<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up()
	{
		Schema::create('riders', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(App\Models\User::class)->constrained();
			$table->tinyInteger('grading');
			$table->tinyInteger('age');
			$table->enum('gender', array_keys(App\Models\Rider::getGenderOptions()));
			$table->foreignIdFor(App\Models\Club::class)->constrained();
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('riders');
	}
};
