<?php
/**
 * Part of the Sentinel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Sentinel
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MigrationCartalystSentinel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email');
			$table->string('password');
			$table->text('permissions')->nullable();
			$table->timestamp('last_login')->nullable();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->timestamps();

			$table->engine = 'InnoDB';
			$table->unique('email');
		});

		Schema::create('groups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('slug');
			$table->string('name');
			$table->text('permissions')->nullable();
			$table->timestamps();

			$table->engine = 'InnoDB';
			$table->unique('slug');
		});

		Schema::create('groups_users', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('group_id')->unsigned();
			$table->nullableTimestamps();

			$table->engine = 'InnoDB';
			$table->primary(['user_id', 'group_id']);
		});

		Schema::create('persistences', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('code');
			$table->timestamps();

			$table->engine = 'InnoDB';
			$table->unique('code');
		});

		Schema::create('throttle', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('type');
			$table->string('ip')->nullable();
			$table->timestamps();

			$table->engine = 'InnoDB';
			$table->index('user_id');
		});

		Schema::create('activations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('code');
			$table->boolean('completed')->default(0);
			$table->timestamp('completed_at')->nullable();
			$table->timestamps();
		});

		Schema::create('reminders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('code');
			$table->boolean('completed')->default(0);
			$table->timestamp('completed_at')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reminders');
		Schema::drop('activations');
		Schema::drop('throttle');
		Schema::drop('persistences');
		Schema::drop('groups_users');
		Schema::drop('groups');
		Schema::drop('users');
	}

}
