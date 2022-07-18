<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmployeeDepartment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_department', function (Blueprint $table) {

            $table->integer('employee_id')->unsigned();
        
            $table->integer('department_id')->unsigned();
        
            $table->foreign('employee_id')->references('id')->on('employees')
        
                ->onDelete('cascade');
        
            $table->foreign('department_id')->references('id')->on('departments')
        
                ->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_department');
    }
}
