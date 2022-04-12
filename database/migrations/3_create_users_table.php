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
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('first_name', 100);
			$table->string('surname', 100);
			$table->string('email', 255)->unique();
			$table->string('password');
			$table->enum('role', array_keys(App\Models\User::getRoleOptions()));
			$table->foreignIdFor(App\Models\Club::class)->nullable()->constrained();
			$table->enum('status', array_keys(App\Models\User::getStatusOptions()));
			$table->timestamp('email_verified_at')->nullable();
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
};
