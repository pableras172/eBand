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
        Schema::create('paymetresume', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 255, []);
            $table->string('document', 255, [])->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamp('created_at', [])->nullable();
            $table->timestamp('updated_at', [])->nullable();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paymetresume');
    }
};
