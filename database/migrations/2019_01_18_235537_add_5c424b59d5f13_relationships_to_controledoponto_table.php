<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c424b59d5f13RelationshipsToControleDoPontoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('controle_do_pontos', function(Blueprint $table) {
            if (!Schema::hasColumn('controle_do_pontos', 'matricula_id')) {
                $table->integer('matricula_id')->unsigned()->nullable();
                $table->foreign('matricula_id', '26161_5c424b5965973')->references('id')->on('users')->onDelete('cascade');
                }
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('controle_do_pontos', function(Blueprint $table) {
            
        });
    }
}
