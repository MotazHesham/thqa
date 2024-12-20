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
            $table->date('date')->nullable();
            $table->string('date_hijri')->nullable();
            $table->string('dropbox_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
