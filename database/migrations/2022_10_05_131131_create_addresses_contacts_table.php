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
        Schema::create('addresses_contacts', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('address_id')
                ->constrained('addresses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->enum('type', ['phone', 'email']);
            $table->string('value');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('addresses_contacts');
    }
};
