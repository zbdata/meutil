<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1547848381ControleDoPontosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('controle_do_pontos')) {
            Schema::create('controle_do_pontos', function (Blueprint $table) {
                $table->increments('id');
                $table->date('data')->nullable();
                $table->tinyInteger('falta')->nullable()->default('0');
                $table->tinyInteger('feriado')->nullable()->default('0');
                
                $table->timestamps();
                $table->softDeletes();

                $table->index(['deleted_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('controle_do_pontos');
    }
}
