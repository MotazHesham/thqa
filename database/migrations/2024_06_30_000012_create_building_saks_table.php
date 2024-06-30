<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingSaksTable extends Migration
{
    public function up()
    {
        Schema::create('building_saks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sak_num');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
