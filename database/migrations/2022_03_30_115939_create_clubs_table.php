<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clubs', function (Blueprint $table) {
			$table->id();
			$table->string('title', 100)->unique();
			$table->string('address', 100);
			$table->string('suburb', 50);
			$table->string('postcode', 4);
			$table->foreignIdFor(App\Models\State::class)->constrained();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('clubs');
	}
}
