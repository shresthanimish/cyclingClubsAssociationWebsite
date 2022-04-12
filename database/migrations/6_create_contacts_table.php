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
		Schema::create('contact_form_submissions', function (Blueprint $table) {
			$table->id();
			$table->string('name', 150);
			$table->string('email', 255);
			$table->string('phone', 12);
			$table->string('subject', 255);
			$table->string('message', 1000);
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('contacts');
	}
};
