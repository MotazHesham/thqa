<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBuildingSaksTable extends Migration
{
    public function up()
    {
        Schema::table('building_saks', function (Blueprint $table) {
            $table->unsignedBigInteger('building_id')->nullable();
            $table->foreign('building_id', 'building_fk_9914257')->references('id')->on('buildings');
            $table->unsignedBigInteger('building_folder_id')->nullable();
            $table->foreign('building_folder_id', 'building_folder_fk_9224247')->references('id')->on('building_folders'); 
        });
    }
}
