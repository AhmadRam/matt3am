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
        // Schema::create('locales', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('code');
        //     $table->string('direction')->default('ltr');
        //     $table->string('logo')->nullable();
        //     $table->boolean('status');
        //     $table->timestamps();
        // });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('locales');
    }
};
