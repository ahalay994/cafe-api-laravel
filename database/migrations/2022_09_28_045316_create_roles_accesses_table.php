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
        Schema::create('roles_accesses', function (Blueprint $table) {
            $table
                ->foreignId('role_id')
                ->constrained('roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreignId('access_id')
                ->constrained('accesses')
                ->onUpdate('cascade')
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
        Schema::dropIfExists('roles_accesses');
    }
};
