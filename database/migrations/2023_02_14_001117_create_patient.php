<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mother_name');
            $table->date('birthdate');
            $table->string('cpf',14)->unique(); 
            $table->string('cns', 15)->unique(); 
            $table->string('cep', 9);
            $table->string('street');
            $table->string('number');
            $table->string('complement')->nullable(true)->default(null);
            $table->string('neighborhood');
            $table->string('city');
            $table->string('state');
            $table->string('path_picture');
            $table->boolean('deleted')->default(0)->comment('indicates whether the user has been deleted or inactivated');
            $table->timestamp('deleted_at')->nullable(true)->default(null)->comment('date the user was deleted or inactivated');
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
        Schema::dropIfExists('patient');
    }
}
