<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('building_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_num')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_type')->nullable();
            $table->date('file_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
