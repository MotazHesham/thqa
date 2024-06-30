<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBuildingsTable extends Migration
{
    public function up()
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->foreign('owner_id', 'owner_fk_9914219')->references('id')->on('owners');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9914230')->references('id')->on('users');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id', 'country_fk_9914263')->references('id')->on('countries');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id', 'city_fk_9914264')->references('id')->on('cities');
        });
    }
}
