<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1547848475UsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            
if (!Schema::hasColumn('users', 'matricula')) {
                $table->integer('matricula')->nullable()->unsigned();
                }
if (!Schema::hasColumn('users', 'almoco')) {
                $table->time('almoco')->nullable();
                }
if (!Schema::hasColumn('users', 'cargahoraria')) {
                $table->time('cargahoraria')->nullable();
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('matricula');
            $table->dropColumn('almoco');
            $table->dropColumn('cargahoraria');
            
        });

    }
}
