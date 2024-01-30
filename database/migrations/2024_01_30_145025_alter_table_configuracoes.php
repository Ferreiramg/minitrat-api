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
        Schema::table('configuracoes', function (Blueprint $table) {
            $table->increments('id');
          
            $table->decimal('taxa_infiltracao', 8, 5)->change()->default(0.01296);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configuracoes', function (Blueprint $table) {

            $table->float('taxa_infiltracao')->change()->default(0.01296);
        });
    }
};
