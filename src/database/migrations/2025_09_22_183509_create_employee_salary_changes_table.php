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
        Schema::create('employee_salary_changes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('employee_id')->comment('employee_id=user_id');
            $table->decimal('previous_salary',10,2);
            $table->decimal('present_salary',10,2);
            $table->decimal('increment_salary',10,2);
            $table->date('effective_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_salary_changes');
    }
};
