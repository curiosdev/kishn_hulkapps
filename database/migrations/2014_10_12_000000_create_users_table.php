<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role');
            $table->rememberToken();
            $table->timestamps();
        });


        // Insert some stuff
        DB::table('users')->insert(
            array(
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 'Admin'
            )
        );


        DB::table('users')->insert(
          
            array(
                'name' => 'Doctor 1',
                'email' => 'doctor1@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 'Doctor'
            )
        );

        DB::table('users')->insert(
           
            array(
                'name' => 'Doctor 2',
                'email' => 'doctor2@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 'Doctor'
            )
        );

        DB::table('users')->insert(
           
            array(
                'name' => 'Doctor 3',
                'email' => 'doctor3@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 'Doctor'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
