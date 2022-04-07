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
		Schema::create('entrants', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(App\Models\Race::class)->constrained();
			$table->foreignIdFor(App\Models\Rider::class)->constrained();
			$table->tinyInteger('place')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('entrants');
	}
};
