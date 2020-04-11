<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id')->unique();
            $table->string('surname');
            $table->string('firstName');
            $table->string('otherNames');
            $table->enum('gender', ['male', 'female']);
            $table->string('dob');
            $table->string('address');
            $table->string('origin');
            $table->string('mobile');
            $table->string('kinName');
            $table->string('kinAddress');
            $table->string('kinPhone');
            $table->enum('registeration_type', ['individual', 'family'])->default('individual');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
