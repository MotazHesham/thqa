<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingsTable extends Migration
{
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->string('map_lat');
            $table->string('map_long');
            $table->text('details')->nullable();
            $table->string('address')->nullable();
            $table->string('building_type');
            $table->string('building_status');
            $table->date('owned_date');
            $table->date('registration_date');
            $table->string('survey_descision')->nullable();
            $table->string('commerical_num')->nullable();
            $table->string('real_estate_identity')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
