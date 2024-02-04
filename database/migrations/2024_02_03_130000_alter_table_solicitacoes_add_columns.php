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
        Schema::table('wp_mi_solicitacoes', function (Blueprint $table) {
            $table->string('produto_nome')->nullable();
            $table->decimal('produto_vaza_diaria', 8, 2)->nullable();
            $table->decimal('produto_vaza_horaria_media', 8, 2)->nullable();
            $table->integer('produto_quantidade')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('wp_mi_solicitacoes', function (Blueprint $table) {
            $table->dropColumn('produto_nome');
            $table->dropColumn('produto_vaza_diaria');
            $table->dropColumn('produto_vaza_horaria_media');
            $table->dropColumn('produto_quantidade');
        });
    }
};
