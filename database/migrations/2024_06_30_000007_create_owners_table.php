<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTable extends Migration
{
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gender')->nullable(); 
            $table->string('identity_num')->nullable();
            $table->date('identity_date')->nullable();
            $table->string('address')->nullable();
            $table->string('commerical_num')->nullable();
            $table->string('real_estate_identity')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
