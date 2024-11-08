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
            $table->date('file_date_end')->nullable();
            $table->date('file_date_hijri')->nullable();
            $table->date('file_date_hijri_end')->nullable();
            $table->string('status')->default('active');
            $table->string('dropbox_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
