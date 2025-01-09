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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('symbol');
            // $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('currency_exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('base_currency')->constrained('currencies')->cascadeOnDelete();
            $table->foreignId('target_currency')->constrained('currencies')->cascadeOnDelete();
            $table->decimal('rate', 10, 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_exchange_rates');
        Schema::dropIfExists('currencies');
    }
};
