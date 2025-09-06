<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_subjects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('class_id'); 
            $table->uuid('subject_id');
            $table->double('full_mark');
            $table->double('pass_mark');
            $table->double('subjective_mark');
            $table->timestamps();
            $table->softDeletes();
            //Protect integrity with a unique composite index.
            $table->unique(['class_id', 'subject_id'], 'assign_subjects_class_subject_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assign_subjects');
    }
};
