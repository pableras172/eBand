<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('users_id', []);
            $table->dateTime('fechaPago', []);
            $table->string('descripcion', 255, []);
            $table->dateTime('fechaInicio', []);
            $table->dateTime('fechaFin', []);
            $table->decimal('totalPago', 8, 2)->default(0);
            $table->boolean('confirmadausuaroi')->default(false);
            $table->decimal('paymentresume_id', 8, 2)->default(0);    
            $table->timestamp('created_at', [])->nullable();
            $table->timestamp('updated_at', [])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment');
    }
};
