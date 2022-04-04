<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRacesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('races', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(App\Models\Club::class)->constrained();
			$table->string('title', 100);
			$table->dateTime('race_date');
			$table->string('start_time', 20);
			$table->string('address', 100);
			$table->string('suburb', 50);
			$table->string('postcode', 4);
			$table->foreignIdFor(App\Models\State::class)->constrained();
			$table->enum('status', array_keys(App\Models\Race::getStatusOptions()));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('races');
	}
}
